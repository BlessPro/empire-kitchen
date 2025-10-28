<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ConversationController extends Controller
{
    /**
     * GET /conversations?query=&page=1
     * Returns items for the left pane.
     */
    public function index(Request $request)
    {
        $me   = $request->user()->id;
        $q    = trim((string) $request->query('query', ''));
        $size = (int) $request->query('per_page', 20);

        // Base: conversations I participate in
        $base = DB::table('conversation_participants as p')
            ->join('conversations as c', 'c.id', '=', 'p.conversation_id')
            ->leftJoin('messages as m', 'm.id', '=', 'c.last_message_id')
            ->where('p.user_id', $me)
            ->select([
                'c.id', 'c.type', 'c.title', 'c.avatar_url',
                'c.last_message_at',
                'm.body as preview',
                'm.sender_id as preview_sender_id',
                'p.last_read_at',
            ]);

        // Quick search:
        // - Groups: title LIKE %q%
        // - DMs: we filter after we fetch (by other participant name/role), to keep SQL simple.
        if ($q !== '') {
            $base->where(function ($w) use ($q) {
                $w->where(function ($w2) use ($q) {
                    $w2->where('c.type', 'group')
                       ->where('c.title', 'like', "%{$q}%");
                });
                // (DM name search is applied later in PHP after we hydrate "other" user)
            });
        }

        $rows = $base
            ->orderByDesc('c.last_message_at')
            ->paginate($size);

        // Collect other user ids for DMs so we can hydrate name/role/avatar from employees.
        $dmConversationIds = [];
        foreach ($rows as $r) {
            if ($r->type === 'direct') {
                $dmConversationIds[] = $r->id;
            }
        }

        $otherByConversation = [];
        if (!empty($dmConversationIds)) {
            // Map: conversation_id -> other_user_id
            $rawOthers = DB::table('conversation_participants as cp2')
                ->whereIn('cp2.conversation_id', $dmConversationIds)
                ->where('cp2.user_id', '<>', $me)
                ->select('cp2.conversation_id', 'cp2.user_id')
                ->get();

            $otherUserIds = $rawOthers->pluck('user_id')->unique()->values()->all();

            // Fetch employee display fields for those users
            $displayByUser = [];
            if (!empty($otherUserIds)) {
                $displayRows = DB::table('users as u')
                    ->leftJoin('employees as e', 'e.id', '=', 'u.employee_id')
                    ->whereIn('u.id', $otherUserIds)
                    ->select('u.id as user_id', 'e.name', 'e.designation', 'e.avatar_path')
                    ->get();

                foreach ($displayRows as $dr) {
                    $displayByUser[$dr->user_id] = [
                        'name'        => $dr->name ?? 'Unknown',
                        'designation' => $dr->designation ?? '',
                        'avatar'      => $this->formatAvatar($dr->avatar_path) ?? $this->defaultUserAvatar(),
                    ];
                }
            }

            foreach ($rawOthers as $o) {
                $otherByConversation[$o->conversation_id] = (int) $o->user_id;
            }
        }

        // Build response items
        $items = [];
        foreach ($rows as $r) {
            $isDM = $r->type === 'direct';

            $title     = $r->title;
            $subtitle  = null;
            $avatarUrl = $this->formatAvatar($r->avatar_url);

            if ($isDM) {
                $otherId = $otherByConversation[$r->id] ?? null;
                if ($otherId !== null) {
                    $disp = $displayByUser[$otherId] ?? null;
                    if ($disp) {
                        $title     = $disp['name'] ?: $title;
                        $subtitle  = $disp['designation'] ?: null;
                        $avatarUrl = $disp['avatar'] ?: $avatarUrl;
                    }
                }

                if (!$avatarUrl) {
                    $avatarUrl = $this->defaultUserAvatar();
                }
            } else {
                $avatarUrl = $avatarUrl ?: $this->groupAvatar($r->id);
            }

            // If there was a DM search term, filter here by other participant name/designation
            if ($q !== '' && $isDM) {
                $hay = mb_strtolower(trim(($title ?? '') . ' ' . ($subtitle ?? '')));
                if (mb_strpos($hay, mb_strtolower($q)) === false) {
                    // Skip this DM if it doesn't match search
                    continue;
                }
            }

            $lastMessageAt = $r->last_message_at ? Carbon::parse($r->last_message_at) : null;
            $lastReadAt    = $r->last_read_at ? Carbon::parse($r->last_read_at) : null;

            $items[] = [
                'id'                      => (int) $r->id,
                'type'                    => $r->type,
                'title'                   => $title,
                'subtitle'                => $subtitle,
                'avatar'                  => $avatarUrl,
                'preview'                 => $r->preview,
                'preview_is_me'           => (bool) ($r->preview_sender_id === $me),
                'last_message_at'         => $lastMessageAt ? $lastMessageAt->toDateTimeString() : null,
                'last_message_at_human'   => $lastMessageAt ? $lastMessageAt->diffForHumans() : null,
                'has_unread'              => $lastMessageAt && (!$lastReadAt || $lastReadAt->lt($lastMessageAt)),
            ];
        }

        // Rebuild pagination meta manually if we filtered DMs post-query
        return response()->json([
            'data' => $items,
            'meta' => [
                'current_page' => $rows->currentPage(),
                'per_page'     => $rows->perPage(),
                'total'        => $rows->total(), // may be slightly off if DM filtering removed some rows; OK for MVP
            ],
        ]);
    }

public function markRead(\Illuminate\Http\Request $request, int $conversation)
{
    $me = $request->user()->id;

    // Must be a participant
    $participant = DB::table('conversation_participants')
        ->where('conversation_id', $conversation)
        ->where('user_id', $me)
        ->first();

    if (!$participant) {
        return response()->json(['ok' => false, 'error' => 'Forbidden'], 403);
    }

    $now = now();
    $previousReadAt = $participant->last_read_at;

    // 1) Update my last_read_at (drives the unread dot)
    DB::table('conversation_participants')
        ->where('conversation_id', $conversation)
        ->where('user_id', $me)
        ->update(['last_read_at' => $now, 'updated_at' => $now]);

    // 2) Upsert receipts for all messages I’m “catching up” on (not mine)
    //    Mark as READ so the sender can show ✓✓ in DMs (and compact ✓✓ in groups).
    $toMark = DB::table('messages')
        ->where('conversation_id', $conversation)
        ->where('sender_id', '<>', $me)
        ->when($previousReadAt, fn($q) => $q->where('created_at', '>', $previousReadAt))
        ->where('created_at', '<=', $now)
        ->pluck('id')
        ->all();

    if (!empty($toMark)) {
        $rows = array_map(function ($mid) use ($me, $now) {
            return [
                'message_id' => $mid,
                'user_id'    => $me,
                'status'     => 'read',
                'read_at'    => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $toMark);

        // Unique key is (message_id, user_id); update status/read_at if exists
        DB::table('message_receipts')->upsert(
            $rows,
            ['message_id', 'user_id'],
            ['status', 'read_at', 'updated_at']
        );
    }

    return response()->json([
        'ok'           => true,
        'last_read_at' => $now->toDateTimeString(),
        'updated'      => count($toMark), // number of messages marked read
    ]);
}



    // ---------- Step 6: New Chat (DM find-or-create) ----------
    public function storeDirect(Request $request)
    {
        $me = $request->user()->id;

        $data = $request->validate([
            'user_id' => ['required','integer','exists:users,id','different:me'],
        ], [], ['user_id' => 'recipient']);
        $recipientId = (int) $data['user_id'];

        // Must be allowed to DM anyone (your policy says yes) — also prevent self-DM.
        if ($recipientId === $me) {
            return response()->json(['ok'=>false,'error'=>'You cannot start a chat with yourself.'], 422);
        }

        // Stable dm_key: "min|max"
        $a = min($me, $recipientId);
        $b = max($me, $recipientId);
        $dmKey = "{$a}|{$b}";

        // Find existing DM by dm_key
        $existing = DB::table('conversations')
            ->where('type', 'direct')
            ->where('dm_key', $dmKey)
            ->first();

        if ($existing) {
            return response()->json([
                'ok'   => true,
                'data' => [
                    'id'    => (int) $existing->id,
                    'type'  => 'direct',
                    'title' => null, // UI will display other participant’s employee name
                    'avatar'=> null,
                ],
            ]);
        }

        // Create new DM
        $now = now();
        $cid = DB::table('conversations')->insertGetId([
            'type'            => 'direct',
            'title'           => null,
            'avatar_url'      => null,
            'created_by'      => $me,
            'dm_key'          => $dmKey,
            'last_message_id' => null,
            'last_message_at' => null,
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);

        // Add both participants
        DB::table('conversation_participants')->insert([
            [
                'conversation_id' => $cid,
                'user_id'         => $me,
                'role'            => 'member',
                'last_read_at'    => $now, // so you don’t see unread dot on empty thread
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'conversation_id' => $cid,
                'user_id'         => $recipientId,
                'role'            => 'member',
                'last_read_at'    => null,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
        ]);

        return response()->json([
            'ok'   => true,
            'data' => [
                'id'    => $cid,
                'type'  => 'direct',
                'title' => null,
                'avatar'=> null,
            ],
        ], 201);
    }

    // ---------- Step 7: New Group (name + members, max 10) ----------
    public function storeGroup(Request $request)
    {
        $me = $request->user()->id;

        $data = $request->validate([
            'title'       => ['required','string','max:120'],
            'member_ids'  => ['required','array','min:1','max:10'],
            'member_ids.*'=> ['integer', Rule::exists('users','id')],
        ]);

        // Ensure creator included? Optional. We’ll add creator as owner regardless.
        $memberIds = collect($data['member_ids'])
            ->unique()
            ->reject(fn($id) => (int)$id === (int)$me)   // avoid duplicate of owner
            ->values()
            ->all();

        if (count($memberIds) + 1 > 10) {
            return response()->json(['ok'=>false,'error'=>'Group cannot exceed 10 members (including you).'], 422);
        }

        $now = now();
        $cid = DB::table('conversations')->insertGetId([
            'type'            => 'group',
            'title'           => $data['title'],
            'avatar_url'      => null,     // optional: set later
            'created_by'      => $me,
            'dm_key'          => null,
            'last_message_id' => null,
            'last_message_at' => null,
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);

        // Participants: owner + members
        $rows = [[
            'conversation_id' => $cid,
            'user_id'         => $me,
            'role'            => 'owner',
            'last_read_at'    => $now,
            'created_at'      => $now,
            'updated_at'      => $now,
        ]];

        foreach ($memberIds as $uid) {
            $rows[] = [
                'conversation_id' => $cid,
                'user_id'         => (int)$uid,
                'role'            => 'member',
                'last_read_at'    => null,
                'created_at'      => $now,
                'updated_at'      => $now,
            ];
        }
        DB::table('conversation_participants')->insert($rows);

        // Optional: system message “Group created.”
        $sysId = DB::table('messages')->insertGetId([
            'conversation_id'     => $cid,
            'sender_id'           => $me,
            'type'                => 'system',
            'body'                => 'Group created.',
            'metadata'            => null,
            'reply_to_message_id' => null,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        DB::table('conversations')->where('id',$cid)->update([
            'last_message_id' => $sysId,
            'last_message_at' => $now,
            'updated_at'      => $now,
        ]);

        // No receipts needed for system message, but harmless if you want to add delivered to all others.

        return response()->json([
            'ok'   => true,
            'data' => [
                'id'    => $cid,
                'type'  => 'group',
                'title' => $data['title'],
                'avatar'=> null,
            ],
        ], 201);
    }



    /**
     * Normalize avatar paths coming from the database to full URLs.
     */
    private function formatAvatar(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        $normalized = ltrim($path, '/');

        foreach (['public/', 'storage/'] as $prefix) {
            if (Str::startsWith($normalized, $prefix)) {
                $normalized = substr($normalized, strlen($prefix));
                break;
            }
        }

        if (!Storage::disk('public')->exists($normalized)) {
            return null;
        }

        return Storage::disk('public')->url($normalized);
    }

    /**
     * Provide a default avatar when a user has not uploaded one.
     */
    private function defaultUserAvatar(): string
    {
        return asset('images/default-avatar.png');
    }

    /**
     * Provide a deterministic, carpentry-themed icon for group conversations.
     */
    private function groupAvatar(int $conversationId): string
    {
        $icons = [
            'https://api.iconify.design/mdi/hand-saw.svg?color=%23b45309',
            'https://api.iconify.design/mdi/hammer-wrench.svg?color=%231f2937',
            'https://api.iconify.design/mdi/tape-measure.svg?color=%230f766e',
            'https://api.iconify.design/mdi/screwdriver.svg?color=%234c1d95',
            'https://api.iconify.design/mdi/axe.svg?color=%23b91c1c',
            'https://api.iconify.design/mdi/chisel.svg?color=%231c1917',
        ];

        $index = $conversationId % count($icons);

        return $icons[$index];
    }
}
