<?php

// 1. MIGRATION: Create expenses and categories tables

// Run: php artisan make:migration create_categories_table
// Run: php artisan make:migration create_expenses_table

// database/migrations/xxxx_xx_xx_create_categories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

// database/migrations/xxxx_xx_xx_create_expenses_table.php


// 2. MODEL: Category
// Run: php artisan make:model Category


// 3. MODEL: Expense
// Run: php artisan make:model Expense


// 4. OPTIONAL: Add relation to User model (App\Models\User.php)


// 5. OPTIONAL SEEDER: Categories
// Run: php artisan make:seeder CategorySeeder


// Register the seeder in DatabaseSeeder.php and run:
// php artisan db:seed --class=CategorySeeder
