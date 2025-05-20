<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeasurementController extends Controller
{
    // public function index()
    // {
    //     // Fetch clients whose projects are at the Measurement stage
    //     $clients = Client::with(['projects' => function ($query) {
    //         $query->where('current_stage', 'Measurement')->with('measurement');
    //     }])->get();

    //     return view('tech.ClientManagement', compact('clients'));
    // }

//     public function index()
// {
//     $clients = Client::whereHas('projects', function ($query) {
//         $query->where('current_stage', 'Measurement');
//     })
//     ->with(['projects' => function ($query) {
//         $query->where('current_stage', 'Measurement')->with('measurement');
//     }])
//     ->paginate(15);

//     return view('tech.ClientManagement', compact('clients'));
// }


public function clientProjects()
{
    $clients = Client::whereHas('projects', function ($query) {
        $query->where('current_stage', 'Measurement');
    })
    ->with(['projects' => function ($query) {
        $query->where('current_stage', 'Measurement')->with('measurement');
    }]) ->orderBy('created_at', 'desc') // Order by newest
                     ->paginate(5);// ✅ This works because it’s still an Eloquent Builder

    return view('tech.ClientManagement', compact('clients'));

}

public function StoreCreateMeasurement(){

    return view('tech.CreateMeasurement');
}



public function store(Request $request)
{
    $validated = $request->validate([
        'length' => 'required|numeric',
        'height' => 'required|numeric',
        'width' => 'required|numeric',
        'notes' => 'nullable|string',
        'obstacles' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:10240', // 10MB
    ]);

    $imagePaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePaths[] = $image->store('measurements', 'public');
        }
    }

    Measurement::create([
        'project_id' => $request->project_id, // Add hidden field or set programmatically
        'user_id' => optional(Auth::user())->id,
        'length' => $validated['length'],
        'height' => $validated['height'],
        'width' => $validated['width'],
        'obstacles' => $validated['obstacles'] ?? null,
        'measured_at' => now(),
        'images' => $imagePaths,
    ]);

    return back()->with('success', 'Measurement saved successfully.');
}


}




