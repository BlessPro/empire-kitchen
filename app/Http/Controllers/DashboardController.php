<?php

namespace App\Http\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


 class DashboardController extends Controller
 {

    public function tableview()
    {
        $projects = Project::with('client')->paginate(10);
        return view('projects.index', compact('projects'));
    }



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
