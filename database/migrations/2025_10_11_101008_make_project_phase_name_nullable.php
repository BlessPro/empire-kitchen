<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_phases', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Ensure no NULLs remain before enforcing NOT NULL
        DB::table('project_phases')
            ->whereNull('name')
            ->update(['name' => '']);

        Schema::table('project_phases', function (Blueprint $table) {
            // make column NOT NULL again
            $table->string('name')->nullable(false)->change(); // or ->notNullable()->change() on older Laravel
        });
    }
};
