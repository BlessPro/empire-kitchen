<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Users;

class Settings extends Controller
{
    //
    public function index()
    {
        return view('admin.Settings');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'role' => 'required|string',
            // 'admin_name' => 'required|string|max:255',
            
        ]);


    
        User::create([
            'name' => $request->name,
            'due_date' => $request->due_date,
            'cost' => $request->cost,
            'location' => $request->location,
            'description' => $request->description,
            'start_date' => now(), // or any other default value
            // 'admin_name' => $request->admin_id,
            'client_id' => $request->client_id,
            'tech_supervisor_id' => $request->tech_supervisor_id,
            'current_stage' => 'measurement', // if default stage is needed
        ]);
    
        return response()->json(['message' => 'Project created']);
    }
    
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
    // public function store(Request $request)
    // {
    //     // Logic to store the project
    //     return redirect()->route('admin.Settings.index')->with('success', 'Project created successfully.');
    // }
    public function update(Request $request, $id)
    {
        // Logic to update the project
        return redirect()->route('admin.Settings.index')->with('success', 'Project updated successfully.');
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
    public function showUsers()
    {     
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.settings', compact('users'));
    }
    
}
