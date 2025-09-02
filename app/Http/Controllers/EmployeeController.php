<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // Display a listing of employees
    public function index() {
        return view('admin.Employee');
    }

    public function addemployee() {
        return view('admin.addemployee');
    }

// public function create()
// {
//     // return the Blade you shared (whatever path you saved it as)
//     return view('admin.addemployee'); // e.g. resources/views/employees/addemployee.blade.php
// }


    public function store(Request $request)
    {
        $data = $request->validate([
            // identifiers
            'staff_id'          => ['nullable','string','max:50','unique:employees,staff_id'],

            // core profile
            'name'              => ['required','string','max:255'],
            'designation'       => ['nullable','string','max:100'],
            'commencement_date' => ['nullable','date'],
            'phone'             => ['nullable','string','max:50'],
            'email'             => ['nullable','email','max:255','unique:employees,email'],

            // personal
            'nationality'       => ['nullable','string','max:100'],
            'dob'               => ['nullable','date'],
            'hometown'          => ['nullable','string','max:255'],
            'language'          => ['nullable','string','max:100'],

            // address
            'address'           => ['nullable','string','max:255'],
            'gps'               => ['nullable','string','max:100'],

            // next of kin
            'next_of_kin'       => ['nullable','string','max:255'],
            'relation'          => ['nullable','string','max:100'],
            'nok_phone'         => ['nullable','string','max:50'],

            // bank
            'bank'              => ['nullable','string','max:100'],
            'branch'            => ['nullable','string','max:100'],
            'account_number'    => ['nullable','string','max:100'],

            // media
            'avatar'            => ['nullable','image','max:4096'], // 4MB
        ]);

        // Auto-generate staff_id if not provided
        if (empty($data['staff_id'])) {
            // Simple padded ID e.g. EMP-0005 (avoid race: acceptable for low volume; for high, lock/uuid)
            $next = (Employee::max('id') ?? 0) + 1;
            $data['staff_id'] = 'EMP-'.str_pad((string)$next, 4, '0', STR_PAD_LEFT);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar_path'] = $path;
        }

        Employee::create($data);

        // return back()->with('success', 'Employee saved successfully.');

          // IMPORTANT: redirect to the GET route, not to employees.store
    return redirect()->route('admin.addemployee')
        ->with('success','Employee saved successfully.');
    }
}
