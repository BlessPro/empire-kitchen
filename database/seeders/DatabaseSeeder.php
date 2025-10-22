<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
            EmployeeSeeder::class, // must run first
            UserSeeder::class, // depends on employees
            ClientSeeder::class,
            ProjectSeeder::class,
            AccessorySeeder::class,
            BudgetCategorySeeder::class,
            BudgetExampleSeeder::class,
            PhaseTemplatesSeeder::class,
            InboxDemoSeeder::class,
        ]);

$this->call(\Database\Seeders\InboxDemoSeeder::class);


    }




}
