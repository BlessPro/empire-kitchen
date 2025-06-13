<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    // Fetch the current month and previous month income
        $now = Carbon::now();
    $currentMonth = $now->month;
    $previousMonth = $now->copy()->subMonth()->month;

    $currentMonthIncome = Income::whereMonth('date', $currentMonth)
                                ->whereYear('date', $now->year)
                                ->sum('amount');

    $previousMonthIncome = Income::whereMonth('date', $previousMonth)
                                 ->whereYear('date', $now->copy()->subMonth()->year)
                                 ->sum('amount');

    $percentageChange = 0;

    if ($previousMonthIncome > 0) {
        $percentageChange = (($currentMonthIncome - $previousMonthIncome) / $previousMonthIncome) * 100;
    }

 //   $expense=Expense::sum(('amount'));
    //$expenseSum=sum($expense);
    $totalIncome = Income::sum('amount');
    $totalExpense = Expense::sum('amount');
    $netProfit = $totalIncome - $totalExpense;
    $projects = Project::paginate(10); // fetch paginated projects
    return view('/accountant/Dashboard', 
    compact('projects',
     'totalIncome',
     'totalExpense', 
     'netProfit','currentMonthIncome',
     'previousMonthIncome',
     'percentageChange'));
}



// use Carbon\Carbon;
// use App\Models\Income;

// public function dashboard()
// {
//     $now = Carbon::now();
//     $currentMonth = $now->month;
//     $previousMonth = $now->copy()->subMonth()->month;

//     $currentMonthIncome = Income::whereMonth('date', $currentMonth)
//                                 ->whereYear('date', $now->year)
//                                 ->sum('amount');

//     $previousMonthIncome = Income::whereMonth('date', $previousMonth)
//                                  ->whereYear('date', $now->copy()->subMonth()->year)
//                                  ->sum('amount');

//     $percentageChange = 0;

//     if ($previousMonthIncome > 0) {
//         $percentageChange = (($currentMonthIncome - $previousMonthIncome) / $previousMonthIncome) * 100;
//     }

//     return view('your.blade.view', compact(
//         'currentMonthIncome',
//         'previousMonthIncome',
//         'percentageChange'
//     ));
// }


}
