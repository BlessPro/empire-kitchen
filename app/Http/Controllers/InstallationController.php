<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Installation;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;

class InstallationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id'    => 'required|exists:clients,id',
            'project_id'   => 'required|exists:projects,id',
            'start_time'   => 'required|date',
            'end_time'     => 'required|date|after:start_time',
            'notes'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $installation = Installation::create([
            'client_id'   => $request->client_id,
            'project_id'  => $request->project_id,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
            'notes'       => $request->notes,
        ]);

        // Update the project's stage if necessary
        $project = Project::find($request->project_id);
        $project->current_stage = 'installation';
        $project->save();

        return response()->json(['success' => true, 'data' => $installation]);
    }

    public function calendarEvents()
    {
        $installations = Installation::with(['client', 'project'])->get();

        $events = $installations->map(function ($item) {
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

