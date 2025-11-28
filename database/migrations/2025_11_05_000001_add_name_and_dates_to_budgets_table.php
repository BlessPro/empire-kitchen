<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('budgets', function (Blueprint $table) {
            if (!Schema::hasColumn('budgets', 'name')) {
                $table->string('name')->default('Untitled Budget');
            }
            if (!Schema::hasColumn('budgets', 'start_date')) {
                $table->date('start_date')->nullable();
            }
            if (!Schema::hasColumn('budgets', 'end_date')) {
                $table->date('end_date')->nullable();
            }
        });

        // Make project_id nullable and re-attach FK with nullOnDelete (works on Postgres/MySQL with DBAL)
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->change();
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->nullOnDelete();
        });

        if (Schema::hasTable('budgets')) {
            DB::table('budgets')
                ->leftJoin('projects', 'budgets.project_id', '=', 'projects.id')
                ->select('budgets.id', 'projects.name as project_name', 'budgets.name as budget_name')
                ->orderBy('budgets.id')
                ->chunk(100, function ($rows) {
                    foreach ($rows as $row) {
                        $needsFill = $row->budget_name === null || $row->budget_name === 'Untitled Budget';
                        if ($needsFill) {
                            DB::table('budgets')
                                ->where('id', $row->id)
                                ->update([
                                    'name' => $row->project_name ?: ('Budget ' . $row->id),
                                ]);
                        }
                    }
                });
        }
    }

    public function down(): void
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable(false)->change();
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn(['name', 'start_date', 'end_date']);
        });
    }
};
