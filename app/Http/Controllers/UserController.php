<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;
use App\Models\Employee;

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
            default => redirect()->route('login'),
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


public function update(Request $request, \App\Models\User $user)
{
    $data = $request->validate([
        'name'     => ['required','string','max:150'],
        'role'     => ['required', Rule::in([
            'administrator',
            'admin',
            'tech_supervisor',
            'designer',
            'accountant',
            'sales_account',
            'sales_accountant',
            'production_officer',
            'installation_officer',
        ])],
        'password' => ['nullable','confirmed','min:8'],
    ]);

    $user->role = $data['role'];

    $employee = $user->employee;
    if ($employee) {
        $employee->name = $data['name'];
        $employee->save();
    } else {
        $employee = Employee::create([
            'name'  => $data['name'],
        ]);
        $user->employee_id = $employee->id;
    }

    if (!empty($data['password'])) {
        $user->password = bcrypt($data['password']);
    }

    $user->save();

    return redirect()->route('admin.Settings')->with('success', 'User updated successfully.');
}



    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // public function update(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     $validated = $request->validate([
    //         'employee_id' => 'required|exists:employees,id',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $id,
    //         'phone_number' => 'required|string',
    //         'role' => 'required|string',
    //         'password' => 'nullable|string|min:8',
    //         'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     if ($request->hasFile('profile_pic')) {
    //         if ($user->profile_pic) {
    //             Storage::disk('public')->delete($user->profile_pic);
    //         }
    //         $path = $request->file('profile_pic')->store('profile_pics', 'public');
    //         $user->profile_pic = $path;
    //     }

    //     $user->name = $validated['name'];
    //     $user->email = $validated['email'];
    //     $user->phone_number = $validated['phone_number'];
    //     $user->role = $validated['role'];

    //     if (!empty($validated['password'])) {
    //         $user->password = Hash::make($validated['password']);
    //     }

    //     $user->save();

    //     return response()->json(['message' => 'User updated successfully.']);
    // }

    public function UpdateLoggedUser(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        $emailRules = [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('employees', 'email')->ignore($employee?->id),
        ];

        if (Schema::hasColumn('users', 'email')) {
            $emailRules[] = Rule::unique('users', 'email')->ignore($user->id);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => $emailRules,
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('employees', 'phone')->ignore($employee?->id),
            ],
            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'tech_supervisor',
                    'designer',
                    'sales_accountant',
                    'accountant',
                    'production_officer',
                    'installation_officer',
                ]),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (!$employee) {
            $employee = Employee::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);
            $user->employee_id = $employee->id;
        } else {
            $employee->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);
        }

        if (Schema::hasColumn('users', 'name')) {
            $user->name = $data['name'];
        }
        if (Schema::hasColumn('users', 'email')) {
            $user->email = $data['email'];
        }
        if (Schema::hasColumn('users', 'phone_number')) {
            $user->phone_number = $data['phone'];
        }

        $user->role = $data['role'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Account updated successfully.');
    }

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

