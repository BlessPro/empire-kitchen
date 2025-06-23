<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\FollowUp;
use App\Models\Project;

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


// public function index()
// {
//     $clients=Client::all();
//     $followUps = FollowUp::with(['client', 'project'])->latest()->get();

//     return view('sales.FollowupManagement', compact('followUps','clients'));
// }

    public function store(Request $request)
{
    $validated = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'project_id' => 'nullable|exists:projects,id',
        'follow_up_date' => 'required|date',
        'follow_up_time' => 'required',
        'priority' => 'required|in:Low,Medium,High',
        'status' => 'required|in:Pending,Completed,Rescheduled',
        'notes' => 'nullable|string',
    ]);

    FollowUp::create($validated);

    return redirect()->back()->with('success', 'Follow-up added successfully.');
}

public function getClientProjects($id)
{
    $projects = Project::where('client_id', $id)->get(['id', 'name']);
    return response()->json($projects);
}


}
