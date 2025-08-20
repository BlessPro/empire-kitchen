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


class TechDashboardController extends Controller
{

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
