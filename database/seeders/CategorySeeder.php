<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Utilities',
            'Transport',
            'Supplies',
            'Salaries',
            'Rent',
            'Maintenance',
            'Software',
            'Other',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}

