<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use Illuminate\Http\Request;
use App\Models\Project;

class techScheduleMeasurementController extends Controller
{
    //
        public function index(){
    $projects = Project::paginate(15); // fetch paginated projects

    return view('tech.ScheduleMeasurement', compact('projects'));
}

   public function calendarEvents()
    {
        $Measurements = Measurement::with(['client', 'project'])->get();
        // $Measurements = Measurement::with(['client', 'project'])->where('tech_supervisor_id', Auth::id())->get();
        // $Measurements = Measurement::with(['client', 'project'])->where('tech_supervisor_id', Auth::id())->get();
        $events = $Measurements->map(function ($item) {
            return [
                'title' => $item->client->firstname . ' - ' . $item->project->name,
                'start' => $item->start_time,
                'end'   => $item->end_time,
                'extendedProps' => [
                    'client' => $item->client,
                    'project' => $item->project,
                    'notes' => $item->notes,
                ]
            ];
        });

        return response()->json($events);
    }
}
