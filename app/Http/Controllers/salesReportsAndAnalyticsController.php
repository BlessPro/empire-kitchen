<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Income;
use App\Models\FollowUp;
use Illuminate\Http\Request;

class salesReportsAndAnalyticsController extends Controller
{
    public function index(Request $request)
    {


        $projects = Project::with(['client', 'techSupervisor'])
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return view('sales.partials.reports-table', compact('projects'))->render();
        }

    // 1. Count of completed projects
    $closedDeals = Project::where('status', 'Completed')->count();

    // 2. Sum of income amounts
    $totalRevenue = Income::sum('amount');

    // 3. Count of completed follow-ups
    $completedFollowUps = FollowUp::where('status', 'Completed')->count();

    return view('sales.ReportsandAnalytics', compact('closedDeals', 'totalRevenue', 'completedFollowUps', 'projects'));
        // return view('sales.ReportsandAnalytics', compact('projects'));
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate(['status' => 'required|string']);

    $followUp = FollowUp::findOrFail($id);
    $followUp->status = $request->status;
    $followUp->save();

return response()->json(['success' => true, 'message' => 'Status updated']);
}


}
