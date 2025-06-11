<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Project;
use App\Models\Client;
use App\Models\Category;
use App\Models\Expense;

class accountantPayController extends Controller
{

    public function index()
{
     $clients = Client::all(); // Add this line
    $incomes = Income::with(['client', 'project', 'category'])->latest()->get();
    // return view('accountant.Payment.Pay', compact('incomes'));

     $projects = Project::all();
     $categories = Category::all();
    // $Income = Income::orderBy('name')->get();
    // return view('accountant.Expenses.Category', compact('categories'));

    return view('accountant.Payment.Pay', compact('clients','projects', 'categories','incomes'));

}



public function store(Request $request)
{
    $validated = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'project_id' => 'required|exists:projects,id',
        'category_id' => 'required|exists:categories,id',
        'amount' => 'required|numeric',
        'date' => 'required|date',
        'project_stage' => 'required|string|in:Measurement,Design,Production,Installation',
    ]);

    Income::create($validated);

    return response()->json(['message' => 'Income recorded successfully']);
}

// IncomeController.php
public function getProjectsByClient($client_id)
{
    $projects = Project::where('client_id', $client_id)->get();
    return response()->json($projects); // return projects as JSON
}


public function getProjectsByClient1($client_id)
{
     $clients = Project::where('client_id', $client_id)->get();
    // return response()->json($projects); // return projects as JSON
    return view('accountant.Payment.Pay', compact('clients'));
    // return view('accountant.Expenses', compact('expenses'));
}

// public function index()
// {
//       $expenses = Expense::with(['category', 'project'])->latest()->get();

//     $projects = Project::all();
//     $categories = Category::all();

//     $clients = Client::all(); // Add this line

//     return view('accountant.Payment.Pay', compact( 'projects', 'categories', 'expenses','clients'));
// }

public function getByClient($id)
{
    $projects = Project::where('client_id', $id)->get();
    return response()->json($projects);
}



}
