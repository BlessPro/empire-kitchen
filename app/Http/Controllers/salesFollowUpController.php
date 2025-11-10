<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\FollowUp;
use App\Models\Project;
use Illuminate\Support\Str;

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

public function getClientProjects($id)
{
    $projects = Project::where('client_id', $id)->get(['id', 'name']);
    return response()->json($projects);
}

    protected function validateData(Request $request): array
{
    $validated = $request->validate([
        'client_name' => ['required', 'string', 'max:255'],
        'client_id' => ['nullable', 'exists:clients,id'],
        'follow_up_date' => ['required', 'date'],
        'follow_up_time' => ['required'],
        'priority' => ['required', 'in:Low,Medium,High'],
        'status' => ['required', 'in:Sold,Unsold'],
        'notes' => ['nullable', 'string'],
    ]);

    $clientId = $validated['client_id'] ?? null;

    if (!$clientId) {
        $normalized = Str::lower(trim($validated['client_name']));
        $matchedClient = Client::all()->first(function ($client) use ($normalized) {
            $fullName = Str::lower(trim(($client->firstname ?? '') . ' ' . ($client->lastname ?? '')));
            return $fullName === $normalized;
        });

        if ($matchedClient) {
            $clientId = $matchedClient->id;
        }
    }

    return [
        'client_id' => $clientId,
        'client_name' => $validated['client_name'],
        'follow_up_date' => $validated['follow_up_date'],
        'follow_up_time' => $validated['follow_up_time'],
        'priority' => $validated['priority'],
        'status' => $validated['status'],
        'notes' => $validated['notes'],
        'project_id' => null,
    ];
}


}
