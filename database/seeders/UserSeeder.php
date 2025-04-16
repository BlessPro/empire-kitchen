<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


public function run(): void
{
    User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    User::create([
        'name' => 'Tech Supervisor',
        'email' => 'tech@example.com',
        'password' => Hash::make('password'),
        'role' => 'tech_supervisor',
    ]);

    User::create([
        'name' => 'Designer',
        'email' => 'designer@example.com',
        'password' => Hash::make('password'),
        'role' => 'designer',
    ]);

    User::create([
        'name' => 'Accountant',
        'email' => 'accountant@example.com',
        'password' => Hash::make('password'),
        'role' => 'accountant',
    ]);

    User::create([
        'name' => 'Sales Accountant',
        'email' => 'sales@example.com',
        'password' => Hash::make('password'),
        'role' => 'sales_accountant',
    ]);

}

}
