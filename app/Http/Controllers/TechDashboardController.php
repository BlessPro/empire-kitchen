<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;



use App\Http\Controllers\Controller;
use App\Models\Measurement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity; // your activity log model (use Spatie's Activity model)


class TechDashboardController extends Controller
{

// public function index()
// {
//     $techId = Auth::id();

//     // Chart Data
//     $stages = ['measurement', 'design', 'production', 'installation'];

//     $projectCounts = Project::where('tech_supervisor_id', $techId)
//         ->whereIn('current_stage', $stages)
//         ->selectRaw('current_stage, COUNT(*) as count')
//         ->groupBy('current_stage')
//         ->pluck('count', 'current_stage');

//     $chartData = [];
//     foreach ($stages as $stage) {
//         $chartData[] = $projectCounts[$stage] ?? 0;
//     }

//     // Get projects with related measurements (hasMany)
//     $projects = Project::where('tech_supervisor_id', $techId)
//         ->where('current_stage', 'measurement')
//         ->with('measurements') // not 'measurement'
//         ->get()
//         ->map(function ($project) {
//             $firstMeasurement = $project->measurements->first(); // You can also use last() or loop over all

//             $start = $firstMeasurement?->start_time ? Carbon::parse($firstMeasurement->start_time) : null;
//             $end = $firstMeasurement?->end_time ? Carbon::parse($firstMeasurement->end_time) : null;

//             $duration = ($start && $end) ? $start->diffInHours($end) . ' hours' : "";

//             return [
//                 'project_name' => $project->name,
//                 'location' => $project->location,
//                 'start_time' => $start?->toDateTimeString() ?? "",
//                 'end_time' => $end?->toDateTimeString() ?? "",
//                 'duration' => $duration,
//             ];
//         });

//     return view('tech.dashboard', [
//         'chartData' => $chartData,
//         'chartLabels' => $stages,
//         'projects' => $projects,
//     ]);
// }
// app/Http/Controllers/TechDashboardController.php
// namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Schema;
// use App\Models\Project;

// class TechDashboardController extends Controller
// {
    public function index()
    {
        $techId = Auth::id();
        $assigned = Project::where('tech_supervisor_id', $techId);

        // Safely count distinct projects per stage (skips stages if table missing)
        $measurementCount  = Schema::hasTable('measurements')
            ? (clone $assigned)->whereHas('measurements')->distinct('projects.id')->count('projects.id') : 0;

        $designCount       = Schema::hasTable('designs')
            ? (clone $assigned)->whereHas('designs')->distinct('projects.id')->count('projects.id') : 0;

        // $productionCount   = Schema::hasTable('productions') // use your real table name
        //     ? (clone $assigned)->whereHas('productions')->distinct('projects.id')->count('projects.id') : 0;

        $installationCount = Schema::hasTable('installations')
            ? (clone $assigned)->whereHas('installations')->distinct('projects.id')->count('projects.id') : 0;

        // Total projects assigned to this tech (shown as "45 projects" in the UI)
        $totalAssigned = (clone $assigned)->count();

        // Data we’ll inject into the FE component
        $overviewData = [
            ['key' => 'measurement',  'label' => 'Measurement',  'count' => $measurementCount,  'color' => 'bg-orange-500'],
            ['key' => 'design',       'label' => 'Design',       'count' => $designCount,       'color' => 'bg-blue-500'],
            // ['key' => 'production',   'label' => 'Production',   'count' => $productionCount,   'color' => 'bg-green-500'],
            ['key' => 'installation', 'label' => 'Installation', 'count' => $installationCount, 'color' => 'bg-purple-500'],
        ];


//for upcoming measurements

$upcoming = Measurement::with([
            'project:id,name,client_id,tech_supervisor_id',
            'project.client:id,name',
        ])
        ->whereHas('project', fn($q) => $q->where('tech_supervisor_id', $techId))
        ->whereNotNull('scheduled_date')
        ->where('scheduled_date', '>=', now())
        ->orderBy('scheduled_date')
        ->limit(6)
        ->get()
        ->map(function ($m) {
            $dt = $m->scheduled_date ? Carbon::parse($m->scheduled_date) : null;

            // If it's date-only (00:00:00), show just the date; else date + time
            $when = $dt
                ? ($dt->format('H:i:s') === '00:00:00'
                    ? $dt->format('M j, Y')
                    : $dt->format('M j, Y · g:i A'))
                : '—';

            $projectName = $m->project_name ?? $m->project?->name ?? 'Untitled Project';
            $clientName  = $m->client_name  ?? $m->project?->client?->name ?? 'Unknown Client';

            // Deterministic color per project
            $palette = ['bg-orange-500','bg-green-500','bg-blue-500','bg-purple-500'];
            $stripe  = $palette[crc32((string)($m->project_id ?? $projectName)) % count($palette)];

            return (object)[
                'project_name' => $projectName,
                'client_name'  => $clientName,
                'when'         => $when,
                'stripe'       => $stripe,
            ];
        });
        // dd($upcoming->toArray());
        return view('tech.dashboard', compact('overviewData', 'totalAssigned','upcoming'));
    }


// public function index()
//     {
//         $techId = Auth::id();

//         // --- Chart: counts by stage ---
//         $stages = ['measurement', 'design', 'production', 'installation'];
//         $projectCounts = Project::where('tech_supervisor_id', $techId)
//             ->whereIn('current_stage', $stages)
//             ->selectRaw('current_stage, COUNT(*) as count')
//             ->groupBy('current_stage')
//             ->pluck('count', 'current_stage');

//         $chartLabels = ['Measurement', 'Design', 'Production', 'Installation'];
//         $chartData = array_map(fn($s) => $projectCounts[$s] ?? 0, $stages);

//         // --- Upcoming Measurements list (first measurement per project) ---
//         $projectsRaw = Project::where('tech_supervisor_id', $techId)
//             ->where('current_stage', 'measurement')
//             ->with(['measurements' => function ($q) {
//                 $q->orderBy('start_time'); // soonest first
//             }])
//             ->get();

//         // Map to the plain array structure the Blade expects
//         $projects = $projectsRaw->map(function ($p) {
//             $m = $p->measurements->first(); // or ->last() if you prefer
//             if (!$m) {
//                 return null;
//             }
//             return [
//                 'project_name' => $p->name,               // Blade uses project_name
//                 'start_time'   => optional($m->start_time)->format('g:i A') ?? '',
//                 'end_time'     => optional($m->end_time)->format('g:i A') ?? '',
//                 'location'     => $m->location ?: $p->location ?: '',
//             ];
//         })->filter()->values();

//         return view('tech.dashboard', compact('chartLabels', 'chartData', 'projects'));
//     }

    // App/Http/Controllers/TechDashboardController.php

    // public function index()
    // {
    //     $techId = Auth::id();

    //     // Filter only projects assigned to the logged-in tech supervisor
    //     $myProjects = Project::where('tech_supervisor_id', $techId);

    //     // ---- Overview counts (distinct projects that have rows in each stage table)
    //     $measurementCount = (clone $myProjects)->whereHas('measurements')->distinct('projects.id')->count('projects.id');
    //     $designCount      = (clone $myProjects)->whereHas('designs')->distinct('projects.id')->count('projects.id');
    //     $productionCount  = (clone $myProjects)->whereHas('productions')->distinct('projects.id')->count('projects.id');
    //     $installationCount= (clone $myProjects)->whereHas('installations')->distinct('projects.id')->count('projects.id');

    //     $overview = [
    //         ['label' => 'Measurement',  'count' => $measurementCount,  'color' => 'bg-orange-500'],
    //         ['label' => 'Design',       'count' => $designCount,       'color' => 'bg-blue-500'],
    //         ['label' => 'Production',   'count' => $productionCount,   'color' => 'bg-green-500'],
    //         ['label' => 'Installation', 'count' => $installationCount, 'color' => 'bg-purple-500'],
    //     ];
    //     $totalProjects = array_sum(array_column($overview, 'count'));

    //     // ---- Upcoming Measurements (from measurements table)
    //     // schedule_date in the future, belonging to the tech supervisor's projects
    //     $upcoming = Measurement::with(['project.client'])
    //         ->whereHas('project', fn($q) => $q->where('tech_supervisor_id', $techId))
    //         ->where('schedule_date', '>=', Carbon::now())
    //         ->orderBy('schedule_date')
    //         ->limit(6)
    //         ->get()
    //         ->map(function ($m) {
    //             // Prefer explicit columns if they exist on measurement, else fallback to relations
    //             return [
    //                 'project_name' => $m->project_name ?? $m->project?->name ?? 'Untitled Project',
    //                 'client_name'  => $m->client_name  ?? $m->project?->client?->name ?? 'Unknown Client',
    //                 'date'         => optional($m->schedule_date)->format('M j, g:i A'),
    //                 // For the left color stripe (random-ish but stable per project):
    //                 'stripe'       => collect(['bg-orange-500','bg-blue-500','bg-green-500','bg-purple-500'])
    //                                     ->get(crc32((string)($m->project_id ?? 0)) % 4),
    //             ];
    //         });

    //     // ---- Recent Activities (designer uploads etc.) for my projects
    //     // If you have a specific 'type' like 'design_upload', filter by it.
    //     $activities = Activity::with(['actor','project'])
    //         ->whereHas('project', fn($q) => $q->where('tech_supervisor_id', $techId))
    //         ->latest()
    //         ->limit(6)
    //         ->get()
    //         ->map(function ($a) {
    //             return [
    //                 'actor_name'   => $a->actor?->name ?? 'User',
    //                 'actor_avatar' => $a->actor?->avatar_url ?? null,
    //                 'project_id'   => $a->project?->id,
    //                 'project_name' => $a->project?->name ?? 'Project',
    //                 'message'      => $a->message ?? 'updated the project',
    //                 'created_at'   => $a->created_at,
    //             ];
    //         });

    //     return view('tech.dashboard', compact('overview','totalProjects','upcoming','activities'));
    // }



}
