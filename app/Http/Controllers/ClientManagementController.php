<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client; // Import the Client model
use App\Models\Project; // Import the Project model
use Illuminate\Support\Facades\Validator; // Import the Validator facade
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class ClientManagementController extends Controller
{

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

// GET /clients/{client}
    public function show(Client $client)
    {
        // eager-load a small projects summary if helpful
        $client->load(['projects' => function ($q) {
            $q->select('id','project_id','name','status'); // adjust if your columns differ
        }]);

        return view('clients.show', compact('client'));
    }

    // DELETE /clients/{client}
    public function destroy(Request $request, Client $client)
    {
        // Optional: guard with policies/permissions
        // $this->authorize('delete', $client);

        DB::transaction(function () use ($client) {
            // If you use soft deletes, this will soft-delete.
            // If not, this will hard-delete and cascade if FKs are set to cascade.
            $client->delete();
        });

        return redirect()
            ->back()
            ->with('success', 'Client deleted successfully.');
    }


public function showProjectname(Project $project)
{
    $project->load(['client', 'measurement', 'installation', 'design','comments.user']);

    return view('admin.ClientManagement.projectinfo', compact('project'));
}


    /**
     * GET /admin/clients/{client}/projects
     * Shows all projects for a client, grouped by current_stage
     */
    public function projects(int $client): View
    {
        // Fetch the client (minimal fields; adjust columns if needed)
        $clientModel = Client::query()->findOrFail($client);

        // Fetch all projects for this client; eager load client for card display
        $all = Project::query()
            ->where('client_id', $clientModel->id)
            ->with(['client'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Buckets by current_stage (standardized identifiers)
        $measurements  = $all->where('current_stage', 'MEASUREMENT')->values();
        $designs       = $all->where('current_stage', 'DESIGN')->values();
        $productions   = $all->where('current_stage', 'PRODUCTION')->values();
        $installations = $all->where('current_stage', 'INSTALLATION')->values();

        // Render the view you specified
        return view('Admin.ClientManagement.client-projects', [
            'client'        => $clientModel,
            'measurements'  => $measurements,
            'designs'       => $designs,
            'productions'   => $productions,
            'installations' => $installations,
        ]);
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
