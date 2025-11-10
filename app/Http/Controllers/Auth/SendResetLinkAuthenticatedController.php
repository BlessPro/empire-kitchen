<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\AccountPasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class SendResetLinkAuthenticatedController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();
        $email = $user?->email ?? $user?->employee?->email;

        if (!$user || empty($email)) {
            return back()->withErrors([
                'email' => 'We could not find an email for this account.',
            ]);
        }

        $token = Password::broker()->createToken($user);

        $user->notify(new AccountPasswordReset($token));

        return back()->with('status', __('passwords.sent'));
    }
}
