<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  use App\Models\Client;
  use App\Models\Project;


class AccountantInvoiceController extends Controller
{
    //


public function index()
{
    $clients = Client::all(); // Fetch all clients
    return view('accountant.Invoice', compact('clients'));
}
public function getProjectsByClient($client_id)
{
    $projects = Project::where('client_id', $client_id)->get();
    return response()->json($projects); // return projects as JSON
}

 public function getClientProjects($clientId)
    {
        $projects = Project::where('client_id', $clientId)->get(['id', 'name']);
        return response()->json($projects);
    }
}
