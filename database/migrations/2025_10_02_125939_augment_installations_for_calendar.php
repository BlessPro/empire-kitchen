<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('installations', function (Blueprint $t) {
            if (!Schema::hasColumn('installations', 'start_time')) {
                $t->dateTime('start_time')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('installations', 'install_date')) {
                $t->date('install_date')->nullable()->after('start_time');
            }
            if (!Schema::hasColumn('installations', 'install_time')) {
                $t->time('install_time')->nullable()->after('install_date');
            }
        });

        // Backfill start_time from created_at if missing
        DB::statement("
            UPDATE installations
            SET start_time = COALESCE(start_time, created_at)
            WHERE start_time IS NULL
        ");

        // Backfill install_date/time from start_time
        DB::statement("
            UPDATE installations
            SET install_date = COALESCE(install_date, DATE(start_time)),
                install_time = COALESCE(install_time, TIME(start_time))
            WHERE start_time IS NOT NULL
              AND (install_date IS NULL OR install_time IS NULL)
        ");

        // Add indexes (safe even if table is large)
        Schema::table('installations', function (Blueprint $t) {
            $t->index('start_time', 'installations_start_time_index');
            $t->index('install_date', 'installations_install_date_index');
            $t->index('is_done', 'installations_is_done_index');
        });
    }

    public function down(): void
    {
        Schema::table('installations', function (Blueprint $t) {
            if (Schema::hasColumn('installations', 'install_time')) $t->dropColumn('install_time');
            if (Schema::hasColumn('installations', 'install_date')) $t->dropColumn('install_date');
            if (Schema::hasColumn('installations', 'start_time')) $t->dropColumn('start_time');
            // We are NOT touching is_done/done_at in down(), since you already had them.
        });
    }
};
