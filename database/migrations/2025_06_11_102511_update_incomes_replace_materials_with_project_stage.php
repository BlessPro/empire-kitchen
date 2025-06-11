<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('material');
            $table->string('project_stage')->nullable(); // or use enum if needed
        });
    }

    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('project_stage');
            $table->string('material')->nullable(); // restore original if rollback
        });
    }
};

