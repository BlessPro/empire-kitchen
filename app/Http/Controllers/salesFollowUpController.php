<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\FollowUp;
use App\Models\Project;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SalesFollowUpController extends Controller
{
    //

    // FollowUpController.php
public function index(Request $request)
{
    $clients = Client::all();
    $followUps = FollowUp::with(['client', 'project'])->latest()->paginate(5); // Initial page load paginated

    if ($request->ajax()) {
        return view('sales.partials.followup-table', compact('followUps'))->render();
    }

    return view('sales.FollowupManagement', compact('followUps', 'clients'));
}

// public function index1(Request $request)
// {
//     $clients = Client::all();
//     $followUps = FollowUp::with(['client', 'project'])->latest()->paginate(5);

//     if ($request->ajax()) {
//         return view('sales.partials.followup-table', compact('followUps'))->render();
//     }

//     return view('sales.FollowupManagement', compact('followUps', 'clients'));
// }


public function filter(Request $request)
{
    $status = $request->query('status');

    $query = FollowUp::with(['client', 'project'])->latest();

    if ($status && $status !== 'all') {
        $query->where('status', $status);
    }

    $followUps = $query->paginate(5);

    return view('sales.partials.followup-table', compact('followUps'))->render();
}

public function show(FollowUp $followUp)
{
    $followUp->load(['client', 'project']);

    return response()->json([
        'id' => $followUp->id,
        'client_name' => $followUp->client_name
            ?? trim(($followUp->client->firstname ?? '') . ' ' . ($followUp->client->lastname ?? '')),
        'client_id' => $followUp->client_id,
        'follow_up_date' => $followUp->follow_up_date,
        'follow_up_time' => $followUp->follow_up_time,
        'priority' => $followUp->priority,
        'status' => $followUp->status,
        'notes' => $followUp->notes,
        'project' => $followUp->project ? $followUp->project->name : null,
        'reminder_at' => $followUp->reminder_at ? $followUp->reminder_at->toIso8601String() : null,
        'reminder_status' => $followUp->reminder_status,
    ]);
}


// public function index()
// {
//     $clients=Client::all();
//     $followUps = FollowUp::with(['client', 'project'])->latest()->get();

//     return view('sales.FollowupManagement', compact('followUps','clients'));
// }

    public function store(Request $request)
{
    $data = $this->validateData($request);

    FollowUp::create($data);

    return redirect()->back()->with('success', 'Follow-up added successfully.');
}

public function update(Request $request, FollowUp $followUp)
{
    $data = $this->validateData($request);

    $followUp->update($data);

    return redirect()->back()->with('success', 'Follow-up updated successfully.');
}

    public function setReminder(Request $request, FollowUp $followUp)
    {
        $data = $request->validate([
            'reminder_at' => ['required', 'date'],
        ]);

        $reminderAt = Carbon::parse($data['reminder_at']);

        $followUp->update([
            'reminder_at' => $reminderAt,
            'reminder_status' => 'scheduled',
        ]);

        return response()->json([
            'ok' => true,
            'reminder_at' => $reminderAt->toIso8601String(),
            'reminder_status' => 'scheduled',
        ]);
    }

    public function reminderFeed(Request $request)
    {
        $now = Carbon::now();
        $threshold = $now->copy()->addMinutes(3);

        $toDueIds = FollowUp::query()
            ->whereNotNull('reminder_at')
            ->where('reminder_status', 'scheduled')
            ->where('reminder_at', '<=', $now)
            ->pluck('id');

        if ($toDueIds->isNotEmpty()) {
            FollowUp::whereIn('id', $toDueIds)->update(['reminder_status' => 'due']);
        }

        $due = FollowUp::query()
            ->whereNotNull('reminder_at')
            ->where('reminder_status', 'due')
            ->where('reminder_at', '<=', $now)
            ->with('client')
            ->get()
            ->map(fn ($f) => [
                'id' => $f->id,
                'client_name' => $f->client_name
                    ?? trim(($f->client->firstname ?? '') . ' ' . ($f->client->lastname ?? '')),
                'reminder_at' => $f->reminder_at?->toIso8601String(),
            ])
            ->values();

        $upcoming = FollowUp::query()
            ->whereNotNull('reminder_at')
            ->where('reminder_status', 'scheduled')
            ->whereBetween('reminder_at', [$now, $threshold])
            ->with('client')
            ->get()
            ->map(fn ($f) => [
                'id' => $f->id,
                'client_name' => $f->client_name
                    ?? trim(($f->client->firstname ?? '') . ' ' . ($f->client->lastname ?? '')),
                'reminder_at' => $f->reminder_at?->toIso8601String(),
                'seconds_to' => $f->reminder_at?->diffInSeconds($now),
            ])
            ->values();

        return response()->json([
            'now' => $now->toIso8601String(),
            'due' => $due,
            'upcoming' => $upcoming,
        ]);
    }

    public function acknowledgeReminder(FollowUp $followUp)
    {
        $followUp->update([
            'reminder_status' => 'acknowledged',
        ]);

        return response()->json(['ok' => true]);
    }

public function getClientProjects($id)
{
    $projects = Project::where('client_id', $id)->get(['id', 'name']);
    return response()->json($projects);
}

    protected function validateData(Request $request): array
{
    $validated = $request->validate([
        'client_id' => ['required', 'exists:clients,id'],
        'follow_up_date' => ['required', 'date'],
        'follow_up_time' => ['required'],
        'priority' => ['required', 'in:Low,Medium,High'],
        'status' => ['required', 'in:Sold,Unsold'],
        'notes' => ['nullable', 'string'],
    ]);

    $clientId = $validated['client_id'];
    $client = Client::find($clientId);
    $clientName = trim(($client->firstname ?? '') . ' ' . ($client->lastname ?? '')) ?: ($client->name ?? 'Client');

    return [
        'client_id' => $clientId,
        'client_name' => $clientName,
        'follow_up_date' => $validated['follow_up_date'],
        'follow_up_time' => $validated['follow_up_time'],
        'priority' => $validated['priority'],
        'status' => $validated['status'],
        'notes' => $validated['notes'],
        'project_id' => null,
    ];
}


}
