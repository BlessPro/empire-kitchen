<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('main');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(route('dashboard', absolute: false));
    // }

    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    return redirect()->intended($this->redirectBasedOnRole());
}

private function redirectBasedOnRole(): string
{
    $role = Auth::user()->role;

    return match ($role) {
        'administrator' => route('admin.dashboard'),
        'tech_supervisor' => route('tech.dashboard'),
        'designer' => route('designer.dashboard'),
        'accountant' => route('accountant.dashboard'),
        'sales_account' => route('sales.dashboard'),

        // Add other roles as needed
        // If no specific route is defined for the role, redirect to a default route
        // 'default' => '/dashboard', // Default route for roles not explicitly handled
        // You can also set a different default route if needed
        'guest' => '/login', // Redirect guests to the login page
        // 'user' => '/dashboard', // Redirect regular users to the dashboard
        default => '/login',


    };
}


    // /**
    //  * Destroy an authenticated session.
    //  */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     Auth::guard('web')->logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }

public function destroy(Request $request): RedirectResponse
{
    if (Auth::check()) {
        $user = Auth::user();
        if ($user instanceof \App\Models\User) {
            $user->last_seen_at = now();
            $user->save();
        }
    }

    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}

}
