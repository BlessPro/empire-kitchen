<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Income;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class salesDashboardController extends Controller
{

public function index()
{
    $today = Carbon::today();

    // ---- Stats Summary ----
    $soldFollowUpsCount = FollowUp::where('status', 'Sold')->count();

    $startOfWeek = $today->copy()->startOfWeek();
    $endOfWeek   = $today->copy()->endOfWeek();

    $dueThisWeekCount = FollowUp::whereBetween('follow_up_date', [$startOfWeek, $endOfWeek])->count();

    $overdueCount = FollowUp::where('follow_up_date', '<', $today)
        ->where('status', '!=', 'Sold')
        ->count();

    // ---- Table Data ----
    // Show latest or upcoming follow-ups with client name, due date, priority, and status
    $recentFollowUps = FollowUp::select('client_name', 'follow_up_date', 'priority', 'status')
        ->orderBy('follow_up_date', 'asc')
        ->limit(10)
        ->get();


    return view('sales.dashboard', [
        'soldFollowUpsCount' => $soldFollowUpsCount,
        'dueThisWeekCount'   => $dueThisWeekCount,
        'overdueCount'       => $overdueCount,
        'recentFollowUps'    => $recentFollowUps,
    ]);
}


}
