<?php
// database/migrations/2025_09_23_000000_create_cost_entries_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cost_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_allocation_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 14, 2);
            $table->date('spent_at')->nullable(); // set to today in app if null
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['budget_allocation_id', 'spent_at']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('cost_entries');
    }
};
