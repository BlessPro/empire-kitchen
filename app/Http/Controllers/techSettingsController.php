<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class techSettingsController extends Controller
{
    /**
     * Handle the incoming request.
     */
       public function index(){
    $projects = Project::paginate(15); // fetch paginated projects

    return view('tech/settings', compact('projects'));
}





 public function update(Request $request)
{

    $user = User::findOrFail(Auth::id());

    $validated = $request->validate([
      
        'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('profile_pic')) {
        $path = $request->file('profile_pic')->store('profile_pics', 'public');
        $validated['profile_pic'] = $path;
    }


    $user->update($validated);

    return redirect()->back()->with('success', 'Account updated successfully.');
}
}
