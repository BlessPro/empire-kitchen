<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    // public function index()
    // {
    //     // Fetch clients whose projects are at the Measurement stage
    //     $clients = Client::with(['projects' => function ($query) {
    //         $query->where('current_stage', 'Measurement')->with('measurement');
    //     }])->get();

    //     return view('tech.ClientManagement', compact('clients'));
    // }

//     public function index()
// {
//     $clients = Client::whereHas('projects', function ($query) {
//         $query->where('current_stage', 'Measurement');
//     })
//     ->with(['projects' => function ($query) {
//         $query->where('current_stage', 'Measurement')->with('measurement');
//     }])
//     ->paginate(15);

//     return view('tech.ClientManagement', compact('clients'));
// }


public function clientProjects()
{
    $clients = Client::whereHas('projects', function ($query) {
        $query->where('current_stage', 'Measurement');
    })
    ->with(['projects' => function ($query) {
        $query->where('current_stage', 'Measurement')->with('measurement');
    }]) ->orderBy('created_at', 'desc') // Order by newest
                     ->paginate(5);// ✅ This works because it’s still an Eloquent Builder

    return view('tech.ClientManagement', compact('clients'));

}


}




