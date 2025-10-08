<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_phases', function (Blueprint $table) {
            $table->id();

            // links
            $table->foreignId('project_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // core fields
            $table->string('name');                // label shown in FE
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_checked')->default(false);

            // audit (optional but useful)
            $table->foreignId('checked_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->timestamp('checked_at')->nullable();

            // optional notes
            $table->text('note')->nullable();

            $table->timestamps();

            // helpful indexes/constraints
            $table->index(['project_id', 'sort_order']);
            // Prevent duplicate phase names per project (optional; drop if you want duplicates)
            $table->unique(['project_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_phases');
    }
};
