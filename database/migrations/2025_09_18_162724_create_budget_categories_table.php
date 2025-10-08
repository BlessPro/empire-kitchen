<?php

// database/migrations/2025_01_01_000000_create_budget_categories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('budget_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();         // Measurement, Design, Installation, Production, ...
            $table->text('description')->nullable();
            $table->boolean('is_default')->default(true); // handy if you want to hide custom ones later
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('budget_categories');
    }
};

