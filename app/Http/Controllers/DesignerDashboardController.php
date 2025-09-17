<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Design;
use Illuminate\Support\Facades\Auth;

//new code



class DesignerDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $designerId = Auth::id();

        // 1. Total assigned projects
        $totalAssigned = Project::where('designer_id', $designerId)->count();

        // 2. Completed projects
        $completed = Project::where('designer_id', $designerId)
                            ->where('status', 'completed')
                            ->count();

        // 3. Projects due within 10 days
        $dueSoon = Project::where('designer_id', $designerId)
                          ->where('status', '!=', 'completed')
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
        ->with(['user', 'project'])
        ->take(5)
        ->get();



    $projects = Project::with(['designs' => function ($query) {
        $query->latest();
    }])
    ->where('designer_id', $designerId)->paginate(5);


        return view('designer.dashboard', compact('totalAssigned', 'completed', 'dueSoon', 'designs', 'recentComments','projects'));
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
