<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

// class TechDashboardController extends Controller
// {
//     public function index()
//     {
//         $techId = Auth::id();

//         // Chart data logic
//         $stages = ['measurement', 'design', 'production', 'installation'];

//         $projectCounts = Project::where('tech_supervisor_id', $techId)
//             ->whereIn('current_stage', $stages)
//             ->selectRaw('current_stage, COUNT(*) as count')
//             ->groupBy('current_stage')
//             ->pluck('count', 'current_stage');

//         $chartData = [];
//         foreach ($stages as $stage) {
//             $chartData[] = $projectCounts[$stage] ?? 0;
//         }

//         // Project cards logic
//         $projects = Project::where('tech_supervisor_id', $techId)
//             ->select('name', 'start_time', 'end_time', 'location')
//             ->get();

//         return view('tech.dashboard', [
//             'chartData' => $chartData,
//             'chartLabels' => $stages,
//             'projects' => $projects,
//         ]);
//     }
// }


use App\Http\Controllers\Controller;
use App\Models\Measurement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


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

    // Measurement Projects Info
    // $projects = Project::where('tech_supervisor_id', $techId)
    //     ->where('current_stage', 'measurement')
    //     ->with(['measurement' => function ($query) {
    //         $query->select('project_id', 'start_time', 'end_time');
    //     }])
    //     ->get()
    //     ->map(function ($project) {
    //         $start = $project->measurement->start_time ?? null;
    //         $end = $project->measurement->end_time ?? null;

    //         $duration = $start && $end ? $start->diffInHours($end) . ' hours' : 'N/A';
// $projects = Project::where('tech_supervisor_id', $techId)
//     ->where('current_stage', 'measurement')
//     ->with(['measurement' => function ($query) {
//         $query->select('project_id', 'start_time', 'end_time');
//     }])
//     ->get()
//     ->map(function ($project) {
//         $firstMeasurement = $project->measurement->first(); // safely get first

//         $start = $firstMeasurement?->start_time ?? null;
//         $end = $firstMeasurement?->end_time ?? null;

//         $duration = $start && $end ? $start->diffInHours($end) . ' hours' : 'N/A';

        // return [
        //     'project' => $project->name,
        //     'start_time' => $start,
        //     'end_time' => $end,
        //     'duration' => $duration,
        // ];
    // });

// $projects = Project::where('tech_supervisor_id', $techId)
//     ->where('current_stage', 'measurement')
//     ->with(['measurement' => function ($query) {
//         $query->select('id', 'project_id', 'start_time', 'end_time');
//     }])
//     ->get()
//     ->map(function ($project) {
//         $measurements = $project->measurement->map(function ($m) {
//             $start = $m->start_time ? Carbon::parse($m->start_time) : null;
//             $end = $m->end_time ? Carbon::parse($m->end_time) : null;

//             return [
//                 'start_time' => $start,
//                 'end_time' => $end,
//                 'duration' => $start && $end ? $start->diffInHours($end) . ' hours' : 'N/A',
//             ];
//         });

        // return [
        //     'project_name' => $project->name,
        //     'measurements' => $measurements,
        // ];
    //});


        //     return [
        //         // 'project_name' => $project->project_name,
        //         'location' => $project->location,
        //         // 'start_time' => $start,
        //         // 'end_time' => $end,
        //         // 'duration' => $duration,
        //           'project_name' => $project->name,
        //     'measurement' => $measurements,
        //     ];
        // });
// $projects = Project::with('measurement')->get()->map(function ($project) {
//     return [
//         'project_name' => $project->name,
//         'measurements' => $project->measurement->map(function ($m) {
//             $start = $m->start_time;
//             $end = $m->end_time;
//             return [
//                 'start_time' => $start,
//                 'end_time' => $end,
//                 'duration' => ($start && $end) ? $start->diffInHours($end) . ' hours' : 'N/A',
//             ];
//         }),
//     ];
// });

//     return view('tech.dashboard', [
//         'chartData' => $chartData,
//         'chartLabels' => $stages,
//         'projects' => $projects,
//     ]);
// }




// use Carbon\Carbon;

public function index()
{
    $techId = Auth::id();

    // Chart Data
    $stages = ['measurement', 'design', 'production', 'installation'];

    $projectCounts = Project::where('tech_supervisor_id', $techId)
        ->whereIn('current_stage', $stages)
        ->selectRaw('current_stage, COUNT(*) as count')
        ->groupBy('current_stage')
        ->pluck('count', 'current_stage');

    $chartData = [];
    foreach ($stages as $stage) {
        $chartData[] = $projectCounts[$stage] ?? 0;
    }

    // Get projects with related measurements (hasMany)
    $projects = Project::where('tech_supervisor_id', $techId)
        ->where('current_stage', 'measurement')
        ->with('measurements') // not 'measurement'
        ->get()
        ->map(function ($project) {
            $firstMeasurement = $project->measurements->first(); // You can also use last() or loop over all

            $start = $firstMeasurement?->start_time ? Carbon::parse($firstMeasurement->start_time) : null;
            $end = $firstMeasurement?->end_time ? Carbon::parse($firstMeasurement->end_time) : null;

            $duration = ($start && $end) ? $start->diffInHours($end) . ' hours' : "";

            return [
                'project_name' => $project->name,
                'location' => $project->location,
                'start_time' => $start?->toDateTimeString() ?? "",
                'end_time' => $end?->toDateTimeString() ?? "",
                'duration' => $duration,
            ];
        });

    return view('tech.dashboard', [
        'chartData' => $chartData,
        'chartLabels' => $stages,
        'projects' => $projects,
    ]);
}

}
