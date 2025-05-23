<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Installation;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


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
            'created_at'=> now(), // Assuming you want to set the installation date to now
            'user_id'     => Auth::id(),
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




public function update(Request $request, $id)
{
    $installation = Installation::find($id);

    if (!$installation) {
        return response()->json(['success' => false, 'message' => 'Installation not found'], 404);
    }

    // Validate request data (you can adjust rules as needed)
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'client_id' => 'required|exists:clients,id',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after_or_equal:start_time',
        'notes' => 'nullable|string',




    ]);

    $installation->start_time = $request->input('start_time');
    $installation->end_time = $request->input('end_time');
    $installation->notes = $request->input('notes');
    $installation->project_id = $request->input('project_id');
    $installation->client_id = $request->input('client_id');
    $installation->user_id = Auth::id(); // Assuming you want to set the user ID to the currently authenticated user
    $installation->updated_at = now(); // Update the timestamp
    $installation->save();

    return response()->json(['success' => true, 'message' => 'Installation updated successfully']);
}

public function destroy($id)
{
    $installation = Installation::find($id);

    if (!$installation) {
        return response()->json(['success' => false, 'message' => 'Installation not found'], 404);
    }

    $installation->delete();
    Log::info("Installation deleted: $id");

    return response()->json(['success' => true, 'message' => 'Installation deleted successfully']);
}


}

