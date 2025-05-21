<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Measurement;
use App\Models\Design;
use App\Models\Installation;
use App\Models\Comment;
use App\Models\Client;

class techAssignDesignersController extends Controller
{
    //
          public function index(){
    $projects = Project::paginate(15); // fetch paginated projects

    return view('tech/AssignDesigners', compact('projects'));
}



public function showDesignerAssignment()
{
    $projects = Project::with(['client', 'designer'])
                ->where('current_stage', 'measurement')->orderBy('created_at', 'desc')
                ->get();

    $designers = User::where('role', 'designer')->get(); // adjust this to match your setup

    return view('tech.AssignDesigners', compact('projects', 'designers'));
}

public function assignDesigner(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'designer_id' => 'required|exists:users,id',
    ]);

    $project = Project::find($request->project_id);
    $project->designer_id = $request->designer_id;
    $project->save();

    return redirect()->back()->with('success', 'Designer assigned successfully!');
}

}
