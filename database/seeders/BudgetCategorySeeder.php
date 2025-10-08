<?php

// database/seeders/BudgetCategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BudgetCategory;

class BudgetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['name' => 'Measurement',  'description' => 'Measurement activities', 'is_default' => true],
            ['name' => 'Design',       'description' => 'Design and drawings',    'is_default' => true],
            ['name' => 'Installation', 'description' => 'Installation tasks',     'is_default' => true],
            // You can add more defaults here; Production can be user-added later
        ];

        foreach ($defaults as $d) {
            BudgetCategory::firstOrCreate(['name' => $d['name']], $d);
        }
    }
}

