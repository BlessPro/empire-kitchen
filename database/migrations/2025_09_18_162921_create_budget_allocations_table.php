<?php
// database/migrations/2025_01_01_000200_create_budget_allocations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('budget_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained()->cascadeOnDelete();
            $table->foreignId('budget_category_id')->constrained('budget_categories')->cascadeOnDelete();
            $table->decimal('amount', 14, 2)->default(0);
            $table->timestamps();

            $table->unique(['budget_id', 'budget_category_id']); // one row per category in a budget
        });
    }
    public function down(): void {
        Schema::dropIfExists('budget_allocations');
    }
};
