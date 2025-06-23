<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\FollowUp;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class salesClientController extends Controller
{
    //
// SalesClientController.php

public function index()
{
    $clients = Client::latest()->get();
    return view('sales.ClientManagement', compact('clients'));
}

public function filter(Request $request)
{
    $filter = $request->query('filter');
    $clients = Client::query();

    switch ($filter) {
        case 'new':
            $clients->where('created_at', '>=', now()->subDays(30));
            // $clients->where('created_at', '>=', now()->subYear());

            break;
        case 'with-projects':
            $clients->whereHas('projects');
            break;
        // Add more cases if needed
    }

    $clients = $clients->latest()->get();

    return view('sales.partials.clienttable', compact('clients'))->render();
}


}
