<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Example 1: Ensure at least one admin account exists
        $employee = Employee::first(); // just take the first employee

        if ($employee && ! User::where('employee_id', $employee->id)->exists()) {
            User::create([
                'employee_id'   => $employee->id,
                'password'      => Hash::make('password123'), // change in production!
                'role'          => 'administrator',
                'remember_token'=> Str::random(10),
                'last_seen_at'  => now(),
            ]);
        }

        // Example 2: Seed a few sample users from random employees
        $roles = [
            'administrator',
            'tech_supervisor',
            'accountant',
            'sales_account',
            'production_officer',
            'installation_officer',
        ];

        $employees = Employee::inRandomOrder()->take(5)->get();

        foreach ($employees as $index => $emp) {
            if (! User::where('employee_id', $emp->id)->exists()) {
                User::create([
                    'employee_id'   => $emp->id,
                    'password'      => Hash::make('secret123'), // demo password
                    'role'          => $roles[$index % count($roles)],
                    'remember_token'=> Str::random(10),
                    'last_seen_at'  => now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }
}
