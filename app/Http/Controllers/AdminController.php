<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard'); // Or just return a test string
    }


    //This method is for displaying name, role and profilepic of a logged user
    // public function tableview()
    // {
    //     $projects = Project::with( 'client')->paginate(10);
    //     return view('admin.dashboard',  compact('projects'));
    // }


}

