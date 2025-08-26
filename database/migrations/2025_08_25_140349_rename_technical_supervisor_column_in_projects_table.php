<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Rename column
            $table->renameColumn('technical_supervisor_id', 'tech_supervisor_id');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Rollback to old name if needed
            $table->renameColumn('tech_supervisor_id', 'technical_supervisor_id');
        });
    }
};
