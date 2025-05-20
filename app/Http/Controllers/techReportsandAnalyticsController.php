<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;

class techReportsandAnalyticsController extends Controller
{
    //

        public function index(){
    $projects = Project::paginate(15); // fetch paginated projects

    return view('tech/ReportsandAnalytics', compact('projects'));
}

public function showMeasurementProjects()
{
    $projects = Project::where('current_stage', 'measurement')
        ->with(['measurement' => function ($query) {
            $query->latest(); // Load latest measurement
        }])
        ->get();

    return view('tech.ReportsandAnalytics', compact('projects'));
}


public function reportsAndAnalytics()
{
  $projects = Project::with('measurement')
        ->where('current_stage', 'measurement')
        ->get();

    return view('tech.ReportsandAnalytics', compact('projects'));
}


}
