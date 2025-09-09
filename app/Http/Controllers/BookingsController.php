<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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




    public function booked(Request $request)
    {
        $projects = Project::with('client:id,firstname,lastname,name')
            ->where('booked_status', 'BOOKED')
            ->orderByDesc('id')
            ->get(['id','name','client_id']);

        return response()->json(
            $projects->map(fn($p)=>[
                'id' => $p->id,
                'name' => $p->name,
                'client' => [
                    'id' => $p->client_id,
                    'name' => $p->client?->name ?? trim(($p->client?->firstname.' '.$p->client?->lastname)),
                ],
            ])
        );
    }

    public function client(Project $project)
    {
        $c = $project->client;
        return response()->json([
            'id' => $c?->id,
            'name' => $c?->name ?? trim(($c?->firstname.' '.$c?->lastname)),
        ]);
    }




// app/Http/Controllers/BookingOverrideController.php

    public function override(Request $request, Project $project)
    {
        $data = $request->validate([
            'password' => ['required','string']
        ]);

        $user = $request->user();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid password.'], 422);
        }

        $project->update(['booked_status' => 'BOOKED']);

        return response()->json(['ok' => true]);
    }




}
