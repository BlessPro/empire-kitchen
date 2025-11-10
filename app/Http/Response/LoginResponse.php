<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract    
{
    public function toResponse($request)
    {
        $role = Auth::user()->role;

        return match ($role) {
            'admin', 'administrator' => redirect()->intended('/admin/dashboard'),
            'tech_supervisor' => redirect()->intended('/tech/dashboard'),
            'designer' => redirect()->intended('/designer/dashboard'),
            'accountant' => redirect()->intended('/accountant/dashboard'),
            'sales_account' => redirect()->intended('/sales/dashboard'),
            'production_officer' => redirect()->intended(route('production.projects')),
            'installation_officer' => redirect()->intended(route('installation.projects')),
            default => redirect('/dashboard'),
        };
    }
}
