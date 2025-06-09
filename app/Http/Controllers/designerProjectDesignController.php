<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
    use App\Models\Project;
use App\Models\Design;
use Illuminate\Support\Facades\Auth;

class designerProjectDesignController extends Controller
{
    //



public function showUploadForm()
{
    $designerId = Auth::id();
    $projects = Project::where('designer_id', $designerId)->get();

    return view('designer.ProjectDesign', compact('projects'));
}

// public function store(Request $request)
// {
//     $request->validate([
//         'project_id' => 'required|exists:projects,id',
//         'images.*' => 'required|image|mimes:jpg,jpeg,png|max:10240',
//         'notes' => 'nullable|string',
//     ]);

//     $imagePaths = [];

//     if ($request->hasFile('images')) {
//         foreach ($request->file('images') as $image) {
//             $imagePaths[] = $image->store('designs', 'public');
//         }
//     }

//     Design::create([
//         'project_id' => $request->project_id,
//         'images' => json_encode($imagePaths),
//         'notes' => $request->notes,
//     ]);

//     return back()->with('success', 'Design uploaded successfully!');
// }


public function store(Request $request)
{

    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'images.*' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        'notes' => 'nullable|string',
    ]);

    $imagePaths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePaths[] = $image->store('designs', 'public');
        }
    }

    Design::create([
        'project_id' => $request->project_id,
        'images' =>$imagePaths, // ✅ DO NOT use json_encode here
        'notes' => $request->notes,
    ]);

    return back()->with('success', 'Design uploaded successfully!');
}


}
