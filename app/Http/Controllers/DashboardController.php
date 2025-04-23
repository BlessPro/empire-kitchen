<?php

namespace App\Http\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


 class DashboardController extends Controller
 {

public function show($id)
{
    // Fetch the user by ID
    $user = User::findOrFail($id);

    // Check if the user exists, and pass it to the view
    return view('admin.dashboard', ['user' => $user]);
    // If you want to pass the logged-in user, you can do so like this:
    // $user = Auth::user();
    // return view('admin.dashboard', compact('user'));
    // Or if you want to pass the user from the route parameter:
    // return view('admin.dashboard', ['user' => $user]);
}


// namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class DashboardController extends Controller
// {
//     //

//     public function index()
//     {
//         $user = Auth::user(); // get logged-in user

//         return view('admin.dashboard', compact('user'));
//     }
 }
