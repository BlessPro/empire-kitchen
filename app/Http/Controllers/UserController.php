<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        // Redirect based on the user's role
        $role = Auth::user()->role;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'tech_supervisor' => redirect()->route('tech.dashboard'),
            'designer' => redirect()->route('designer.dashboard'),
            'accountant' => redirect()->route('accountant.dashboard'),
            'sales_accountant' => redirect()->route('sales.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }


//     Route::get('/admin/dashboard', [AdminController::class, 'index'])
//     ->middleware('role:admin')
//     ->name('admin.dashboard');

// Route::get('/tech/dashboard', [TechController::class, 'index'])
//     ->middleware('role:tech_supervisor')
//     ->name('tech.dashboard');

// Route::get('/designer/dashboard', [DesignerController::class, 'index'])
//     ->middleware('role:designer')
//     ->name('designer.dashboard');

// Route::get('/accountant/dashboard', [AccountantController::class, 'index'])
//     ->middleware('role:accountant')
//     ->name('accountant.dashboard');

// Route::get('/sales/dashboard', [SalesController::class, 'index'])
//     ->middleware('role:sales_accountant')
//     ->name('sales.dashboard');


// }



    // public function index()
    // {
    //     $users = User::all();
    //     return view('admin.settings', compact('users'));
    // }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'required|string',
            'role' => 'required|string',
            'password' => 'nullable|string|min:8',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('profile_pic')) {
            if ($user->profile_pic) {
                Storage::disk('public')->delete($user->profile_pic);
            }
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            $user->profile_pic = $path;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully.']);
    }


}
