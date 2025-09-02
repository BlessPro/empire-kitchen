<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

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

public function StoreCreateMeasurement(Project $project){

    return view('tech.CreateMeasurement', compact('project'));
}

// public function create(Project $project)
// {
//     return view('measurements.create', compact('project'));
// }


 // JSON list of projects for a client (id + name)
    public function projects(Client $client)
    {
        // adjust to your real relationship/field names
        $projects = $client->projects()
            ->select('id', 'name') // or 'title' if your column is title
            ->orderBy('name')
            ->get();

        return response()->json($projects);
    }

    // Handle the modal POST
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'    => ['required', 'exists:clients,id'],
            'project_id'   => ['required', 'exists:projects,id'],
            'scheduled_at' => ['required', 'date'],
            'notes'        => ['nullable', 'string'],
        ]);

        Measurement::create($data);

        return back()->with('success', 'Measurement scheduled successfully.');
    }
// public function store(Request $request)
// {
//     $validated = $request->validate([
//         'client_id' => 'required|exists:clients,id',
//         'project_id' => 'required|exists:projects,id',
//         'measurement_date' => 'required|date',
//     ]);

//     Measurement::create($validated);

//     return redirect()->back()->with('success', 'Measurement scheduled successfully!');
// }


// public function store(Request $request)
// {

// //    dd($request->all());

//     $validated = $request->validate([
//         'project_id' => 'required|exists:projects,id',
//         'length' => 'required|numeric',
//         'height' => 'required|numeric',
//         'width' => 'required|numeric',
//         'notes' => 'nullable|string',
//         'obstacles' => 'nullable|string',

//         // 'images.*' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:10240', // 10MB
//     ]);

//     $imagePaths = [];
//     if ($request->hasFile('images')) {
//         foreach ($request->file('images') as $image) {
//             $imagePaths[] = $image->store('measurements', 'public');
//         }
//     }

//     Measurement::create([
//         'project_id' => $request->project_id, // Add hidden field or set programmatically
//         'user_id' => optional(Auth::user())->id,
//         'length' => $validated['length'],
//         'height' => $validated['height'],
//         'start_time' => now(),
//         'end_time' => now(),
//         'notes' => $validated['notes'] ?? null,
//         'width' => $validated['width'],
//         'obstacles' => $validated['obstacles'] ?? null,
//         'created_at' => now(),
//         'images' => $imagePaths,
//     ]);

//     return redirect()->route('tech.dashboard')->with('success', 'Measurement saved successfully.');
//     // return redirect()->route('designer.uploads')->with('success', 'Designs uploaded successfully!');

//  }
/**
     * Return FullCalendar events from measurements table.
     * URL: /TimeManagement/events
     */
    public function events(Request $request)
    {
        // Optionally filter by calendar’s visible range if you want:
        // $start = $request->query('start'); // ISO8601
        // $end   = $request->query('end');   // ISO8601

        $measurements = Measurement::with(['project:id,name,title'])
            ->orderBy('start_time')
            ->get();

        // Palette of nice colors (stable selection by project_id)
        $palette = [
            '#5A0562', '#FF5C00', '#0EA5E9', '#22C55E',
            '#F59E0B', '#8B5CF6', '#EF4444', '#14B8A6',
            '#3B82F6', '#D946EF'
        ];

        $events = $measurements->map(function ($m) use ($palette) {
            $projectName = $m->project->name ?? $m->project->title ?? ('Project #'.$m->project_id);

            // stable “random” color per project
            $idx = crc32((string)$m->project_id) % count($palette);
            $color = $palette[$idx];

            return [
                'id'    => $m->id,
                'title' => $projectName,
                'start' => optional($m->start_time)->toIso8601String(),
                // Provide end if you want a span on the calendar
                'end'   => optional($m->end_time)->toIso8601String(),
                // Color the date cell/event
                'backgroundColor' => $color,
                'borderColor'     => $color,
                'textColor'       => '#ffffff',

                // Small-card extra info
                'extendedProps' => [
                    'notes'      => $m->notes,
                    'project_id' => $m->project_id,
                ],
            ];
        })->values();

        return response()->json($events);
    }

}




