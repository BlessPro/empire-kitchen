<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('phase_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // e.g., "Work Order"
            $table->unsignedSmallInteger('default_sort_order')->default(0);
            $table->string('product_type')->nullable();   // e.g., "Kitchen" (if you ever vary by type)
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['name', 'product_type']);     // avoid duplicates per type
            $table->index(['product_type', 'default_sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phase_templates');
    }
};
