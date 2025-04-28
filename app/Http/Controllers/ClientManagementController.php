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
    public function exportPdf()
{

    $pdf = Pdf::loadView('admin.exports.clients', compact('clients')); // Create a new blade view for the PDF

    return $pdf->download('clients_list.pdf'); // Or ->stream() to view directly
}
}
