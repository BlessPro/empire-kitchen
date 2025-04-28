<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Gate;
//created on 2025-04-23
// app/Http/Controllers/ProjectController.php
class ProjectController extends Controller
{
    // public function index()
    // {
    //     $projects = Project::with('client')->paginate(10);
    //     return view('projects.index', compact('projects'));
    // }

    public function index()
{
    $projects = Project::paginate(15); // fetch paginated projects
    // dd($projects);

    return view('admin/Dashboard2', compact('projects'));
}
}

