<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;

class BookingsController extends Controller
{
    

public function index(Request $request)
{
    $search        = trim((string) $request->get('search', ''));          // client name
    $bookedStatus  = trim((string) $request->get('booked_status', ''));   // BOOKED | UNBOOKED | ''


    $clients=Client::all();
    $q = Project::query()->with('client');

    // Filter: client name (case-insensitive, partial)
    if ($search !== '') {
        $q->whereHas('client', function ($cq) use ($search) {
            $cq->where('name', 'like', "%{$search}%");
        });
    }

    // Filter: booked_status exact match if provided
    if (in_array($bookedStatus, ['BOOKED', 'UNBOOKED'], true)) {
        $q->where('booked_status', $bookedStatus);
    }

    // BOOKED first, then newest
    $projects = $q->orderByRaw("CASE WHEN booked_status = 'BOOKED' THEN 0 ELSE 1 END")
                  ->orderByDesc('created_at')
                  ->paginate(20)
                  ->withQueryString();

    return view('admin.Bookings', [
        'projects'      => $projects,
        'search'        => $search,
        'booked_status' => $bookedStatus,
        'clients'=> $clients
    ]);
}

}
