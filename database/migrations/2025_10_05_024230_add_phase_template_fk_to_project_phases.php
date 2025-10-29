<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Add column (if missing)
        if (!Schema::hasColumn('project_phases', 'phase_template_id')) {
            Schema::table('project_phases', function (Blueprint $t) {
                $t->unsignedBigInteger('phase_template_id')->nullable()->after('project_id');
            });
        }

        // 2) Add FK (if not already there)
        // MySQL FK names are predictable but can vary; try/catch is simplest
        try {
            Schema::table('project_phases', function (Blueprint $t) {
                $t->foreign('phase_template_id')
                  ->references('id')->on('phase_templates')
                  ->cascadeOnDelete();
            });
        } catch (\Throwable $e) {
            // ignore if it already exists
        }

        // 3) BACKFILL phase_template_id
        $hasProductType = Schema::hasColumn('projects', 'product_type');

        $driver = DB::getDriverName();
        if ($hasProductType) {
            if ($driver === 'pgsql') {
                DB::statement("
                    UPDATE project_phases AS pp
                    SET phase_template_id = pt.id
                    FROM projects AS p
                    JOIN phase_templates AS pt
                      ON LOWER(TRIM(pt.name)) = LOWER(TRIM(pp.name))
                     AND (pt.product_type IS NULL OR pt.product_type = p.product_type)
                    WHERE p.id = pp.project_id
                      AND pp.phase_template_id IS NULL
                ");
            } else {
                DB::statement("
                    UPDATE project_phases AS pp
                    JOIN projects AS p ON p.id = pp.project_id
                    JOIN phase_templates AS pt
                      ON LOWER(TRIM(pt.name)) = LOWER(TRIM(pp.name))
                     AND (pt.product_type IS NULL OR pt.product_type = p.product_type)
                    SET pp.phase_template_id = pt.id
                    WHERE pp.phase_template_id IS NULL
                ");
            }
        } else {
            if ($driver === 'pgsql') {
                DB::statement("
                    UPDATE project_phases AS pp
                    SET phase_template_id = pt.id
                    FROM phase_templates AS pt
                    WHERE LOWER(TRIM(pt.name)) = LOWER(TRIM(pp.name))
                      AND pp.phase_template_id IS NULL
                ");
            } else {
                DB::statement("
                    UPDATE project_phases AS pp
                    JOIN phase_templates AS pt
                      ON LOWER(TRIM(pt.name)) = LOWER(TRIM(pp.name))
                    SET pp.phase_template_id = pt.id
                    WHERE pp.phase_template_id IS NULL
                ");
            }
        }

        // 4) Add unique constraint (if not present)
        // Using try/catch to avoid "duplicate key name" on reruns
        try {
            Schema::table('project_phases', function (Blueprint $t) {
                $t->unique(['project_id','phase_template_id'], 'uq_project_phase_template');
            });
        } catch (\Throwable $e) {
            // ignore if already exists
        }
    }

    public function down(): void
    {
        // Drop unique, FK, column — all guarded
        try {
            Schema::table('project_phases', function (Blueprint $t) {
                $t->dropUnique('uq_project_phase_template');
            });
        } catch (\Throwable $e) {}

        try {
            Schema::table('project_phases', function (Blueprint $t) {
                $t->dropForeign(['phase_template_id']);
            });
        } catch (\Throwable $e) {}

        if (Schema::hasColumn('project_phases', 'phase_template_id')) {
            Schema::table('project_phases', function (Blueprint $t) {
                $t->dropColumn('phase_template_id');
            });
        }
    }
};
