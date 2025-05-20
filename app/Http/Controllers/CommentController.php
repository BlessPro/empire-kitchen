<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class CommentController extends Controller
{
    //
    public function store(Request $request, Project $project)
{
    $request->validate([
        'comment' => 'required|string|max:1000'
    ]);

    $project->comments()->create([
        'user_id' => \Illuminate\Support\Facades\Auth::user()->id,  // who is posting
        'comment' => $request->comment,
    ]);

    return redirect()->back()->with('success', 'Comment added!');
}



}
