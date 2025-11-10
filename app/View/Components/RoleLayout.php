<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class RoleLayout extends Component
{
    public function render(): View
    {
        $role = Auth::user()->role ?? null;
        if ($role === 'production_officer') {
            return view('layouts.production');
        }
        if ($role === 'installation_officer') {
            return view('layouts.installation');
        }
        // Fallback to admin layout
        return view('layouts.app');
    }
}

