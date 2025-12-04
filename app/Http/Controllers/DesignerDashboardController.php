<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Design;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//new code



class DesignerDashboardController extends Controller
{
    public function index_OLD()
    {
        $today = Carbon::today();
        $designerId = Auth::id();

        // 1. Total assigned projects
        $totalAssigned = Project::where('designer_id', $designerId)->count();

        // 2. Completed projects
        $completed = Project::where('designer_id', $designerId)
                            ->where('status', 'COMPLETED')
                            ->count();

        // 3. Projects due within 10 days
        $dueSoon = Project::where('designer_id', $designerId)
        //commented this so I wont filter based on status
                        //   ->where('status', '!=', 'COMPLETED')
                          ->whereBetween('due_date', [now(), now()->addDays(10)])
                          ->count();

        // 4. Upcoming Deadlines (Design Dates)
        $designs = Design::with(['project.client'])
            ->whereHas('project', function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            })
            ->whereDate('design_date', '>=', $today)
            ->whereDate('design_date', '<=', $today->copy()->addDays(30))
            ->orderBy('design_date', 'asc')
            ->get()
            ->map(function ($design) use ($today) {
                $diff = $today->diffInDays(Carbon::parse($design->design_date));
                $design->urgency = $diff <= 10 ? 'at_risk' : 'on_track';
                return $design;
            });

        // 5. Recent Comments (Not Yet Viewed)

        $recentComments = Comment::whereHas('project', function ($query) use ($designerId) {
            $query->where('designer_id', $designerId);
        })
        ->whereDoesntHave('viewers', function ($query) use ($designerId) {
            $query->where('user_id', $designerId);
        })
        ->latest()
        ->with(['user.employee', 'project'])
        ->take(5)
        ->get();



    $projects = Project::with(['designs' => function ($query) {
        $query->latest();
    }])
    ->where('designer_id', $designerId)->paginate(5);


        return view('designer.dashboard', compact('totalAssigned', 'completed', 'dueSoon', 'designs', 'recentComments','projects'));
    }

public function index(Request $request)
{
    $today = Carbon::today();
    $designerId = Auth::id();

    // existing KPIs …
    $totalAssigned = Project::where('designer_id', $designerId)->count();
    $completed = Project::where('designer_id', $designerId)->where('status', 'COMPLETED')->count();
    $dueSoon = Project::where('designer_id', $designerId)
        ->whereBetween('due_date', [now(), now()->addDays(10)])
        ->count();

    $designs = Design::with(['project.client'])
        ->whereHas('project', fn($q) => $q->where('designer_id', $designerId))
        ->whereBetween('design_date', [$today, $today->copy()->addDays(30)])
        ->orderBy('design_date', 'asc')
        ->get()
        ->map(function ($design) use ($today) {
            $diff = $today->diffInDays(Carbon::parse($design->design_date));
            $design->urgency = $diff <= 10 ? 'at_risk' : 'on_track';
            return $design;
        });

    $recentComments = Comment::whereHas('project', fn($q) => $q->where('designer_id', $designerId))
        ->whereDoesntHave('viewers', fn($q) => $q->where('user_id', $designerId))
        ->latest()
        ->with(['user.employee', 'project'])
        ->take(5)
        ->get();

    // ===== NEW: filters for the history table =====
    $search = trim((string) $request->query('q', ''));             // client name
    $status = strtoupper((string) $request->query('status', ''));  // COMPLETED | IN_REVIEW | ON_GOING
    $allowedStatuses = ['COMPLETED','IN_REVIEW','ON_GOING'];
    if (!in_array($status, $allowedStatuses, true)) {
        $status = null;
    }

    $projects = Project::with([
            'designs' => fn($q) => $q->latest(),  // for latest design_date via ->first()
            'client:id,firstname,lastname',       // needed for name search
        ])
        ->where('designer_id', $designerId)
        // client name search (first/last or "first last")
        ->when($search, function ($q) use ($search) {
            $q->whereHas('client', function ($cq) use ($search) {
                $cq->where('firstname', 'like', "%{$search}%")
                   ->orWhere('lastname', 'like', "%{$search}%")
                   ->orWhere(DB::raw("CONCAT(COALESCE(firstname,''),' ',COALESCE(lastname,''))"), 'like', "%{$search}%");
            });
        })
        // status filter (case-insensitive)
        ->when($status, fn($q) => $q->whereRaw('UPPER(status) = ?', [$status]))
        ->orderByDesc('created_at')
        ->paginate(5)
        ->appends($request->query()); // keep filters on pagination

    // pass the select options
    $statusOptions = $allowedStatuses;

    return view('designer.dashboard', compact(
        'totalAssigned','completed','dueSoon','designs','recentComments','projects','statusOptions'
    ));
}



    public function markAsViewed(Comment $comment)
    {
        $user = Auth::user();

        if (!$comment->viewers->contains($user->id)) {
            $comment->viewers()->attach($user->id);
        }

        return response()->json(['status' => 'success']);
    }
}
