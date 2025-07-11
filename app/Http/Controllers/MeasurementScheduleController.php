<?php
namespace App\Http\Controllers;

use App\Models\MeasurementSchedule;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeasurementScheduleController extends Controller
{
    public function index()
    {
        $clients = Client::with('projects')->get();
        return view('tech.ScheduleMeasurement', compact('clients'));
    }

    // public function events()
    // {
    //     return MeasurementSchedule::with('project')->get()->map(function ($m) {
    //         return [
    //             'id' => $m->id,
    //             'title' => $m->project->name ?? 'No Project',
    //             'start' => $m->start_time,
    //             'end' => $m->end_time,
    //             'color' => '#701a75', // fuchsia-900
    //             'notes' => $m->notes,
    //             'client_id' => $m->client_id,
    //             'project_id' => $m->project_id,
    //         ];
    //     });
    // }





    public function events()
{
    try {
        $events = MeasurementSchedule::with('project')->get()->map(function ($m) {
            return [
                'id' => $m->id,
                'title' => $m->project->name ?? 'No Project',
                'start' => $m->start_time->toIso8601String(),
                'end' => $m->end_time->toIso8601String(),
                'color' => '#701a75',
                'notes' => $m->notes,
            ];
        });

        return response()->json($events);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => true,
            'message' => $e->getMessage(),
        ], 500);
    }
}






//     public function events()
// {
//     try {
//         $events = MeasurementSchedule::with('project')->get()->map(function ($m) {
//             return [
//                 'id' => $m->id,
//                 'title' => $m->project->name ?? 'No Project',
//                 'start' => $m->start_time,
//                 'end' => $m->end_time,
//                 'color' => '#701a75',
//                 'notes' => $m->notes,
//             ];
//         });

//         return response()->json($events);
//     } catch (\Throwable $e) {
//         return response()->json([
//             'error' => true,
//             'message' => $e->getMessage(),
//         ], 500);
//     }
// }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'required|exists:projects,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'notes' => 'nullable|string',
        ]);

        MeasurementSchedule::create($validated);

        return response()->json(['success' => true, 'message' => 'Measurement scheduled']);
    }

    public function update(Request $request, $id)
    {
        $schedule = MeasurementSchedule::findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'required|exists:projects,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'notes' => 'nullable|string',
        ]);

        $schedule->update($validated);

        return response()->json(['success' => true, 'message' => 'Schedule updated']);
    }

    public function destroy($id)
    {
        MeasurementSchedule::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Schedule deleted']);
    }
}
