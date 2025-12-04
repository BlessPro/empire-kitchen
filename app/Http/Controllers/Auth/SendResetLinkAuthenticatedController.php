<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\AccountPasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class SendResetLinkAuthenticatedController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $email = $user?->email ?? $user?->employee?->email;

        if (!$user || empty($email)) {
            $error = ['email' => 'We could not find an email for this account.'];
            return $request->wantsJson()
                ? response()->json(['ok' => false, 'errors' => $error], 422)
                : back()->withErrors($error);
        }

        try {
            $token = Password::broker()->createToken($user);
            $user->notify(new AccountPasswordReset($token));
        } catch (\Throwable $e) {
            $message = 'Unable to send reset link. Please try again.';
            return $request->wantsJson()
                ? response()->json(['ok' => false, 'message' => $message], 500)
                : back()->withErrors(['email' => $message]);
        }

        $success = __('passwords.sent');
        return $request->wantsJson()
            ? response()->json(['ok' => true, 'message' => $success])
            : back()->with('status', $success);
    }
}
