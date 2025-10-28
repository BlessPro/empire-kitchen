<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Installation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use App\Models\Project;
class InstallationCalendarController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id'   => [
                'required',
                Rule::exists('projects','id')->where(
                    fn($q) => $q->whereRaw("LOWER(TRIM(COALESCE(booked_status,''))) = 'booked'")
                ),
            ],
            'install_date' => ['required','date'],                       // YYYY-MM-DD
            'install_time' => ['required','regex:/^\d{2}:\d{2}(:\d{2})?$/'], // HH:MM or HH:MM:SS
            'notes'        => ['nullable','string','max:1000'],
        ]);

        // normalize time to HH:MM for consistency
        $time = strlen($data['install_time']) === 8
            ? substr($data['install_time'], 0, 5)
            : $data['install_time'];

        // combine into start_time using app timezone
        $data['start_time'] = Carbon::createFromFormat(
            'Y-m-d H:i',
            "{$data['install_date']} {$time}",
            config('app.timezone')
        );

        $data['user_id'] = $request->user()->id ?? null;

        Installation::create($data);

        return redirect()
            ->route('admin.ScheduleInstallation')
            ->with('status', 'Installation saved successfully.');
    }


 public function index()
    {

    $bookedProjects = Project::whereRaw("LOWER(TRIM(COALESCE(booked_status,''))) = 'booked'")
            ->orderBy('name')
            ->get(['id','name']);

        return view('admin.ScheduleInstallation', compact('bookedProjects'));
    }
public function update(\Illuminate\Http\Request $request, int $installation)
{
    // validate (mirror your store rules)
    $data = $request->validate([
        'project_id'   => ['required','integer','exists:projects,id'],
        'install_date' => ['required','date'],        // YYYY-MM-DD
        'install_time' => ['required'],               // HH:MM (store as string or time column)
        'notes'        => ['nullable','string','max:2000'],
    ]);

    $model = \App\Models\Installation::query()->findOrFail($installation);

    // Optional: you can protect edits (e.g., ensure same client/tenant)
    // For now, we keep it open to any authenticated user (like your store).

    $model->project_id   = $data['project_id'];
    $model->install_date = $data['install_date'];
    $model->install_time = $data['install_time'];
    $model->notes        = $data['notes'] ?? null;
    $model->save();

    return response()->json(['ok' => true]);
}


public function update_old(Request $r, \App\Models\Installation $installation)
{


$data = $r->validate([
    'project_id'   => [
        'required',
        Rule::exists('projects', 'id')->where(
            fn($q) => $q->whereRaw("LOWER(TRIM(status)) = 'booked'")
        ),
    ],
    'install_date' => ['required','date'],
    'install_time' => ['required','regex:/^\d{2}:\d{2}(:\d{2})?$/'],
    'notes'        => ['nullable','string','max:1000'],
]);
    // If date or time included, recompute start_time
    if (array_key_exists('install_date', $data) || array_key_exists('install_time', $data)) {
        $date = $data['install_date'] ?? optional($installation->install_date)->format('Y-m-d');
        $time = $data['install_time'] ?? ($installation->install_time ?? '09:00');
        if (strlen($time) === 8) { $time = substr($time, 0, 5); } // HH:MM:SS -> HH:MM
        if ($date && $time) {
            $data['start_time'] = Carbon::createFromFormat('Y-m-d H:i', "$date $time", config('app.timezone'));
        }
    }

    $installation->update($data);

    return response()->json(['ok' => true]);
}


public function feed(Request $r)
{
    // Optional range you can use to limit DB query:
    $start = $r->query('start'); // YYYY-MM-DD
    $end   = $r->query('end');   // YYYY-MM-DD

    $q = \App\Models\Installation::query()
        ->with(['project:id,name', 'client:id,firstname,lastname']) // adjust relations you have
        ->orderBy('install_date', 'asc');

    if ($start) $q->whereDate('install_date', '>=', $start);
    if ($end)   $q->whereDate('install_date', '<=', $end);

    // small stable palette
    $palette = ['#5A0562','#F59E0B','#10B981','#3B82F6','#EF4444','#8B5CF6','#14B8A6','#F43F5E'];

    $events = $q->get()->map(function($ins) use ($palette) {
        $pid = (int)($ins->project_id ?? 0);
        $idx = $pid ? ($pid % count($palette)) : 0;
        $color = $palette[$idx];

        $projName = $ins->project->name ?? 'Project #'.$pid;
        $client   = $ins->client
            ? trim(($ins->client->firstname ?? '').' '.($ins->client->lastname ?? ''))
            : null;

        return [
            'id'    => (string)$ins->id,
            'title' => $projName,
            'start' => optional($ins->install_date)->format('Y-m-d'), // all-day start only
            'allDay'=> true,

            // pass color and other stuff as extended props
            'extendedProps' => [
                'project_id'   => $pid,
                'color'        => $color,
                'client'       => $client,
                'notes'        => $ins->notes,
                'figma_url'    => $ins->figma_url ?? null,    // if you have one
                'image_url'    => $ins->image_url ?? null,    // thumbnail if any
                'install_date' => optional($ins->install_date)->toDateString(),
            ],
        ];
    });

    return response()->json($events);
}




    // app/Http/Controllers/InstallationCalendarController.php
// public function feed(Request $req)
// {
//     // RETURN STUB EVENTS — just to prove the page works.
//     return response()->json([
//         [
//             'id' => 1,
//             'title' => 'Stub Project',
//             'start' => now()->addDay()->setTime(10, 0)->toIso8601String(),
//             'allDay' => false,
//             'backgroundColor' => '#8B5CF6',
//             'borderColor' => '#8B5CF6',
//             'textColor' => '#ffffff',
//             'extendedProps' => [
//                 'project_id' => 999,
//                 'notes' => 'This is a stub event',
//                 'is_done' => false,
//                 'start_local' => now()->addDay()->setTime(10, 0)->format('Y-m-d H:i:s'),
//             ],
//         ],
//     ]);
// }


    /** Mark installation as done */
    public function markDone(Installation $installation)
    {
        if (!$installation->is_done) {
            $installation->forceFill([
                'is_done' => true,
                'done_at' => now(),
            ])->save();
        }
        return response()->json(['ok'=>true]);
    }

    /** Delete installation */
    public function destroy(Installation $installation)
    {
        $installation->delete();
        return response()->json(['ok'=>true]);
    }
}


