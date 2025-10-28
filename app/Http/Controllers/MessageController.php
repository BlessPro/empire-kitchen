<?php

// 1. CONTROLLER: app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class MessageController extends Controller
{



    public function hide(\Illuminate\Http\Request $request, int $message)
{
    $me = $request->user()->id;

    // Verify the message exists and I’m a participant in its conversation
    $row = DB::table('messages as m')
        ->join('conversation_participants as p', function ($j) use ($me) {
            $j->on('p.conversation_id','=','m.conversation_id')
              ->where('p.user_id','=',$me);
        })
        ->where('m.id', $message)
        ->select('m.id')
        ->first();

    if (!$row) return response()->json(['ok'=>false,'error'=>'Forbidden'], 403);

    DB::table('message_hidden')->updateOrInsert(
        ['message_id'=>$message, 'user_id'=>$me],
        ['updated_at'=>now(), 'created_at'=>now()]
    );

    return response()->json(['ok'=>true]);
}

public function unhide(\Illuminate\Http\Request $request, int $message)
{
    $me = $request->user()->id;

    DB::table('message_hidden')
        ->where('message_id', $message)
        ->where('user_id', $me)
        ->delete();

    return response()->json(['ok'=>true]);
}

    // Fetch messages between auth user and another user
    // public function index(User $user)
    // {
    //     $messages = Message::where(function ($q) use ($user) {
    //         $q->where('sender_id', Auth::id())
    //           ->where('receiver_id', $user->id);
    //     })->orWhere(function ($q) use ($user) {
    //         $q->where('sender_id', $user->id)
    //           ->where('receiver_id', Auth::id());
    //     })->orderBy('created_at')->get();

    //     return view('admin.inbox.', compact('messages', 'user'));
    // }

    // // Send a message
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'receiver_id' => 'required|exists:users,id',
    //         'message' => 'required|string'
    //     ]);

    //     $message = Message::create([
    //         'sender_id' => Auth::id(),
    //         'receiver_id' => $request->receiver_id,
    //         'message' => $request->message
    //     ]);

    //     broadcast(new NewMessageEvent($message))->toOthers();

    //     return response()->json($message);
    // }





    /**
     * GET /conversations/{conversation}/messages?before_id=&after_id=&limit=30
     *
     * - Newest-first page (seek):
     *     * if before_id given -> return messages with id < before_id (older chunk)
     *     * else -> return latest chunk
     * - If after_id given -> return messages with id > after_id (for polling/append)
     * - Always requires the current user to be a participant.
     */
    public function index(Request $request, int $conversation)
    {
        $me    = $request->user()->id;
        $limit = min(max((int) $request->query('limit', 30), 1), 100);
        $beforeId = $request->query('before_id');
        $afterId  = $request->query('after_id');

        // Auth: must be a participant
        $isParticipant = DB::table('conversation_participants')
            ->where('conversation_id', $conversation)
            ->where('user_id', $me)
            ->exists();

        if (!$isParticipant) {
            return response()->json(['ok' => false, 'error' => 'Forbidden'], 403);
        }

        // Base query
        $q = DB::table('messages as m')
            ->where('m.conversation_id', $conversation);

        // Seek windows
        if ($afterId) {
            // Upward (newer than)
            $q->where('m.id', '>', (int) $afterId)
              ->orderBy('m.id', 'asc'); // so UI can append naturally
        } else {
            // Downward (older pages or latest)
            if ($beforeId) {
                $q->where('m.id', '<', (int) $beforeId);
            }
            $q->orderBy('m.id', 'desc'); // newest first for initial load and scroll-up
        }

        $rows = $q->limit($limit)->get();

        // If we fetched ascending for afterId, reverse for consistent newest-first output
        if ($afterId) {
            $rows = $rows->reverse()->values();
        }

        // Build response items
        $items = [];
        foreach ($rows as $r) {
            $file = null;
            if ($r->type === 'file') {
                $meta = json_decode($r->metadata ?? '{}', true);
                $path = Arr::get($meta, 'storage_path');
                /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
                $disk = Storage::disk('public');
                $url  = $path ? $disk->url($path) : null;

                $file = [
                    'name'     => Arr::get($meta, 'filename'),
                    'size'     => Arr::get($meta, 'size'),
                    'mimetype' => Arr::get($meta, 'mimetype'),
                    'url'      => $url,
                ];
            }

            // Ticks (compact): we’ll compute client-side if needed, but send a hint for DMs
            $ticks = '✓'; // default sent; Step 3 will upgrade to ✓✓ using receipts

            $items[] = [
                'id'               => (int) $r->id,
                'is_me'            => (int) $r->sender_id === (int) $me,
                'type'             => $r->type,                  // text | file | system
                'body'             => $r->type === 'text' ? $r->body : null,
                'file'             => $file,                     // null or {name,size,mimetype,url}
                'created_at'       => (string) $r->created_at,
                'created_at_time'  => $r->created_at ? \Illuminate\Support\Carbon::parse($r->created_at)->format('H:i') : null,
                'ticks'            => $ticks,                    // DMs: ✓ or ✓✓ (after Step 3)
                'reply_to_message_id' => $r->reply_to_message_id ? (int) $r->reply_to_message_id : null,
            ];
        }

        // Pagination cursors for your UI (so you know what to request next)
        $next_before_id = null;
        $next_after_id  = null;
        if ($rows->count() > 0) {
            // For further upward polling (new messages)
            $next_after_id = (int) $rows->first()->id;    // largest id in this page (since we output newest-first)

            // For infinite scroll up (older)
            $next_before_id = (int) $rows->last()->id;    // smallest id in this page
        }

        return response()->json([
            'data' => $items,
            'meta' => [
                'limit'          => $limit,
                'next_before_id' => $next_before_id,
                'next_after_id'  => $next_after_id,
            ],
        ]);
    }

    public function store(\Illuminate\Http\Request $request, int $conversation)
{
    $me = $request->user()->id;

    // 1) Verify participant
    $isParticipant = DB::table('conversation_participants')
        ->where('conversation_id', $conversation)
        ->where('user_id', $me)
        ->exists();
    if (!$isParticipant) {
        return response()->json(['ok' => false, 'error' => 'Forbidden'], 403);
    }

    // 2) Branch by type
    $type = $request->input('type');

    if ($type === 'text') {
        $data = $request->validate([
            'type' => ['required', 'in:text'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $now = now();
        $messageId = DB::table('messages')->insertGetId([
            'conversation_id'     => $conversation,
            'sender_id'           => $me,
            'type'                => 'text',
            'body'                => $data['body'],
            'metadata'            => null,
            'reply_to_message_id' => null,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        // cache + receipts
        $this->afterMessageSaved($conversation, $messageId, $now, $me);

        return response()->json([
            'ok'   => true,
            'data' => [
                'id'              => $messageId,
                'is_me'           => true,
                'type'            => 'text',
                'body'            => $data['body'],
                'file'            => null,
                'created_at'      => $now->toDateTimeString(),
                'created_at_time' => $now->format('H:i'),
                'ticks'           => '✓',
            ],
        ], 201);
    }

    if ($type === 'file') {
        // 3) Validate file (1 file only)
        // Allowed: images, pdf, docx; Max 25MB
        $request->validate([
            'type' => ['required', 'in:file'],
            'file' => [
                'required', 'file', 'max:25600', // 25MB
                'mimetypes:image/jpeg,image/png,image/gif,image/webp,image/bmp,image/tiff,image/svg+xml,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
        ]);

        $uploaded = $request->file('file');

        // Safe filename + path (e.g., chat/123/20251021/uniqid_original.ext)
        $originalName = $uploaded->getClientOriginalName();
        $ext          = $uploaded->getClientOriginalExtension();
        $safeBase     = pathinfo($originalName, PATHINFO_FILENAME);
        $safeBase     = preg_replace('/[^A-Za-z0-9_\-]/', '_', $safeBase) ?: 'file';
        $uniq         = uniqid();
        $dateFolder   = now()->format('Ymd');
        $dir          = "chat/{$conversation}/{$dateFolder}";
        $filename     = "{$uniq}_{$safeBase}.{$ext}";

        // 4) Store to public disk
        // Ensure you've run: php artisan storage:link
        $path = $uploaded->storeAs($dir, $filename, 'public');

        $meta = [
            'filename'    => $originalName,
            'mimetype'    => $uploaded->getClientMimeType(),
            'size'        => $uploaded->getSize(),
            'storage_path'=> $path,
            'ext'         => $ext,
        ];

        $now = now();
        $messageId = DB::table('messages')->insertGetId([
            'conversation_id'     => $conversation,
            'sender_id'           => $me,
            'type'                => 'file',
            'body'                => null,
            'metadata'            => json_encode($meta),
            'reply_to_message_id' => null,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        // cache + receipts
        // Build downloadable URL from public disk
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');
        $url = $disk->url($path);
        $this->afterMessageSaved($conversation, $messageId, $now, $me);

        return response()->json([
            'ok'   => true,
            'data' => [
                'id'              => $messageId,
                'is_me'           => true,
                'type'            => 'file',
                'body'            => null,
                'file'            => [
                    'name'     => $originalName,
                    'size'     => $uploaded->getSize(),
                    'mimetype' => $uploaded->getClientMimeType(),
                    'url'      => $url,
                ],
                'created_at'      => $now->toDateTimeString(),
                'created_at_time' => $now->format('H:i'),
                'ticks'           => '✓',
            ],
        ], 201);
    }

    return response()->json(['ok' => false, 'error' => 'Invalid type'], 422);
}

/**
 * Post-save: update conversation cache + create delivered receipts for others.
 */
private function afterMessageSaved(int $conversation, int $messageId, \Illuminate\Support\Carbon $now, int $senderId): void
{
    DB::table('conversations')->where('id', $conversation)->update([
        'last_message_id' => $messageId,
        'last_message_at' => $now,
        'updated_at'      => $now,
    ]);

    $others =DB::table('conversation_participants')
        ->where('conversation_id', $conversation)
        ->where('user_id', '<>', $senderId)
        ->pluck('user_id')
        ->all();

    if (!empty($others)) {
        $rows = array_map(fn($uid) => [
            'message_id' => $messageId,
            'user_id'    => $uid,
            'status'     => 'delivered',
            'read_at'    => null,
            'created_at' => $now,
            'updated_at' => $now,
        ], $others);

        DB::table('message_receipts')->insert($rows);
    }
}


    public function store_old(\Illuminate\Http\Request $request, int $conversation)
{
    $me = $request->user()->id;

    // 1) Verify participant
    $isParticipant = DB::table('conversation_participants')
        ->where('conversation_id', $conversation)
        ->where('user_id', $me)
        ->exists();

    if (!$isParticipant) {
        return response()->json(['ok' => false, 'error' => 'Forbidden'], 403);
    }

    // 2) Validate (TEXT ONLY for this step)
    $data = $request->validate([
        'type' => ['required', 'in:text'],
        'body' => ['required', 'string', 'max:5000'],
    ]);

    $now = now();

    // 3) Create message
    $messageId = DB::table('messages')->insertGetId([
        'conversation_id'    => $conversation,
        'sender_id'          => $me,
        'type'               => 'text',
        'body'               => $data['body'],
        'metadata'           => null,
        'reply_to_message_id'=> null,
        'created_at'         => $now,
        'updated_at'         => $now,
    ]);

    // 4) Update conversation cache (for list sorting/preview)
    DB::table('conversations')
        ->where('id', $conversation)
        ->update([
            'last_message_id' => $messageId,
            'last_message_at' => $now,
            'updated_at'      => $now,
        ]);

    // 5) Create "delivered" receipts for all OTHER participants
    $others = DB::table('conversation_participants')
        ->where('conversation_id', $conversation)
        ->where('user_id', '<>', $me)
        ->pluck('user_id')
        ->all();

    if (!empty($others)) {
        $rows = array_map(fn($uid) => [
            'message_id' => $messageId,
            'user_id'    => $uid,
            'status'     => 'delivered',
            'read_at'    => null,
            'created_at' => $now,
            'updated_at' => $now,
        ], $others);

        DB::table('message_receipts')->insert($rows);
    }

    // 6) Build response bubble (what your UI needs)
    return response()->json([
        'ok'   => true,
        'data' => [
            'id'              => $messageId,
            'is_me'           => true,
            'type'            => 'text',
            'body'            => $data['body'],
            'file'            => null,
            'created_at'      => $now->toDateTimeString(),
            'created_at_time' => $now->format('H:i'),
            'ticks'           => '✓',   // will flip to ✓✓ when recipient calls POST /conversations/{id}/read
        ],
    ], 201);
}


public function hide_old(\Illuminate\Http\Request $request, int $message)
{
    $me = $request->user()->id;

    // Verify the message exists and I’m a participant in its conversation
    $row = DB::table('messages as m')
        ->join('conversation_participants as p', function ($j) use ($me) {
            $j->on('p.conversation_id','=','m.conversation_id')
              ->where('p.user_id','=',$me);
        })
        ->where('m.id', $message)
        ->select('m.id')
        ->first();

    if (!$row) return response()->json(['ok'=>false,'error'=>'Forbidden'], 403);

    DB::table('message_hidden')->updateOrInsert(
        ['message_id'=>$message, 'user_id'=>$me],
        ['updated_at'=>now(), 'created_at'=>now()]
    );

    return response()->json(['ok'=>true]);
}

public function unhide_old(\Illuminate\Http\Request $request, int $message)
{
    $me = $request->user()->id;

    DB::table('message_hidden')
        ->where('message_id', $message)
        ->where('user_id', $me)
        ->delete();

    return response()->json(['ok'=>true]);
}


}
