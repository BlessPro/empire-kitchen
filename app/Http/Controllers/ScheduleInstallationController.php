<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Installation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ScheduleInstallationController extends Controller
{
    //
    public function index()
    {
        return view('admin.ScheduleInstallation');
    }
    public function create()
    {
        return view('admin.ScheduleInstallation.create');
    }
    public function edit($id)
    {
        return view('admin.ScheduleInstallation.edit', compact('id'));
    }
    public function show($id)
    {
        return view('admin.ScheduleInstallation.show', compact('id'));
    }
    // public function destroy($id)
    // {
    //     // Logic to delete the project
    //     return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Project deleted successfully.');
    // }
    public function store(Request $request)
    {
        // Logic to store the project
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Project created successfully.');
    }


public function update(Request $request, $id)
{
    $installation = Installation::find($id);

    if (!$installation) {
        return response()->json(['success' => false, 'message' => 'Installation not found'], 404);
    }

    // Validate request data (you can adjust rules as needed)
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'client_id' => 'required|exists:clients,id',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after_or_equal:start_time',
        'notes' => 'nullable|string',




    ]);

    $installation->start_time = $request->input('start_time');
    $installation->end_time = $request->input('end_time');
    $installation->notes = $request->input('notes');
    $installation->project_id = $request->input('project_id');
    $installation->client_id = $request->input('client_id');
    $installation->user_id = Auth::id(); // Assuming you want to set the user ID to the currently authenticated user
    $installation->updated_at = now(); // Update the timestamp
    $installation->save();

    return response()->json(['success' => true, 'message' => 'Installation updated successfully']);
}

    public function schedule(Request $request)
    {
        // Logic to schedule the installation
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Installation scheduled successfully.');
    }
    public function reschedule(Request $request)
    {
        // Logic to reschedule the installation
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Installation rescheduled successfully.');
    }
    public function cancel(Request $request)
    {
        // Logic to cancel the installation
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Installation canceled successfully.');
    }
    public function confirm(Request $request)
    {
        // Logic to confirm the installation
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Installation confirmed successfully.');
    }
    public function complete(Request $request)
    {
        // Logic to mark the installation as complete
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Installation marked as complete successfully.');
    }
    public function viewSchedule(Request $request)
    {
        // Logic to view the installation schedule
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Installation schedule viewed successfully.');
    }
    public function deleteSchedule(Request $request)
    {
        // Logic to delete the installation schedule
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Installation schedule deleted successfully.');
    }
    public function filterSchedule(Request $request)
    {
        // Logic to filter the installation schedule
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Installation schedule filtered successfully.');
    }
    public function exportSchedule(Request $request)
    {
        // Logic to export the installation schedule
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Installation schedule exported successfully.');
    }
    public function importSchedule(Request $request)
    {
        // Logic to import the installation schedule
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Installation schedule imported successfully.');
    }
    public function sendNotification(Request $request)
    {
        // Logic to send notification for the installation
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification sent successfully.');
    }
    public function receiveNotification(Request $request)
    {
        // Logic to receive notification for the installation
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification received successfully.');
    }
    public function markAsRead(Request $request)
    {
        // Logic to mark the notification as read
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification marked as read successfully.');
    }
    public function markAsUnread(Request $request)
    {
        // Logic to mark the notification as unread
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification marked as unread successfully.');
    }
    public function archiveNotification(Request $request)
    {
        // Logic to archive the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification archived successfully.');
    }
    public function unarchiveNotification(Request $request)
    {
        // Logic to unarchive the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification unarchived successfully.');
    }
    public function searchNotification(Request $request)
    {
        // Logic to search for notifications
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Search completed successfully.');
    }
    public function filterNotification(Request $request)
    {
        // Logic to filter notifications
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notifications filtered successfully.');
    }
    public function sortNotification(Request $request)
    {
        // Logic to sort notifications
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notifications sorted successfully.');
    }
    public function paginateNotification(Request $request)
    {
        // Logic to paginate notifications
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notifications paginated successfully.');
    }
    public function downloadNotification(Request $request)
    {
        // Logic to download notifications
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notifications downloaded successfully.');
    }
    public function viewNotification(Request $request)
    {
        // Logic to view the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification viewed successfully.');
    }
    public function deleteNotification(Request $request)
    {
        // Logic to delete the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification deleted successfully.');
    }
    public function exportNotification(Request $request)
    {
        // Logic to export the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification exported successfully.');
    }
    public function importNotification(Request $request)
    {
        // Logic to import the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification imported successfully.');
    }
    public function printNotification(Request $request)
    {
        // Logic to print the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification printed successfully.');
    }
    public function shareNotification(Request $request)
    {
        // Logic to share the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification shared successfully.');
    }
    public function uploadNotification(Request $request)
    {
        // Logic to upload the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification uploaded successfully.');
    }
    public function forwardNotification(Request $request)
    {
        // Logic to forward the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification forwarded successfully.');
    }
    public function replyNotification(Request $request)
    {
        // Logic to reply to the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Reply sent successfully.');
    }
    public function replyAllNotification(Request $request)
    {
        // Logic to reply to all notifications
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Reply sent to all successfully.');
    }
    public function ccNotification(Request $request)
    {
        // Logic to CC the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'CC sent successfully.');
    }
    public function bccNotification(Request $request)
    {
        // Logic to BCC the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'BCC sent successfully.');
    }
    public function markAsSpam(Request $request)
    {
        // Logic to mark the notification as spam
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification marked as spam successfully.');
    }
    public function markAsNotSpam(Request $request)
    {
        // Logic to mark the notification as not spam
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Notification marked as not spam successfully.');
    }
    public function blockSender(Request $request)
    {
        // Logic to block the sender of the notification
        return redirect()->route('admin.ScheduleInstallation.index')->with('success', 'Sender blocked successfully.');
    }

// public function destroy($id)
// {
//     $installation = Installation::find($id);

//     if (!$installation) {
//         return response()->json(['success' => false, 'message' => 'Installation not found'], 404);
//     }

//     $installation->delete();
//     Log::info("Installation deleted: $id");

//     return response()->json(['success' => true, 'message' => 'Installation deleted successfully']);
// }


public function destroy($id)
{
    Installation::findOrFail($id)->delete();
    return response()->json(['success' => true]);
}





}
