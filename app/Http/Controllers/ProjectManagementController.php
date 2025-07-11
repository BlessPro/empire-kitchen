<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\Models\Client;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProjectManagementController extends Controller
{
    // Function to house all data that the project page needs
    public function index()
    {
        $adminId = Auth::id();

        // 👇 Reusable closure to count unread comments per project
        $withUnreadComments = function ($query) use ($adminId) {
            $query->withCount([
                'views as unread_by_admin' => function ($subQuery) use ($adminId) {
                    $subQuery->where('user_id', $adminId);
                }
            ]);
        };

        // Showing data based on project stage, including unread comments
        $measurements = Project::with(['measurement', 'comments' => $withUnreadComments])
            ->where('current_stage', 'measurement')
            ->orderBy('created_at', 'desc')
            ->get();

        $designs = Project::with(['design', 'comments' => $withUnreadComments])
            ->where('current_stage', 'design')
            ->orderBy('created_at', 'desc')
            ->get();

        $installations = Project::with(['installation', 'comments' => $withUnreadComments])
            ->where('current_stage', 'installation')
            ->orderBy('created_at', 'desc')
            ->get();

        $productions = Project::with(['production', 'comments' => $withUnreadComments])
            ->where('current_stage', 'production')
            ->orderBy('created_at', 'desc')
            ->get();

        $clients = Client::all();
        $techSupervisors = User::where('role', 'tech_supervisor')->get();

        return view('admin.ProjectManagement', compact(
            'measurements',
            'designs',
            'installations',
            'productions',
            'clients',
            'techSupervisors'
        ));
    }

    public function create()
    {
        return view('admin.ProjectManagement.create');
    }

    public function edit($id)
    {
        return view('admin.ProjectManagement.edit', compact('id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'tech_supervisor_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'cost' => 'required|numeric|min:0',
            'current_stage' => 'measurement',
        ]);

        $project = Project::create($validated);

        return response()->json($project); // Laravel will return it as JSON
    }

    // Looping through table for records to push to the project blade
    public function project_stage()
    {
        $measurements = Project::with('measurement')
            ->where('current_stage', 'measurement')
            ->orderBy('created_at', 'desc')
            ->get();

        $designs = Project::with('design')
            ->where('current_stage', 'design')
            ->get();

        $installations = Project::with('installation')
            ->where('current_stage', 'installation')
            ->get();

        return view('admin.ProjectManagement', compact('measurements', 'designs', 'installations'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update the project
        return redirect()->route('admin.ProjectManagement.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->back()->with('success', 'Project deleted successfully!');
    }
}
