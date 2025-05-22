<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class techScheduleMeasurementController extends Controller
{
    //
        public function index(){
    $projects = Project::paginate(15); // fetch paginated projects

    return view('tech.ScheduleMeasurement', compact('projects'));
}
}
