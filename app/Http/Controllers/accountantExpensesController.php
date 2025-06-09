<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class accountantExpensesController extends Controller
{
    // //
    // public  function index()
    // {
    //     return view('accountant.expenses');
    // }
public function showExpenses()
{
    $projects = Project::all();
    $categories = Category::all();
    return view('accountant.Expenses', compact('projects', 'categories'));
}

// public function store(Request $request)
// {
//     $validated = $request->validate([
//         'expense_name' => 'required|string|max:255',
//         'amount' => 'required|numeric',
//         'date' => 'required|date',
//         'project_id' => 'required|exists:projects,id',
//         'category_id' => 'required|exists:categories,id',
//         'notes' => 'nullable|string',
//     ]);
//     $validated['accountant_id'] = Auth::user()->id; // assuming user is accountant
//     // $validated['accountant_id'] = auth()->user()->id; // assuming user is accountant

//     Expense::create($validated);

//     return redirect()->back()->with('success', 'Expense recorded successfully.');
// }
// public function index()
// {
//     $expenses = Expense::orderBy('name')->get();
//     return view('accountant.Expenses', compact('expenses'));
// }


public function index()
{
    $expenses = Expense::with(['category', 'project'])->latest()->get();


    $projects = Project::all();
    $categories = Category::all();
    return view('accountant.Expenses', compact('projects', 'categories','expenses'));
    // return view('accountant.Expenses', compact('expenses'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'expense_name' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'date' => 'required|date',
        'project_id' => 'required|exists:projects,id',
        'category_id' => 'required|exists:categories,id',
        'notes' => 'nullable|string',
        'accountant_id' => 'required|exists:users,id', // Ensure the accountant ID is valid
    ]);
        $validated['accountant_id'] = Auth::id();


    Expense::create($validated);

    return redirect()->back()->with('success', 'Expense added successfully!');
}


    public function ShowCategory()
    {
        return view('accountant.Expenses.Category');
    }
}
