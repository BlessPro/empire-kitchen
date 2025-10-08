<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
//for showing the expenses
public function index()
{
    $expenses = Expense::with(['category', 'project'])->latest()->get();


    $projects = Project::all();
    $categories = Category::all();
    return view('accountant.Expenses', compact('projects', 'categories','expenses'));
    // return view('accountant.Expenses', compact('expenses'));
}
//for deleting the expense

 public function destroy($id)

 {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->back()->with('success', 'Expense successfully! deleted ');
    }

//for storing the expense
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

    //showing the category page
    public function ShowCategory()
    {
        return view('accountant.Expenses.Category');
    }




    public function edit(Expense $expense)
{
    return response()->json($expense);
}

public function update(Request $request, Expense $expense)
{
    $validated = $request->validate([
        'expense_name' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'date' => 'required|date',
        'project_id' => 'required|exists:projects,id',
        'category_id' => 'required|exists:categories,id',
        'notes' => 'nullable|string',
        'accountant_id' => 'required|exists:users,id',
    ]);

    $expense->update($validated);

    return redirect()->back()->with('success', 'Expense updated successfully!');
}


// ExpenseController.php

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

}
