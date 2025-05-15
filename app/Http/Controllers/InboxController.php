<?php
//cresated by : Doe Bless
//date : 24.04.2025
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Events\NewMessageEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    //

    public function create()
    {
        return view('admin.inbox.create');
    }
    public function edit($id)
    {
        return view('admin.inbox.edit', compact('id'));
    }
    public function show($id)
    {
        return view('admin.inbox.show', compact('id'));
    }
    public function destroy($id)
    {
        // Logic to delete the project
        return redirect()->route('admin.inbox.index')->with('success', 'Project deleted successfully.');
    }
    // public function store(Request $request)
    // {
    //     // Logic to store the project
    //     return redirect()->route('admin.inbox.index')->with('success', 'Project created successfully.');
    // }
    public function update(Request $request, $id)
    {
        // Logic to update the project
        return redirect()->route('admin.inbox.index')->with('success', 'Project updated successfully.');
    }
    public function send(Request $request)
    {
        // Logic to send the message
        return redirect()->route('admin.inbox.index')->with('success', 'Message sent successfully.');
    }
    public function receive(Request $request)
    {
        // Logic to receive the message
        return redirect()->route('admin.inbox.index')->with('success', 'Message received successfully.');
    }
    public function delete(Request $request)
    {
        // Logic to delete the message
        return redirect()->route('admin.inbox.index')->with('success', 'Message deleted successfully.');
    }
    public function markAsRead(Request $request)
    {
        // Logic to mark the message as read
        return redirect()->route('admin.inbox.index')->with('success', 'Message marked as read successfully.');
    }
    public function markAsUnread(Request $request)
    {
        // Logic to mark the message as unread
        return redirect()->route('admin.inbox.index')->with('success', 'Message marked as unread successfully.');
    }
    public function archive(Request $request)
    {
        // Logic to archive the message
        return redirect()->route('admin.inbox.index')->with('success', 'Message archived successfully.');
    }
    public function unarchive(Request $request)
    {
        // Logic to unarchive the message
        return redirect()->route('admin.inbox.index')->with('success', 'Message unarchived successfully.');
    }
    public function search(Request $request)
    {
        // Logic to search for messages
        return redirect()->route('admin.inbox.index')->with('success', 'Search completed successfully.');
    }
    public function filter(Request $request)
    {
        // Logic to filter messages
        return redirect()->route('admin.inbox.index')->with('success', 'Filter applied successfully.');
    }
    public function sort(Request $request)
    {
        // Logic to sort messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages sorted successfully.');
    }
    public function paginate(Request $request)
    {
        // Logic to paginate messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages paginated successfully.');
    }
    public function download(Request $request)
    {
        // Logic to download messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages downloaded successfully.');
    }
    public function upload(Request $request)
    {
        // Logic to upload messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages uploaded successfully.');
    }
    public function print(Request $request)
    {
        // Logic to print messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages printed successfully.');
    }
    public function export(Request $request)
    {
        // Logic to export messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages exported successfully.');
    }
    public function import(Request $request)
    {
        // Logic to import messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages imported successfully.');
    }
    public function share(Request $request)
    {
        // Logic to share messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages shared successfully.');
    }
    public function forward(Request $request)
    {
        // Logic to forward messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages forwarded successfully.');
    }
    public function reply(Request $request)
    {
        // Logic to reply to messages
        return redirect()->route('admin.inbox.index')->with('success', 'Reply sent successfully.');
    }
    public function replyAll(Request $request)
    {
        // Logic to reply to all messages
        return redirect()->route('admin.inbox.index')->with('success', 'Reply sent to all successfully.');
    }
    public function cc(Request $request)
    {
        // Logic to CC messages
        return redirect()->route('admin.inbox.index')->with('success', 'CC sent successfully.');
    }
    public function bcc(Request $request)
    {
        // Logic to BCC messages
        return redirect()->route('admin.inbox.index')->with('success', 'BCC sent successfully.');
    }
    public function block(Request $request)
    {
        // Logic to block messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages blocked successfully.');
    }
    public function unblock(Request $request)
    {
        // Logic to unblock messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages unblocked successfully.');
    }
    public function reportSpam(Request $request)
    {
        // Logic to report spam messages
        return redirect()->route('admin.inbox.index')->with('success', 'Messages reported as spam successfully.');
    }
    public function markAsImportant(Request $request)
    {
        // Logic to mark messages as important
        return redirect()->route('admin.inbox.index')->with('success', 'Messages marked as important successfully.');
    }
    public function markAsNotImportant(Request $request)
    {
        // Logic to mark messages as not important
        return redirect()->route('admin.inbox.index')->with('success', 'Messages marked as not important successfully.');
    }
    public function markAsStarred(Request $request)
    {
        // Logic to mark messages as starred
        return redirect()->route('admin.inbox.index')->with('success', 'Messages marked as starred successfully.');
    }
    public function markAsUnstarred(Request $request)
    {
        // Logic to mark messages as unstarred
        return redirect()->route('admin.inbox.index')->with('success', 'Messages marked as unstarred successfully.');
    }
    public function markAsReadAll(Request $request)
    {
        // Logic to mark all messages as read
        return redirect()->route('admin.inbox.index')->with('success', 'All messages marked as read successfully.');
    }
    public function markAsUnreadAll(Request $request)
    {
        // Logic to mark all messages as unread
        return redirect()->route('admin.inbox.index')->with('success', 'All messages marked as unread successfully.');
    }
    public function markAsArchived(Request $request)
    {
        // Logic to mark messages as archived
        return redirect()->route('admin.inbox.index')->with('success', 'Messages marked as archived successfully.');
    }
    public function markAsUnarchived(Request $request)
    {
        // Logic to mark messages as unarchived
        return redirect()->route('admin.inbox.index')->with('success', 'Messages marked as unarchived successfully.');
    }
    public function markAsDeleted(Request $request)
    {
        // Logic to mark messages as deleted
        return redirect()->route('admin.inbox.index')->with('success', 'Messages marked as deleted successfully.');
    }



// 1. CONTROLLER: app/Http/Controllers/MessageController.php





    // Fetch messages between auth user and another user
    public function index(User $user)
    {
        $messages = Message::where(function ($q) use ($user) {
            $q->where('sender_id', Auth::id())
              ->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        return view('admin.inbox', compact('messages', 'user'));
    }

    // Send a message
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        broadcast(new NewMessageEvent($message))->toOthers();

        return response()->json($message);
    }



}
