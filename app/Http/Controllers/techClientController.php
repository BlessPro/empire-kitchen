<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use app\Models\Measurement;
use App\Models\Installation;
use App\Models\Design;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class techClientController extends Controller
{
public function updateStatus(Request $request, Project $project)
{
    $request->validate([
        'status' => 'required|in:completed,pending,in progress,cancelled',
    ]);

    $project->status = $request->status;
    $project->save();

    return response()->json(['success' => true, 'message' => 'Status updated']);
}


public function clientProjects()
{
    $techSupervisorId = Auth::id(); // Get logged-in user's ID

    $clients = Client::whereHas('projects', function ($query) use ($techSupervisorId) {
        $query->where('tech_supervisor_id', $techSupervisorId); // only filter by supervisor
    })
    ->with(['projects' => function ($query) use ($techSupervisorId) {
        $query->where('tech_supervisor_id', $techSupervisorId)
              ->with('measurement'); // include measurement relationship
    }])
    ->orderBy('created_at', 'desc')
    ->paginate(5); // Paginate the results

    return view('tech.ClientManagement', compact('clients'));
}


public function showProjectInfo(Project $project)
{
    $project->load(['client', 'measurement', 'installation', 'design','comments.user']);

    return view('tech.ClientManagement.projectInfo', compact('project'));
}

public function showProjectname(Project $project)
{
    $project->load(['client', 'measurement', 'installation', 'design','comments.user']);

    return view('tech.ClientManagement.projectInfo', compact('project'));
}

public function updateDueDate(Request $request, Project $project)
{
    $request->validate([
        'due_date' => 'required|date',
    ]);

    $project->due_date = $request->due_date;
    $project->save();

    return response()->json(['success' => true]);
}


}
