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
    $categories = Category::orderBy('name')->get();
    return view('accountant.Expenses.Category', compact('categories'));
}

}

