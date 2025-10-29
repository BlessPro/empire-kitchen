<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class designerProjectDesignController extends Controller
{
    public function showUploadForm()
    {
        $designerId = Auth::id();
        $projects   = Project::where('designer_id', $designerId)->get();

        return view('designer.ProjectDesign', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'    => ['required','exists:projects,id'],
            'images.*'      => ['required','image','mimes:jpg,jpeg,png','max:10240'],
            'notes'         => ['nullable','string'],
            'schedule_date' => ['nullable','date'],
            'start_time'    => ['nullable','date_format:H:i'],
            'end_time'      => ['nullable','date_format:H:i'],
            'design_date'   => ['nullable','date'],
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('designs', 'public');
            }
        }

        $design = Design::where('project_id', $validated['project_id'])
            ->orderByDesc('design_date')
            ->orderByDesc('id')
            ->first();

        if (! $design) {
            $design = new Design([
                'project_id'  => $validated['project_id'],
                'design_date' => $validated['design_date'] ?? null,
            ]);
        }

        $design->designer_id   = Auth::id();
        $design->images        = $imagePaths;
        $design->notes         = $validated['notes'] ?? null;
        $design->schedule_date = $validated['schedule_date'] ?? $design->schedule_date;
        $design->start_time    = $validated['start_time'] ?? $design->start_time;
        $design->end_time      = $validated['end_time'] ?? $design->end_time;

        if (! empty($validated['design_date'])) {
            $design->design_date = $validated['design_date'];
        }

        $design->save();

        return back()->with('success', 'Design updated successfully!');
    }
}
