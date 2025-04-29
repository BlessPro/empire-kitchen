<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client; // Import the Client model
use Barryvdh\DomPDF\Facade\Pdf; // Import the Pdf facade

class ClientManagementController extends Controller
{
    //
    // public function index()
    // {
    //     return view('admin.ClientManagement');
    // }

    // public function index()
    // {
    //     $Clients = Client::paginate(15); // fetch paginated projects
    //     // dd($projects);

    //     return view('admin/ClientManagement', compact('Clients'));
    // }

    public function index()
    {
        $clients = Client::withCount('projects')->paginate(5); // Fetch clients with projects count
        return view('admin.ClientManagement', compact('clients'));
    }
//fofr storing clients

// public function store(Request $request)
// {
//     $client = Client::create($request->only([


// 'title', 'firstname', 'lastname', 'othernames', 'phone_number', 'location'



//     ]));

//     return response()->json(['message' => 'Client successfully created']);
// }

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:10',
        'firstname' => 'required|string|max:50',
        'lastname' => 'required|string|max:50',
        'othernames' => 'nullable|string|max:100',
        'phone_number' => 'required|string|max:20',
        'location' => 'required|string|max:100',
    ]);

    $client = Client::create($request->only([
        'title', 'firstname', 'lastname', 'othernames', 'phone_number', 'location'
    ]));

    return response()->json(['message' => 'Client successfully created']);
}


//     public function exportPdf()
// {

//     $pdf = Pdf::loadView('admin.exports.clients', compact('clients')); // Create a new blade view for the PDF

//     return $pdf->download('clients_list.pdf'); // Or ->stream() to view directly
// }
}
