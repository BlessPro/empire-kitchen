<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class accountantCategoryController extends Controller
{
    //
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Category::create($validated);

    return redirect()->back()->with('success', 'Category added successfully!');
}

public function index()
{
    // Use pagination so the view can call links()
    $categories = Category::orderBy('name')->paginate(10);
    return view('accountant.Expenses.Category', compact('categories'));
}

 public function destroy($id)
    {
        $Category = Category::findOrFail($id);
        $Category->delete();

        return redirect()->back()->with('success', 'Expense successfully! deleted ');
    }
}

