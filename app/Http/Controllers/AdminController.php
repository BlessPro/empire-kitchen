<?php
// modified: 24.04.2025

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use app\Models\Client;
class AdminController extends Controller
{
    // public function index()
    // {
    //     return view('admin.dashboard'); // Or just return a test string
    // }


    // public function dashboard()
    // {
    // // Bar chart logic
    // $latestProjectWithAllDates = Project::whereNotNull('measurement_date')
    //     ->whereNotNull('design_date')
    //     ->whereNotNull('installation_date')
    //     ->whereNotNull('production_date')
    //     ->latest()
    //     ->first();

    // // Table logic
    // $projects = Project::with('client')->get();

    // return view('admin.dashboard', compact('latestProjectWithAllDates', 'projects'));

    // public function dashboard()
    // {
    //     $latestProjectWithAllDates = Project::whereNotNull('measurement_date')
    //         ->whereNotNull('design_date')
    //         ->whereNotNull('installation_date')
    //         ->whereNotNull('production_date')
    //         ->latest()
    //         ->first();

    //     $projects = Project::with('client')->get();

    //     return view('admin.dashboard', compact('latestProjectWithAllDates', 'projects'));

    // }

    public function index()
{
        //   $latestProjectWithAllDates = Project::whereNotNull('measurement_date');
            // ->whereNotNull('design_date')
            // ->whereNotNull('installation_date')
            // ->whereNotNull('production_date')
            // ->latest()
            // ->first();

    $projects = Project::paginate(10); // fetch paginated projects
    // return view('admin/dashboard', compact(['latestProjectWithAllDates','projects']));
    return view('admin/dashboard', compact(['projects']));


}

    //This method is for displaying name, role and profilepic of a logged user
    // public function tableview()
    // {
    //     $projects = Project::with( 'client')->paginate(10);
    //     return view('admin.dashboard',  compact('projects'));
    // }


}


