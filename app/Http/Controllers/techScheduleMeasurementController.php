<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class techScheduleMeasurementController extends Controller
{
    /**
     * Render the measurement calendar for the logged-in tech.
     */
    public function index()
    {
        $techId = Auth::id();

        $projects = Project::query()
            ->where('tech_supervisor_id', $techId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('tech.ScheduleMeasurement', compact('projects'));
    }

    /**
     * Return measurements as calendar events.
     */
    public function feed(Request $request)
    {
        $techId = Auth::id();

        $start = $request->query('start');
        $end   = $request->query('end');

        $query = Measurement::query()
            ->with([
                'project:id,name,tech_supervisor_id,client_id',
                'project.client:id,firstname,lastname',
            ])
            ->whereHas('project', fn ($q) => $q->where('tech_supervisor_id', $techId))
            ->orderByDesc('scheduled_date')
            ->orderByDesc('start_time');

        if ($start) {
            $query->whereDate('scheduled_date', '>=', $start);
        }
        if ($end) {
            $query->whereDate('scheduled_date', '<=', $end);
        }

        $palette = ['#5A0562','#F59E0B','#10B981','#3B82F6','#EF4444','#8B5CF6','#14B8A6','#F43F5E'];

        $events = $query->get()->map(function (Measurement $measurement) use ($palette) {
            $project      = $measurement->project;
            $projectId    = $project?->id ?? 0;
            $projectName  = $project?->name ?? 'Project #' . $projectId;
            $clientName   = $project?->client
                ? trim(($project->client->firstname ?? '') . ' ' . ($project->client->lastname ?? ''))
                : null;

            $scheduledDate = $measurement->scheduled_date;
            $startTime     = $measurement->start_time;
            $endTime       = $measurement->end_time;

            $colorIndex = $projectId ? ($projectId % count($palette)) : 0;
            $color      = $palette[$colorIndex];

            $start = $startTime
                ? $startTime->toIso8601String()
                : ($scheduledDate ? Carbon::parse($scheduledDate)->startOfDay()->toIso8601String() : null);

            $end = $endTime
                ? $endTime->toIso8601String()
                : ($start ? Carbon::parse($start)->copy()->addHour()->toIso8601String() : null);

            return [
                'id'    => (string) $measurement->id,
                'title' => $projectName,
                'start' => $start,
                'end'   => $end,
                'allDay'=> false,
                'extendedProps' => [
                    'project_id'        => $projectId,
                    'color'             => $color,
                    'client'            => $clientName,
                    'notes'             => $measurement->notes,
                    'measurement_date'  => $scheduledDate?->toDateString(),
                    'startLabel'        => $startTime?->format('M j, Y g:i A'),
                    'endLabel'          => $endTime?->format('M j, Y g:i A'),
                    'start_time'        => $startTime?->format('H:i'),
                    'end_time'          => $endTime?->format('H:i'),
                    'duration_minutes'  => ($startTime && $endTime) ? $startTime->diffInMinutes($endTime) : null,
                ],
            ];
        });

        return response()->json($events);
    }

    /**
     * Store a newly scheduled measurement.
     */
    public function store(Request $request)
    {
        $techId = Auth::id();

        $data = $request->validate([
            'project_id'        => [
                'required',
                Rule::exists('projects', 'id')->where(fn ($q) => $q->where('tech_supervisor_id', $techId)),
            ],
            'measurement_date'  => ['required', 'date'],
            'measurement_time'  => ['required', 'date_format:H:i'],
            'duration_minutes'  => ['nullable', 'integer', 'min:15', 'max:600'],
            'notes'             => ['nullable', 'string', 'max:1000'],
        ]);

        $start = Carbon::createFromFormat('Y-m-d H:i', "{$data['measurement_date']} {$data['measurement_time']}", config('app.timezone'));

        $durationMinutes = $data['duration_minutes'] ?? 60;
        $end = (clone $start)->addMinutes($durationMinutes);

        $measurement = Measurement::create([
            'project_id'     => $data['project_id'],
            'user_id'        => $techId,
            'scheduled_date' => $start->toDateString(),
            'start_time'     => $start,
            'end_time'       => $end,
            'notes'          => $data['notes'] ?? null,
        ]);

        return response()->json([
            'ok' => true,
            'id' => $measurement->id,
        ], 201);
    }

    /**
     * Update an existing measurement slot.
     */
    public function update(Request $request, int $measurement)
    {
        $techId = Auth::id();

        $model = Measurement::query()
            ->where('id', $measurement)
            ->whereHas('project', fn ($q) => $q->where('tech_supervisor_id', $techId))
            ->firstOrFail();

        $data = $request->validate([
            'project_id'        => [
                'required',
                Rule::exists('projects', 'id')->where(fn ($q) => $q->where('tech_supervisor_id', $techId)),
            ],
            'measurement_date'  => ['required', 'date'],
            'measurement_time'  => ['required', 'date_format:H:i'],
            'duration_minutes'  => ['nullable', 'integer', 'min:15', 'max:600'],
            'notes'             => ['nullable', 'string', 'max:1000'],
        ]);

        $start = Carbon::createFromFormat('Y-m-d H:i', "{$data['measurement_date']} {$data['measurement_time']}", config('app.timezone'));
        $durationMinutes = $data['duration_minutes'] ?? 60;
        $end = (clone $start)->addMinutes($durationMinutes);

        $model->fill([
            'project_id'     => $data['project_id'],
            'scheduled_date' => $start->toDateString(),
            'start_time'     => $start,
            'end_time'       => $end,
            'notes'          => $data['notes'] ?? null,
        ]);

        $model->save();

        return response()->json(['ok' => true]);
    }

    /**
     * Remove a measurement slot.
     */
    public function destroy(int $measurement)
    {
        $techId = Auth::id();

        $model = Measurement::query()
            ->where('id', $measurement)
            ->whereHas('project', fn ($q) => $q->where('tech_supervisor_id', $techId))
            ->firstOrFail();

        $model->delete();

        return response()->json(['ok' => true]);
    }
}
