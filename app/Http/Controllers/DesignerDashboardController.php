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
    ->where('designer_id', $designerId)
    ->get();

    // return view('designer.dashboard', compact('projects'));

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



// class DesignerDashboardController extends Controller
// {

    //

// public function index()
// {
//     $designerId = \Illuminate\Support\Facades\Auth::user()->id; // get the authenticated user's id

//     // 1. Total assigned projects
//     $totalAssigned = Project::where('designer_id', $designerId)->count();

//     // 2. Completed projects
//     $completed = Project::where('designer_id', $designerId)
//                         ->where('status', 'completed')
//                         ->count();

//     // 3. Projects due within 10 days
//     $dueSoon = Project::where('designer_id', $designerId)
//                       ->where('status', '!=', 'completed')
//                       ->whereBetween('due_date', [now(), now()->addDays(10)])
//                       ->count();

//     return view('designer.dashboard', compact('totalAssigned', 'completed', 'dueSoon'));
// }




// public function RecentDesignerDashboard()
//     {
//         $user = Auth::user();

//         // UPCOMING DEADLINES (design_date within 30 days)
//         $upcomingProjects = Project::with(['client', 'design'])
//             ->where('tech_supervisor_id', $user->id)
//             ->whereHas('design', function ($query) {
//                 $query->whereDate('design_date', '>=', now())
//                       ->whereDate('design_date', '<=', now()->addDays(30));
//             })
//             ->get()
//             ->map(function ($project) {
//                 $design = $project->design->sortByDesc('design_date')->first();
//                 $deadline = $design?->design_date;
//                 $daysLeft = $deadline ? now()->diffInDays($deadline, false) : null;

//                 return [
//                     'client_name' => $project->client->name,
//                     'project_name' => $project->name,
//                     'design_date' => $deadline,
//                     'status' => ($daysLeft !== null && $daysLeft <= 10) ? 'At Risk' : 'On Track',
//                 ];
//             });

//         // RECENT ACTIVITIES (unviewed comments on assigned projects)
//         $recentComments = Comment::with('project', 'user')
//             ->whereHas('project', function ($query) use ($user) {
//                 $query->where('designer_id', $user->id);
//             })
//             ->whereDoesntHave('viewers', function ($query) use ($user) {
//                 $query->where('user_id', $user->id);
//             })
//             ->latest()
//             ->take(10)
//             ->get()
//             ->map(function ($comment) {
//                 return [
//                     'message' => $comment->user->name . ' added new comment in Project ' . $comment->project->name,
//                     'comment_id' => $comment->id,
//                     'project_id' => $comment->project->id
//                 ];
//             });

//             //the logic to show the project

//     $designerId = \Illuminate\Support\Facades\Auth::user()->id; // get the authenticated user's id

//     // 1. Total assigned projects
//     $totalAssigned = Project::where('designer_id', $designerId)->count();

//     // 2. Completed projects
//     $completed = Project::where('designer_id', $designerId)
//                         ->where('status', 'completed')
//                         ->count();

//     // 3. Projects due within 10 days
//     $dueSoon = Project::where('designer_id', $designerId)
//                       ->where('status', '!=', 'completed')
//                       ->whereBetween('due_date', [now(), now()->addDays(10)])
//                       ->count();


//         return view('designer.dashboard', compact('upcomingProjects', 'recentComments','totalAssigned', 'completed', 'dueSoon'));
//     }

//}
