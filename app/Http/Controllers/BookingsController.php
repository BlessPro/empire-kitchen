<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Activity;

class BookingsController extends Controller
{


    public function index(Request $request)
    {


        //   $view = $request->user()->hasRole('accountant')
        //     ? 'accountant.Bookings'
        //     : 'admin.Bookings';

        $search        = trim((string) $request->get('search', ''));          // client name
        $bookedStatus  = trim((string) $request->get('booked_status', ''));   // BOOKED | UNBOOKED | ''


        $clients = Client::all();
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
            'clients' => $clients
        ]);
    }



    public function index2(Request $request)
    {
        $search       = trim((string) $request->get('search', ''));
        $bookedStatus = trim((string) $request->get('booked_status', ''));

        $clients = Client::all();

        $q = Project::query()->with('client');

        if ($search !== '') {
            $like = '%' . str_replace(' ', '%', $search) . '%';
            $q->whereHas('client', function ($cq) use ($like) {
                $cq->where('firstname', 'like', $like)
                    ->orWhere('lastname',  'like', $like)
                    ->orWhereRaw("CONCAT(COALESCE(firstname,''),' ',COALESCE(lastname,'')) LIKE ?", [$like])
                    ->orWhere('name', 'like', $like); // in case some clients have a single 'name'
            });
        }

        if (in_array($bookedStatus, ['BOOKED', 'UNBOOKED'], true)) {
            $q->where('booked_status', $bookedStatus);
        }

        $projects = $q->orderByRaw("CASE WHEN booked_status = 'BOOKED' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        // compute view prefix once so Blade can use it for the PATCH route
        $viewPrefix = str_starts_with($request->route()->getName(), 'accountant.')
            ? 'accountant' : 'admin';

        return view('accountant.Bookings', [
            'projects'      => $projects,
            'search'        => $search,
            'booked_status' => $bookedStatus,
            'clients'       => $clients,
            'viewPrefix'    => $viewPrefix,
        ]);
    }


    // app/Http/Controllers/BookingsController.php
    public function markBooked(Request $request, \App\Models\Project $project)
    {
        // (Optional) gate/policy/role checks here if you want extra safety

        // Only update if not already booked
        if ($project->booked_status !== 'BOOKED') {
            $project->update(['booked_status' => 'BOOKED']);
            Activity::log([
                'project_id' => $project->id,
                'type'       => 'booking.booked',
                'message'    => "{$project->name} booked status is now BOOKED",
                'meta'       => ['status' => 'BOOKED'],
            ]);
        }

        return back()->with('success', 'Project set as BOOKED.');
    }


    public function markUnbooked(Request $request, \App\Models\Project $project)
    {
        if ($project->booked_status !== 'UNBOOKED') {
            $project->update(['booked_status' => 'UNBOOKED']);
            Activity::log([
                'project_id' => $project->id,
                'type'       => 'booking.unbooked',
                'message'    => "{$project->name} booked status is now UNBOOKED",
                'meta'       => ['status' => 'UNBOOKED'],
            ]);
        }
        return back()->with('success', 'Project set as UNBOOKED.');
    }

    public function booked(Request $request)
    {
        // load only existing client columns to avoid SQL errors (no "name" column)
        $projects = Project::with('client:id,firstname,lastname')
            ->where('booked_status', 'BOOKED')
            ->orderByDesc('id')
            ->get(['id', 'name', 'client_id']);

        return response()->json(
            $projects->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'client' => [
                    'id' => $p->client_id,
                    'name' => $p->client?->name ?? trim(($p->client?->firstname . ' ' . $p->client?->lastname)),
                ],
            ])
        );
    }

    public function client(Project $project)
    {
        $c = $project->client;
        return response()->json([
            'id' => $c?->id,
            'name' => $c?->name ?? trim(($c?->firstname . ' ' . $c?->lastname)),
        ]);
    }

    public function override(Request $request, Project $project)
    {
        $data = $request->validate([
            'password' => ['required', 'string']
        ]);

        $user = $request->user();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid password.'], 422);
        }

        $project->update(['booked_status' => 'BOOKED']);

        Activity::log([
            'project_id' => $project->id,
            'type'       => 'booking.override',
            'message'    => "{$project->name} booked status is now BOOKED (override)",
            'meta'       => ['status' => 'BOOKED'],
        ]);

        return response()->json(['ok' => true]);
    }
}
