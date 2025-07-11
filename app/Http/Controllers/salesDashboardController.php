<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Income;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class salesDashboardController extends Controller
{

public function index(Request $request)
{
       // Fetch chart data counts
    $newClientsCount = Client::count();
    $inProgressProjects = Project::where('status', 'in progress')->count();
    $closedProjects = Project::whereIn('status', ['completed', 'closed'])->count();
    $followUpsCount = FollowUp::whereIn('status', ['Pending', 'Rescheduled'])->count();

    $chartData = [
        'newClients' => $newClientsCount,
        'inProgress' => $inProgressProjects,
        'followUps' => $followUpsCount,
        'closed' => $closedProjects,
    ];


    // Fetch latest follow-ups with clients
    // Use 'with' to eager load the client relationship
    $followUps = FollowUp::with(['client']) // load only client
        ->latest()
        ->paginate(5);

    if ($request->ajax()) {
        return view('sales.partials.dashboard-table', compact('followUps'))->render();
    }

    return view('sales.dashboard', compact('followUps','chartData'));
}






}

