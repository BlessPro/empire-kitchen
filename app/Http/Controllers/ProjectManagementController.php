<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectManagementController extends Controller
{
    //
    public function index()
    {
        return view('admin.ProjectManagement');
    }
    public function create()
    {
        return view('admin.ProjectManagement.create');
    }
    public function edit($id)
    {
        return view('admin.ProjectManagement.edit', compact('id'));
    }
    public function show($id)
    {
        return view('admin.ProjectManagement.show', compact('id'));
    }
  
    public function store(Request $request)
    {
        // Logic to store the project
        return redirect()->route('admin.ProjectManagement.index')->with('success', 'Project created successfully.');
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
