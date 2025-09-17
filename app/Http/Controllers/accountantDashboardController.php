<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Income;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class accountantDashboardController extends Controller
{
    //


public function index()
{
    $clients = Client::all();

    // --- DEFAULTS so compact() always has variables ---
    $percentageChangeE = 0.0;   // expense %
    $percentageChangeI = 0.0;   // income  %
    $percentageChangeD = 0.0;   // "debt"/profit %

    // Expenses
    $now = \Carbon\Carbon::now();
    $currentMonth   = $now->month;
    $previousMonth  = $now->copy()->subMonth()->month;

    $currentMonthExpense = Expense::whereMonth('date', $currentMonth)
        ->whereYear('date', $now->year)
        ->sum('amount');

    $previousMonthExpense = Expense::whereMonth('date', $previousMonth)
        ->whereYear('date', $now->copy()->subMonth()->year)
        ->sum('amount');

    if ($previousMonthExpense > 0) {
        $percentageChangeE = (($currentMonthExpense - $previousMonthExpense) / $previousMonthExpense) * 100;
    }

    // Income (reuse $now/current/previous)
    $currentMonthIncome = Income::whereMonth('date', $currentMonth)
        ->whereYear('date', $now->year)
        ->sum('amount');

    $previousMonthIncome = Income::whereMonth('date', $previousMonth)
        ->whereYear('date', $now->copy()->subMonth()->year)
        ->sum('amount');

    if ($previousMonthIncome > 0) {
        // FIX: divide by $previousMonthIncome (was $previousMonthExpense)
        $percentageChangeI = (($currentMonthIncome - $previousMonthIncome) / $previousMonthIncome) * 100;
    }

    // Totals / profit + guard divide-by-zero
    $totalIncome  = Income::sum('amount');
    $totalExpense = Expense::sum('amount');
    $netProfit    = $totalIncome - $totalExpense;

    if ($totalExpense > 0) {
        $percentageChangeD = ($netProfit / $totalExpense) * 100;
    }

    $RecentIncomes         = Income::orderByDesc('date')->paginate(5);
    $DashboardIncomeTables = Income::orderByDesc('date')->paginate(5);
    $projects              = Project::paginate(10);

    return view('accountant.Dashboard', compact(
        'projects',
        'totalIncome',
        'totalExpense',
        'netProfit',
        'currentMonthExpense',
        'previousMonthExpense',
        'percentageChangeE',
        'currentMonthIncome',
        'previousMonthIncome',
        'percentageChangeI',
        'percentageChangeD',
        'RecentIncomes',
        'DashboardIncomeTables',
        'clients'
    ));
}


}
