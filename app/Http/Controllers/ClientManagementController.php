<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client; // Import the Client model
use App\Models\Project; // Import the Project model
use Barryvdh\DomPDF\Facade\Pdf; // Import the Pdf facade
use App\Exports\ProjectsExport; // Ensure this import exists after creating the export class
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator; // Import the Validator facade
use Illuminate\Support\Facades\Auth; // Import the Auth facade


class ClientManagementController extends Controller
{
//     public function index()
// {
//     $clients = Client::withCount('projects')
//                      ->orderBy('created_at', 'desc') // Order by newest
//                      ->paginate(10);

//     return view('admin.ClientManagement', compact('clients'));
// }


public function index(Request $request)
{
    $query = Client::withCount('projects');

    // Apply search filter if text is provided
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('firstname', 'like', "%{$search}%")
              ->orWhere('lastname', 'like', "%{$search}%")
              ->orWhere('phone_number', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Apply location filter if location is selected
    if ($request->has('location') && !empty($request->location)) {
        $query->where('location', $request->location);
    }

    // Get paginated results
    $clients = $query->orderBy('created_at', 'desc')->paginate(10);

    // Also fetch all distinct locations for the dropdown
    $locations = Client::select('location')->distinct()->pluck('location');

    return view('admin.ClientManagement', compact('clients', 'locations'));
}



public function showProjectname(Project $project)
{
    $project->load(['client', 'measurement', 'installation', 'design','comments.user']);

    return view('admin.ClientManagement.projectinfo', compact('project'));
}



public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        // 'title'          => 'required|string|max:10',
        'firstname'      => 'required|string|max:50',
        'lastname'       => 'required|string|max:50',
        // 'othernames'     => 'nullable|string|max:100',
        'phone_number'   => 'required|numeric|digits_between:10,15',
        'other_phone'    => 'nullable|numeric|digits_between:10,15',
        'contact_person' => 'nullable|string|max:100',
        'contact_phone'  => 'nullable|numeric|digits_between:10,15',
        'location'       => 'required|string|max:100',
       'email' => 'nullable|email|max:255',

    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $client = Client::create($request->only([
        // 'title',
        'firstname',
        'lastname',
        // 'othernames',
        'phone_number',
        'other_phone',
        'contact_person',
        'contact_phone',
        'location',
        'email',
    ]));

    return response()->json(['message' => 'Client successfully created']);
}



public function showClientProjects(Client $client)
{
        $adminId = Auth::id();

    // Closure to count unread comments for each project
    $withUnreadComments = function ($query) use ($adminId) {
        $query->withCount([
            'views as unread_by_admin' => function ($subQuery) use ($adminId) {
                $subQuery->where('user_id', $adminId);
            }
        ]);
    };

    // Eager load comments and unread counts
    $projects = $client->projects()
        ->with(['comments' => $withUnreadComments])
        ->get();

    // Group by status
    $pending = $projects->where('status', 'pending');
    $ongoing = $projects->where('status', 'in progress');
    $completed = $projects->where('status', 'completed');

    return view('admin.ClientManagement.client-projects', compact(
        'client',
        'pending',
        'ongoing',
        'completed'
    ));
}


}
