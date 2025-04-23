<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard'); // Or just return a test string
    }


    //This method is for displaying name, role and profilepic of a logged user
     public function show($id)
    {
    // Fetch the user by ID
    $user = User::findOrFail($id);

    // Check if the user exists, and pass it to the view
    return view('admin.dashboard', ["user" => $user]);
    // If you want to pass the logged-in user, you can do so like this:
    // $user = Auth::user();
    // return view('admin.dashboard', compact('user'));
    // Or if you want to pass the user from the route parameter:
    // return view('admin.dashboard', ['user' => $user]);
    }


}

