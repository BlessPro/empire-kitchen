<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Project;
use App\Models\ProjectCommentView;
use App\Models\Activity;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ProjectCommentController
 *
 * Endpoints (all behind ['web','auth'] and /admin prefix):
 *  GET  /admin/projects/{project}/comments              -> index()
 *  POST /admin/projects/{project}/comments              -> store()
 *  GET  /admin/projects/{project}/comments/unread-count -> unreadCount()
 *  POST /admin/projects/{project}/comments/mark-seen    -> markSeen()
 */
class ProjectCommentController extends Controller
{
    /**
     * List comments for a project.
     * Supports optional cursors: ?after=ISO8601 and/or ?before=ISO8601 and ?limit=50
     * Returns oldest -> newest order for chat rendering.
     */
    public function index(Project $project, Request $request): JsonResponse
    {
        $limit = (int) $request->integer('limit', 50);
        $limit = $limit > 100 ? 100 : max(1, $limit);

        $query = Comment::query()
            ->where('project_id', $project->id)
            ->with(['user.employee'])
            ->orderBy('created_at', 'asc');

        if ($after = $request->query('after')) {
            try { $afterTs = CarbonImmutable::parse($after); } catch (\Throwable $e) { $afterTs = null; }
            if ($afterTs) { $query->where('created_at', '>', $afterTs); }
        }
        if ($before = $request->query('before')) {
            try { $beforeTs = CarbonImmutable::parse($before); } catch (\Throwable $e) { $beforeTs = null; }
            if ($beforeTs) { $query->where('created_at', '<', $beforeTs); }
        }

        $comments = $query->limit($limit)->get();

        $meta = [
            'has_more'      => false,
            'next_cursor'   => optional($comments->first())->created_at?->toIso8601String(),
            'latest_cursor' => optional($comments->last())->created_at?->toIso8601String(),
        ];

        return response()->json([
            'data' => CommentResource::collection($comments),
            'meta' => $meta,
        ]);
    }

    /**
     * Create a new comment for the project.
     */
    public function store(Project $project, StoreProjectCommentRequest $request): JsonResponse
    {
        $user = Auth::user();

        $comment = new Comment();
        $comment->project_id = $project->id;
        $comment->user_id = $user->id;
        $comment->comment = $request->validated('body');
        $comment->save();

        Activity::log([
            'project_id' => $project->id,
            'type'       => 'comment.created',
            'message'    => (optional(auth()->user()->employee)->name ?? auth()->user()->name ?? 'Someone') . " commented on '{$project->name}'",
            'meta'       => ['comment_id' => $comment->id],
        ]);

        $comment->load(['user.employee']);

        return response()->json([
            'data' => new CommentResource($comment),
        ]);
    }

    /**
     * Return unread count for the current user on this project.
     */
    public function unreadCount(Project $project): JsonResponse
    {
        $user = Auth::user();

        $clock = ProjectCommentView::query()
            ->where('project_id', $project->id)
            ->where('user_id', $user->id)
            ->first();

        $lastSeenAt = optional($clock)->last_seen_at;

        $query = Comment::query()
            ->where('project_id', $project->id)
            ->where('user_id', '!=', $user->id);

        if ($lastSeenAt) {
            $query->where('created_at', '>', $lastSeenAt);
        }

        $unread = (int) $query->count();

        return response()->json(['unread' => $unread]);
    }

    /**
     * Mark comments as seen for the current user.
     */
    public function markSeen(Project $project): JsonResponse
    {
        $user = Auth::user();

        ProjectCommentView::query()->updateOrCreate(
            [
                'project_id' => $project->id,
                'user_id'    => $user->id,
            ],
            [
                'last_seen_at' => now(),
            ]
        );

        return response()->json(['ok' => true]);
    }
}



