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
            'admin' => redirect()->intended('/admin/dashboard'),
            'tech_supervisor' => redirect()->intended('/tech/dashboard'),
            'designer' => redirect()->intended('/designer/dashboard'),
            'accountant' => redirect()->intended('/accountant/dashboard'),
            'sales_account' => redirect()->intended('/sales/dashboard'),
            default => redirect('/dashboard'),
        };
    }
}
