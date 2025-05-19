<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectManagementController extends Controller
{
    //
    public function index()
    {
        $measurements = Project::with('measurement')->where('current_stage', 'measurement')->get();
        $designs = Project::with('design')->where('current_stage', 'design')->get();
        $installations = Project::with('installation')->where('current_stage', 'installation')->get();



    $clients = Client::all();
    $techSupervisors = User::where('role', 'tech_supervisor')->get();


    return view('admin.ProjectManagement', compact('measurements', 'designs', 'installations','clients', 'techSupervisors'));

    // return view('admin.ProjectManagement', compact('clients', 'techSupervisors'));
    }


    // public function getFormData()
    // {
    //     $clients = Client::select('id', 'firstname', 'lastname')->get();
    //     $techSupervisors = User::where('role', 'tech_supervisor')->select('id', 'name')->get();

    //     return response()->json([
    //         'clients' => $clients,
    //         'techSupervisors' => $techSupervisors
    //     ]);
    // }



    public function create()
    {
        return view('admin.ProjectManagement.create');
    }
    public function edit($id)
    {
        return view('admin.ProjectManagement.edit', compact('id'));
    }

//storing the project
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'client_id' => 'required|exists:clients,id',
    //         'tech_supervisor_id' => 'required|exists:users,id',
    //     ]);

    //     Project::create([
    //         'client_id' => $request->client_id,
    //         'tech_supervisor_id' => $request->tech_supervisor_id,
    //     ]);

    //     return response()->json(['message' => 'Project created']);
    // }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'due_date' => 'required|date',
        'cost' => 'required|numeric',
        'location' => 'required|string|max:255',
        'description' => 'required|string',
        // 'admin_name' => 'required|string|max:255',
        'client_id' => 'required|exists:clients,id',
        'tech_supervisor_id' => 'required|exists:users,id',
    ]);

    Project::create([
        'name' => $request->name,
        'due_date' => $request->due_date,
        'cost' => $request->cost,
        'location' => $request->location,
        'description' => $request->description,
        'start_date' => now(), // or any other default value
        // 'admin_name' => $request->admin_id,
        'client_id' => $request->client_id,
        'tech_supervisor_id' => $request->tech_supervisor,
        'current_stage' => 'measurement', // if default stage is needed
    ]);

    // return response()->json(['message' => 'Project created']);
    return response()->json(['success' => true]);


}


//looping through table  for records to push to the project blade
public function project_stage()
{
    $measurements = Project::with('measurement')->where('current_stage', 'measurement')->get();
    $designs = Project::with('design')->where('current_stage', 'design')->get();
    $installations = Project::with('installation')->where('current_stage', 'installation')->get();

    return view('admin.ProjectManagement', compact('measurements', 'designs', 'installations'));
}




    public function update(Request $request, $id)
    {
        // Logic to update the project
        return redirect()->route('admin.ProjectManagement.index')->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
{
    $project = Project::findOrFail($id);
    $project->delete();

    return redirect()->back()->with('success', 'Project deleted successfully!');
}

}
