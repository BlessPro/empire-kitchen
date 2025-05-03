<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client; // Import the Client model
use App\Models\Project; // Import the Project model
use Barryvdh\DomPDF\Facade\Pdf; // Import the Pdf facade
use App\Exports\ProjectsExport; // Ensure this import exists after creating the export class
use Maatwebsite\Excel\Facades\Excel;


class ClientManagementController extends Controller
{
    //
    // public function index()
    // {
    //     return view('admin.ClientManagement');
    // }

    // public function index()
    // {
    //     $Clients = Client::paginate(15); // fetch paginated projects
    //     // dd($projects);

    //     return view('admin/ClientManagement', compact('Clients'));
    // }

    // public function index()
    // {
    //     $clients = Client::withCount('projects')->paginate(10); // Fetch clients with projects count
    //     return view('admin.ClientManagement', compact('clients'));
    // }
    public function index()
{
    $clients = Client::withCount('projects')
                     ->orderBy('created_at', 'desc') // Order by newest
                     ->paginate(10);

    return view('admin.ClientManagement', compact('clients'));
}


    // public function showprojectInfo(Client $client)
    // {
    //     $projects = $client->projects;


    //     return view('admin.ClientManagement.projectInfo', compact('client', 'projects'));

    // }

//     public function showProjectname(Project $project)
// {
//     // Load the client relationship if needed
//     $project->load('client');

//     return view('admin.ClientManagement.projectinfo', compact('project'));
// }

public function showProjectname(Project $project)
{
    $project->load(['client', 'measurement', 'installation', 'design','comments.user']);

    return view('admin.ClientManagement.projectinfo', compact('project'));
}


    // public function showprojectInfo(Client $clientId)
    // {
    //     // Fetch client
    //     $client = Client::findOrFail($clientId);

    //     // Fetch projects **with related measurement, installation, designs**
    //     $projects = Project::with(['measurement', 'installation', 'designs'])
    //                 ->where('client_id', $clientId)
    //                 ->get();

    //     return view('admin.ClientManagement.projectinfo', compact('client', 'projects'));
    // }
//     public function showprojectInfo(Client $client)
// {
//     // $client is already the Client model

//     $projects = Project::with(['measurement', 'installation', 'design'])
//                 ->where('client_id', $client->id)
//                 ->get();

//     return view('admin.ClientManagement.projectinfo', compact('client', 'projects'));
// }

// public function showprojectname(Client $clientId)
// {
//     // Get the first project related to the client
//     $client = Client::with('projects')->findOrFail($clientId);

//     // Make sure there's at least one project linked to the client
//     $project = $client->projects->first(); // This gives the first project for the client

//     return view('admin.ClientManagement.projectinfo', compact('client', 'project'));
// }
// public function showprojectname(Client $client)
// {
//     $projects = $client->projects->name;



//     return view('admin.ClientManagement.client-projects', compact('project',  'pending', 'ongoing', 'completed'));
// }

//fofr storing clients

// public function store(Request $request)
// {
//     $client = Client::create($request->only([


// 'title', 'firstname', 'lastname', 'othernames', 'phone_number', 'location'



//     ]));

//     return response()->json(['message' => 'Client successfully created']);
// }


public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:10',
        'firstname' => 'required|string|max:50',
        'lastname' => 'required|string|max:50',
        'othernames' => 'nullable|string|max:100',
        'phone_number' => 'required|string|max:20',
        'location' => 'required|string|max:100',
    ]);

    $client = Client::create($request->only([
        'title', 'firstname', 'lastname', 'othernames', 'phone_number', 'location'
    ]));

    return response()->json(['message' => 'Client successfully created']);
}


// redirecting to the client projects
// public function showClientProjects(Client $client)
//written on 30.04.2025, 12:54am

public function showClientProjects(Client $client)
{
    $projects = $client->projects;

    $pending = $projects->where('status', 'pending');
    $ongoing = $projects->where('status', 'in progress');
    $completed = $projects->where('status', 'completed');

    return view('admin.ClientManagement.client-projects', compact('client', 'pending', 'ongoing', 'completed'));
}


}
