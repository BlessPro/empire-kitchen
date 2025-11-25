<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Design;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class DesignController extends Controller
{
    //

    // DesignController.php

public function store(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'images' => 'required|array',
        'notes' => 'nullable|string',
    ]);
    $request->validate([
        'schedule_date' => 'nullable|date',
        'start_time' => 'nullable|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i|after:start_time',
    ]);

    $design = Design::create([
        'project_id' => $request->project_id,
        'user_id' => Auth::user()->id,
        'images' => json_encode($request->images), // or store and save paths
        'notes' => $request->notes,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'schedule_date' => $request->schedule_date,

    ]);

    // ✅ Update project current_stage
    $project = Project::find($request->project_id);
    $project->update(['current_stage' => 'design']);
    Activity::log([
        'project_id' => $project->id,
        'type'       => 'design.uploaded',
        'message'    => (optional(auth()->user()->employee)->name ?? auth()->user()->name ?? 'Someone') . " uploaded designs for '{$project->name}'",
        'meta'       => ['count' => is_array($request->images ?? null) ? count($request->images) : null],
    ]);

    return redirect()->back()->with('success', 'Design added and stage updated.');
}


}
