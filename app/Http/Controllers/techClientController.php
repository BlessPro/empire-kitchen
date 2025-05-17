<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;

class techClientController extends Controller
{
    //
//     public function index(){
//     $projects = Project::paginate(15); // fetch paginated projects

//     return view('tech/ClientManagement', compact('projects'));
// }

public function clientProjects()
{
    $clients = Client::whereHas('projects', function ($query) {
        $query->where('current_stage', 'Measurement');
    })
    ->with(['projects' => function ($query) {
        $query->where('current_stage', 'Measurement')
              ->with('measurement');
    }])
    ->orderBy('created_at', 'desc')
    ->paginate(5); // Paginate the results

    return view('tech.ClientManagement', compact('clients'));
}


}
