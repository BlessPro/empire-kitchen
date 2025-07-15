<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user instanceof \App\Models\User) {
                $user->last_seen_at = Carbon::now();
                $user->save();
            }
        }

        return $next($request);
    }
}
