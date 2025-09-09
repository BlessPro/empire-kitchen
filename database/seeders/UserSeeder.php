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
        $roles = [
            'administrator',
            'tech_supervisor',
            'accountant',
            'sales_account',
            'production_officer',
            'installation_officer',
        ];

        // Ensure at least one admin
        $firstEmp = Employee::first();
        if ($firstEmp && !User::where('employee_id', $firstEmp->id)->exists()) {
            User::create([
                'employee_id'    => $firstEmp->id,
                'password'       => Hash::make('password123'), // change in prod
                'role'           => 'administrator',
                'remember_token' => Str::random(10),
                'last_seen_at'   => now(),
            ]);
        }

        // Create users for other employees without accounts (up to N)
        $index = 0;
        Employee::whereDoesntHave('user')
            ->inRandomOrder()
            ->take(10)
            ->get()
            ->each(function ($emp) use (&$index, $roles) {
                User::create([
                    'employee_id'    => $emp->id,
                    'password'       => Hash::make('secret123'), // demo password
                    'role'           => $roles[$index % count($roles)],
                    'remember_token' => Str::random(10),
                    'last_seen_at'   => now()->subDays(rand(0, 20)),
                ]);
                $index++;
            });
    }
}
