<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\DB;
use App\Models\Client;

class accountantReportsController extends Controller
{
    //
    // public function index()
    // {
    //     return view('accountant.Reports&Analytics');
    // }

// Controller Method (ClientIncomeReportController.php)


public function report(Request $request)
{
    // Fetch all clients
    $clients22 = Client::all();

    // Prepare the summary data
    $clientIncomes = $clients22->map(function ($client) {
        $incomes22 = Income::where('client_id', $client->id)->orderBy('date')->get();

        if ($incomes22->isEmpty()) {
            return null;
        }

        return [
            'client_name' => $client->name,
            'total_income' => $incomes22->sum('amount'),
            'from_date' => $incomes22->first()->date->format('Y-m-d'),
            'to_date' => $incomes22->last()->date->format('Y-m-d'),
        ];
    })->filter();

    return view('accountant.client-income-report', compact('clientIncomes'));
}


public function index(Request $request)
{
    $from = $request->input('from');
    $to = $request->input('to');

    $incomes = Income::with('client')
        ->when($from, fn($query) => $query->whereDate('created_at', '>=', $from))
        ->when($to, fn($query) => $query->whereDate('created_at', '<=', $to))
        ->selectRaw('client_id, SUM(amount) as total_income')
        ->groupBy('client_id')
        ->paginate(10);

        $incomes1= Income::paginate(10);

        
    // Fetch all clients
    $clients22 = Client::all();

    // Prepare the summary data
    $clientIncomes = $clients22->map(function ($client) {
        $incomes22 = Income::where('client_id', $client->id)->orderBy('date')->get();

        if ($incomes22->isEmpty()) {
            return null;
        }

        return [
            'client_name' => $client->title. ' ' . $client->firstname. ' ' . $client->lastname,
            'total_income' => $incomes22->sum('amount'),
            'from_date' => $incomes22->first()->date->format('Y-m-d'),
            'to_date' => $incomes22->last()->date->format('Y-m-d'),
            'status' => $incomes22->last()->status ?? 'Unknown', // get status from last income

        ];
    })->filter();

    return view('accountant.Reports&Analytics', compact('incomes', 'incomes1','from', 'to','clientIncomes'));
}

//for the monthly expenses chart data
public function getMonthlyChartData()
{
    $expenses = DB::table('expenses')
        ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(amount) as total'))
        ->groupBy(DB::raw('MONTH(date)'))
        ->orderBy(DB::raw('MONTH(date)'))
        ->get();

    // Format: [0, 0, 500, 1000, ...] (January = index 0)
    $monthlyData = array_fill(0, 12, 0);

    foreach ($expenses as $expense) {
        $index = $expense->month - 1; // 0-based index for Chart.js
        $monthlyData[$index] = $expense->total;
    }

    return response()->json($monthlyData);
}

//for the monthly income chart data
public function getMonthlyIncomeChartData()
{
    $incomes = DB::table('incomes')
        ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(amount) as total'))
        ->groupBy(DB::raw('MONTH(date)'))
        ->orderBy(DB::raw('MONTH(date)'))
        ->get();

    // Format: [0, 0, 500, 1000, ...] (January = index 0)
    $monthlyIncomeData = array_fill(0, 12, 0);

    foreach ($incomes as $income) {
        $index = $income->month - 1; // 0-based index for Chart.js
        $monthlyIncomeData[$index] = $income->total;
    }

    return response()->json($monthlyIncomeData);
}
}
