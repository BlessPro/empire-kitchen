<?php
//created by : Doe Bless
//date : 24.04.2025
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//created by : Doe Bless
//date : 19.04.2025

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class salesInboxController extends Controller
{
    public function index(Request $request, $userId = null)
    {
        $users = User::where('id', '!=', Auth::id())->get();

        $messages = [];
        if ($userId) {
            $messages = Inbox::where(function ($query) use ($userId) {
                $query->where('sender_id', Auth::id())->where('receiver_id', $userId);
            })->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $userId)->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();
        }                   

        return view('sales.Inbox', compact('users', 'messages', 'userId'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = Inbox::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json(['message' => $message]);
    }

    public function fetchMessages($userId)
    {
        $messages = Inbox::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}
