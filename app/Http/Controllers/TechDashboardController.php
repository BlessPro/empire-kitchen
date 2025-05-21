<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class TechDashboardController extends Controller
{
    //



    // app/Http/Controllers/TechDashboardController.php



public function index()
{
    $techId = Auth::id(); // Logged-in Tech Supervisor ID

    // $stages = ['measurement', 'design', 'production', 'installation'];

    // $projectCounts = Project::where('tech_supervisor_id', $techId)
    //     ->whereIn('current_stage', 'measurement');
        // ->selectRaw('current_stage, COUNT(*) as count')
        // ->groupBy('current_stage')
        // ->pluck('count', 'current_stage');

    // Fill in missing stages with 0
    // $chartData = [];
    // foreach ($stages as $stage) {
    //     $chartData[] = $projectCounts[$stage] ?? 0;
    // }

    // return view('tech.dashboard', [
    //     'chartData' => $chartData,
    //     'chartLabels' => $stages,
    // ]);

 $statusCounts = [
        'measurement' => Project::where('current_stage', 'measurement')->count(),
        'design' => Project::where('current_stage', 'design')->count(),
        'production' => Project::where('current_stage', 'production')->count(),
        'installation' => Project::where('current_stage', 'installation')->count(),

    ];

    return view('tech.dashboard', compact('statusCounts' ));
}

}
