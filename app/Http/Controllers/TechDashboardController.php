<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Measurement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity; // your activity log model (use Spatie's Activity model)


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

        $palette = ['bg-orange-500','bg-green-500','bg-blue-500','bg-purple-500'];
        $stripe  = $palette[crc32((string)($m->project_id ?? $projectName)) % count($palette)];

        return (object)[
            'project_name' => $projectName,
            'client_name'  => $clientName,
            'when'         => $when,
            'stripe'       => $stripe,
        ];
    });

return view('tech.dashboard', compact('overviewData', 'totalAssigned', 'upcoming'));
}




}
