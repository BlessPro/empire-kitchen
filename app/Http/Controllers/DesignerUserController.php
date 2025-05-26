<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DesignerUserController extends Controller
{
    //
       public function updateProfilePic(Request $request)
{
    $user = User::findOrFail(Auth::id());

    $request->validate([
        'profile_pic' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('profile_pic')) {
        $path = $request->file('profile_pic')->store('profile_pics', 'public');
        $user->profile_pic = $path;
        $user->save();
    }

    return redirect()->back()->with('success', 'Profile picture updated successfully.');
}

}
