<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Project;

class designerAssignDesigners extends Controller
{
    // redirect to the designer dashboard
    public function index()
    {
        return view('designer.dashboard');
    }
    // redirect to the assigned projects page
       public function AssignedProjects()
    {
        return view('designer.AssignedProjects');
    }
    // redirect to the Project Design page
    public function ProjectDesign()
    {
        return view('designer.ProjectDesign');
    }
    // redirect to the timeline management page
    public function TimelineManagement()
    {
        return view('designer.TimelineManagement');
    }
    // redirect to the inbox page
    public function inbox()
    {
        return view('designer.inbox');
    }


// public function clientProjects()
// {
//     $designer_id = Auth::id(); // Get logged-in user's ID

//     $clients = Client::whereHas('projects', function ($query) use ($designer_id) {
//         $query->where('current_stage', 'design')
//               ->where('designer_id', $designer_id); // filter by designer
//     })
//     ->with(['projects' => function ($query) use ($designer_id) {
//         $query->where('current_stage', 'design')
//               ->where('designer_id', $designer_id)
//               ->with('design');
//     }])
//     ->orderBy('created_at', 'desc')
//     ->paginate(5); // Paginate the results

//     return view('designer.AssignedProjects', compact('clients'));
// }
public function clientProjects()
{
    $designerId = Auth::id(); // Get logged-in user's ID

    $clients = Client::whereHas('projects', function ($query) use ($designerId) {
        $query->where('current_stage', 'design') // filter by design stage
              ->where('designer_id', $designerId); // filter by supervisor
    })
    ->with(['projects' => function ($query) use ($designerId) {
        $query->where('current_stage', 'design') // filter by design stage
              ->where('designer_id', $designerId)
              ->with('design'); // filter by design stage
    }])
    ->orderBy('created_at', 'desc')
    ->paginate(5); // Paginate the results

    return view('designer.AssignedProjects', compact('clients'));
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
}
