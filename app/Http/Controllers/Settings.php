<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserCredentialsMail;

class Settings extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('admin.settings', compact('users'));

        // return view('admin.Settings');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users',
    //         'phone_number' => 'required|string',
    //         'role' => 'required|string',
    //         'profile_pic' => 'nullable|image|max:2048',
    //     ]);

    //     $profilePicPath = null;

    //     if ($request->hasFile('profile_pic')) {
    //         $profilePicPath = $request->file('profile_pic')->store('users', 'public');
    //     }

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone_number' => $request->phone_number,
    //         'role' => $request->role,
    //         'profile_pic' => $profilePicPath,
    //     ]);

    //     return redirect()->back()->with('success', 'User added successfully!');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users',
    //         'phone_number' => 'required|string',
    //         'role' => 'required|string',
    //         'password' => 'required|string|confirmed|min:6',
    //         'profile_pic' => 'nullable|image|max:2048',
    //     ]);

    //     $profilePicPath = null;

    //     if ($request->hasFile('profile_pic')) {
    //         $profilePicPath = $request->file('profile_pic')->store('users', 'public');
    //     }

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone_number' => $request->phone_number,
    //         'role' => $request->role,
    //         'password' => Hash::make($request->password),
    //         'profile_pic' => $profilePicPath,
    //     ]);

    //     return response()->json(['message' => 'User added successfully!']);
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'phone_number' => 'required|string',
    //         'role' => 'required|string',
    //         'password' => 'required|string|min:8|confirmed',
    //         'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    //     ]);

    //     if ($request->hasFile('profile_pic')) {
    //         $path = $request->file('profile_pic')->store('profile_pics', 'public');
    //         $validated['profile_pic'] = $path;
    //     }

    //     $validated['password'] = Hash::make($validated['password']);

    //     User::create($validated);

    //     return response()->json(['message' => 'User created successfully.']);
    // }


    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required','exists:employees,id','unique:users,employee_id'],
            'role' => ['required', Rule::in([
                'administrator',
                'tech_supervisor',
                'accountant',
                'designer',
                'sales_account',
                'production_officer',
                'installation_officer',
            ])],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        $plainPassword = $data['password'];
        $employee = Employee::find($data['employee_id']);

        $user = User::create([
            'employee_id' => $data['employee_id'],      // <-- FK to employees.id
            'email'       => $employee?->email,
            'role'        => $data['role'],
            'password'    => Hash::make($data['password']),
        ]);

        if ($employee && $employee->email) {
            $user->setRelation('employee', $employee);
            Mail::to($employee->email)->send(new NewUserCredentialsMail($user, $plainPassword));
        }

        // If your form expects JSON (AJAX):
        if ($request->wantsJson()) {
            return response()->json(['message' => 'User created successfully.']);
        }

        // Or classic redirect with flash:
        return back()->with('success','User created successfully.');
    }





    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         // 'staff_id' => ['required','exists:staff_id,','unique:users,staff_id'],
    //         // 'staff_id' => 'required|string|max:50|unique:employees,staff_id',
    //         'staff_id' => 'required|string|max:50|unique:employees,staff_id',

    //         'role' => ['required', Rule::in(['administrator', 'tech_supervisor', 'accountant', 'sales_account', 'production_officer', 'installation_officer'])],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);

    //     User::create([
    //         'staff_id' => $validated['employee_id'],
    //         'role' => $validated['role'],
    //         'password' => Hash::make($validated['password']),
    //     ]);

    //     return response()->json(['message' => 'User created successfully.']);
    // }

    public function create()
    {
        return view('admin.Settings.create');
    }
    public function edit($id)
    {
        return view('admin.Settings.edit', compact('id'));
    }
    public function show($id)
    {
        return view('admin.Settings.show', compact('id'));
    }
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->back()->with('success', 'User successfully! deleted ');
    }

    public function changePassword(Request $request)
    {
        // Logic to change the password
        return redirect()->route('admin.Settings.index')->with('success', 'Password changed successfully.');
    }
    public function updateProfile(Request $request)
    {
        // Logic to update the profile
        return redirect()->route('admin.Settings.index')->with('success', 'Profile updated successfully.');
    }
    public function updatePreferences(Request $request)
    {
        // Logic to update the preferences
        return redirect()->route('admin.Settings.index')->with('success', 'Preferences updated successfully.');
    }
    public function updateNotifications(Request $request)
    {
        // Logic to update the notifications
        return redirect()->route('admin.Settings.index')->with('success', 'Notifications updated successfully.');
    }
    public function updatePrivacy(Request $request)
    {
        // Logic to update the privacy settings
        return redirect()->route('admin.Settings.index')->with('success', 'Privacy settings updated successfully.');
    }
    public function updateSecurity(Request $request)
    {
        // Logic to update the security settings
        return redirect()->route('admin.Settings.index')->with('success', 'Security settings updated successfully.');
    }
    public function updateBilling(Request $request)
    {
        // Logic to update the billing settings
        return redirect()->route('admin.Settings.index')->with('success', 'Billing settings updated successfully.');
    }
    public function updateSubscription(Request $request)
    {
        // Logic to update the subscription settings
        return redirect()->route('admin.Settings.index')->with('success', 'Subscription settings updated successfully.');
    }
    public function updateNotificationsSettings(Request $request)
    {
        // Logic to update the notification settings
        return redirect()->route('admin.Settings.index')->with('success', 'Notification settings updated successfully.');
    }
    public function updateLanguage(Request $request)
    {
        // Logic to update the language settings
        return redirect()->route('admin.Settings.index')->with('success', 'Language settings updated successfully.');
    }
    public function updateTimezone(Request $request)
    {
        // Logic to update the timezone settings
        return redirect()->route('admin.Settings.index')->with('success', 'Timezone settings updated successfully.');
    }
    public function updateTheme(Request $request)
    {
        // Logic to update the theme settings
        return redirect()->route('admin.Settings.index')->with('success', 'Theme settings updated successfully.');
    }
    public function updateAccessibility(Request $request)
    {
        // Logic to update the accessibility settings
        return redirect()->route('admin.Settings.index')->with('success', 'Accessibility settings updated successfully.');
    }
    public function updateBackup(Request $request)
    {
        // Logic to update the backup settings
        return redirect()->route('admin.Settings.index')->with('success', 'Backup settings updated successfully.');
    }
    public function updateIntegration(Request $request)
    {
        // Logic to update the integration settings
        return redirect()->route('admin.Settings.index')->with('success', 'Integration settings updated successfully.');
    }
    public function updateApiSettings(Request $request)
    {
        // Logic to update the API settings
        return redirect()->route('admin.Settings.index')->with('success', 'API settings updated successfully.');
    }
    public function updateWebhookSettings(Request $request)
    {
        // Logic to update the webhook settings
        return redirect()->route('admin.Settings.index')->with('success', 'Webhook settings updated successfully.');
    }
    public function updateCustomSettings(Request $request)
    {
        // Logic to update the custom settings
        return redirect()->route('admin.Settings.index')->with('success', 'Custom settings updated successfully.');
    }
    public function updateCustomFields(Request $request)
    {
        // Logic to update the custom fields
        return redirect()->route('admin.Settings.index')->with('success', 'Custom fields updated successfully.');
    }
    public function updateCustomTemplates(Request $request)
    {
        // Logic to update the custom templates
        return redirect()->route('admin.Settings.index')->with('success', 'Custom templates updated successfully.');
    }
    public function updateCustomReports(Request $request)
    {
        // Logic to update the custom reports
        return redirect()->route('admin.Settings.index')->with('success', 'Custom reports updated successfully.');
    }
    public function updateCustomAnalytics(Request $request)
    {
        // Logic to update the custom analytics
        return redirect()->route('admin.Settings.index')->with('success', 'Custom analytics updated successfully.');
    }
    public function updateCustomDashboards(Request $request)
    {
        // Logic to update the custom dashboards
        return redirect()->route('admin.Settings.index')->with('success', 'Custom dashboards updated successfully.');
    }
    // public function showUsers()
    // {
    //     $users = User::orderBy('created_at', 'desc')->paginate(10);
    //     return view('admin.settings', compact('users'));
    // }
    // public function showUsers()
    // {
    //     $users = Employee::select('id', 'name', 'email', 'role', 'profile_pic', 'last_seen_at', 'created_at')
    //         ->orderByDesc('created_at')
    //         ->paginate(10);

    //     return view('admin.settings', compact('users'));
    // }

    // public function settings()
    // {
    //     $employees = Employee::select('id', 'name')->orderBy('name')->get();

    //     // also fetch your current users list like before if needed
    //     return view('admin.settings', compact('employees'));
    // }
    public function showUsers()
    {
        $employees = Employee::select('id', 'name', 'staff_id')
            ->orderBy('name')
            ->get();

        $users = User::with(['employee' => function ($query) {
                $query->select('id', 'name', 'email', 'phone', 'avatar_path', 'staff_id');
            }])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.settings', compact('users', 'employees'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            $validated['profile_pic'] = $path;
        }

        if ($validated['password'] ?? false) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // Keep current password
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Account updated successfully.');
    }

    public function UpdateLoggedUser(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            $validated['profile_pic'] = $path;
        }

        if ($validated['password'] ?? false) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // Keep current password
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Account updated successfully.');
    }
}
