<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Measurement;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Design;
use Carbon\Carbon;
use Illuminate\Support\Str;


class TechDashboardController extends Controller
{

public function index()
{
    $techId = Auth::id();
    $base   = \App\Models\Project::query()
                ->where('tech_supervisor_id', $techId);

    // Total projects for this tech
    $totalAssigned = (clone $base)->count();
    // Group counts by lowercased stage in ONE query
    $byStage = (clone $base)
        ->whereNotNull('current_stage')
        ->selectRaw('LOWER(current_stage) AS stage, COUNT(*) AS c')
        ->groupBy('stage')
        ->pluck('c', 'stage'); // e.g. ['measurement'=>12, 'design'=>8]

    // Normalize to the four buckets you want
    $get = fn($k) => (int) ($byStage[strtolower($k)] ?? 0);

    $overviewData = [
        ['key'=>'measurement',  'label'=>'Measurement',  'count'=>$get('measurement'),  'color'=>'bg-orange-500'],
        ['key'=>'design',       'label'=>'Design',       'count'=>$get('design'),       'color'=>'bg-blue-500'],
        ['key'=>'production',   'label'=>'Production',   'count'=>$get('production'),   'color'=>'bg-green-500'],
        ['key'=>'installation', 'label'=>'Installation', 'count'=>$get('installation'), 'color'=>'bg-purple-500'],
    ];

$projectIds = (clone $base)->pluck('id');

$upcoming = \App\Models\Measurement::with([
        'project:id,name,client_id,tech_supervisor_id',
        'project.client:id,firstname',
    ])
    ->whereHas('project', fn($q) => $q->where('tech_supervisor_id', $techId))
    ->whereNotNull('scheduled_date')
    ->where('scheduled_date', '>=', now())
    ->orderBy('scheduled_date')
    ->limit(6)
    ->get()
    ->map(function ($m) {
        $dt = $m->scheduled_date ? Carbon::parse($m->scheduled_date) : null;
        $when = $dt
            ? ($dt->format('H:i:s') === '00:00:00' ? $dt->format('M j, Y') : $dt->format('M j, Y · g:i A'))
            : '—';

        $projectName = $m->project_name ?? $m->project?->name ?? 'Untitled Project';
        $clientName  = $m->client_name  ?? $m->project?->client?->name ?? 'Unknown Client';

        // Use a palette different from the overview colors
        $palette = ['bg-pink-500','bg-amber-500','bg-teal-500','bg-indigo-500'];
        $stripe  = $palette[crc32((string)($m->project_id ?? $projectName)) % count($palette)];

        return (object)[
            'project_name' => $projectName,
            'client_name'  => $clientName,
            'when'         => $when,
            'stripe'       => $stripe,
        ];
    });

$recentActivities = collect();

if ($projectIds->isNotEmpty()) {
    $commentActivities = Comment::with(['user.employee', 'project:id,name'])
        ->whereIn('project_id', $projectIds)
        ->latest()
        ->limit(20)
        ->get()
        ->map(function (Comment $comment) {
            $user = $comment->user;
            $employee = $user?->employee;

            $name = $employee?->name ?? ($user?->name ?? 'Someone');
            $avatar = $employee?->avatar_url ?? null;

            if (!$avatar && $user && $user->profile_pic) {
                $profilePic = $user->profile_pic;
                if (Str::startsWith($profilePic, ['http://', 'https://'])) {
                    $avatar = $profilePic;
                } else {
                    $relativePath = ltrim($profilePic, '/');
                    $avatar = Str::startsWith($relativePath, 'storage/')
                        ? asset($relativePath)
                        : asset('storage/' . $relativePath);
                }
            }

            $initials = collect(explode(' ', $name))
                ->filter()
                ->map(fn($part) => Str::upper(Str::substr($part, 0, 1)))
                ->take(2)
                ->implode('');

            if ($initials === '') {
                $initials = Str::upper(Str::substr($name, 0, 2) ?: 'U');
            }

            $projectName = $comment->project?->name ?? 'Project';
            $occurredAt = $comment->created_at;

            return [
                'id' => 'comment-' . $comment->id,
                'type' => 'comment',
                'user_name' => $name,
                'user_avatar' => $avatar,
                'initials' => $initials,
                'project_name' => $projectName,
                'project_id' => $comment->project_id,
                'description' => 'commented on',
                'time' => $occurredAt ? $occurredAt->diffForHumans() : null,
                'sort_key' => $occurredAt ? $occurredAt->timestamp : 0,
            ];
        });

    $designActivities = Design::with(['designer.employee', 'project:id,name'])
        ->whereIn('project_id', $projectIds)
        ->latest()
        ->limit(20)
        ->get()
        ->map(function (Design $design) {
            $user = $design->designer;
            $employee = $user?->employee;

            $name = $employee?->name ?? ($user?->name ?? 'Someone');
            $avatar = $employee?->avatar_url ?? null;

            if (!$avatar && $user && $user->profile_pic) {
                $profilePic = $user->profile_pic;
                if (Str::startsWith($profilePic, ['http://', 'https://'])) {
                    $avatar = $profilePic;
                } else {
                    $relativePath = ltrim($profilePic, '/');
                    $avatar = Str::startsWith($relativePath, 'storage/')
                        ? asset($relativePath)
                        : asset('storage/' . $relativePath);
                }
            }

            $initials = collect(explode(' ', $name))
                ->filter()
                ->map(fn($part) => Str::upper(Str::substr($part, 0, 1)))
                ->take(2)
                ->implode('');

            if ($initials === '') {
                $initials = Str::upper(Str::substr($name, 0, 2) ?: 'U');
            }

            $projectName = $design->project?->name ?? 'Project';
            $occurredAt = $design->created_at;
            $images = $design->images;
            $imageCount = is_array($images) ? count($images) : 0;

            if ($imageCount > 1) {
                $description = "uploaded {$imageCount} images to";
            } elseif ($imageCount === 1) {
                $description = 'uploaded an image to';
            } else {
                $description = 'updated designs for';
            }

            return [
                'id' => 'design-' . $design->id,
                'type' => 'design_upload',
                'user_name' => $name,
                'user_avatar' => $avatar,
                'initials' => $initials,
                'project_name' => $projectName,
                'project_id' => $design->project_id,
                'description' => $description,
                'time' => $occurredAt ? $occurredAt->diffForHumans() : null,
                'sort_key' => $occurredAt ? $occurredAt->timestamp : 0,
            ];
        });

    $recentActivities = $commentActivities
        ->merge($designActivities)
        ->sortByDesc('sort_key')
        ->values()
        ->take(10)
        ->map(function (array $activity) {
            unset($activity['sort_key']);
            return $activity;
        });
}

return view('tech.dashboard', compact('overviewData', 'totalAssigned', 'upcoming', 'recentActivities'));
}




}
