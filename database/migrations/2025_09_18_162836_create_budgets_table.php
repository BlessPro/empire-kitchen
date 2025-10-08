<?php
// database/migrations/2025_01_01_000100_create_budgets_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->decimal('main_amount', 14, 2);    // Main allocated budget for the project
            $table->string('currency', 3)->default('GHS');
            $table->date('effective_date')->nullable();
            $table->timestamps();

            // If you want exactly one budget per project, uncomment:
            // $table->unique('project_id');
        });
    }
    public function down(): void {
        Schema::dropIfExists('budgets');
    }
};
