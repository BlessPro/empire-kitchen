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

class DashboardController extends Controller
{
    //

    // public function index()
    // {
    //     $projects = Project::latest()->take(5)->get(); // or however many you want

    //     return view('admin.bick', compact('projects'));
    // }

    // public function dashboard()
    // {
    //     $latestProjectWithAllDates = Project::whereNotNull('measurement_date')
    //         ->whereNotNull('design_date')
    //         ->whereNotNull('installation_date')
    //         ->whereNotNull('production_date')
    //         ->latest()
    //         ->first();

    //     $projects = Project::with('client')->get();

    //     return view('admin.bick', compact('latestProjectWithAllDates', 'projects'));

    // }

    public function index()
{
    $projects = Project::paginate(10); // fetch paginated projects
    return view('admin/Dashboard', compact('projects'));
}

}
