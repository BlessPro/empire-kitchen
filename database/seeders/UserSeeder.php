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


 /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@example.com',
            'name' => 'Admin User',
            'phone_number' => '0550000001',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'profile_pic' => 'profile_photos/admin-profile.jpg',
        ]);

        User::updateOrCreate([
            'email' => 'tech@example.com',
            'name' => 'Tech Supervisor',
            'phone_number' => '0550000002',
            'password' => Hash::make('password123'),
            'role' => 'tech_supervisor',
            'profile_pic' => 'profile_photos/default_tech_pic.jpg',
        ]);

        User::updateOrCreate([
            'email' => 'designer@example.com',
            'name' => 'Designer',
            'phone_number' => '0550000003',
            'password' => Hash::make('password123'),
            'role' => 'designer',
            'profile_pic' => 'profile_photos/default_designer_pic.jpg',
        ]);

        User::updateOrCreate([
            'email' => 'accountant@example.com',
            'name' => 'Accountant',
            'phone_number' => '0550000004',
            'password' => Hash::make('password123'),
            'role' => 'accountant',
            'profile_pic' => 'profile_photos/default_accountant_pic.jpg',
        ]);

        User::updateOrCreate([
            'email' => 'sales@example.com',
            'name' => 'Sales Accountant',
            'phone_number' => '0550000005',
            'password' => Hash::make('password'),
            'role' => 'sales_accountant',
            'profile_pic' => 'profile_photos/default_sales_accountant_pic.jpg',
        ]);

        User::updateOrCreate([
            'email' => 'superadmin@example.com',
            'name' => 'Super Admin',
            'phone_number' => '0550000006',
            'password' => Hash::make('superadminpassword'),
            'role' => 'superadmin',
            'profile_pic' => 'profile_photos/admin-profile.jpg',
        ]);

        User::updateOrCreate([
            'email' => 'acesquare52@gmail.com',
            'name' => 'Bless',
            'phone_number' => '0550000007',
            'password' => Hash::make('Bless@2024'),
            'role' => 'admin',
            'profile_pic' => 'profile_photos/admin-profile.jpg',
        ]);
    }
}

