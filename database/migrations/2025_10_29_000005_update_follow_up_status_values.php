<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('follow_ups') || !Schema::hasColumn('follow_ups', 'status')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE follow_ups DROP CONSTRAINT IF EXISTS follow_ups_status_check");
            DB::statement("ALTER TABLE follow_ups ALTER COLUMN status DROP DEFAULT");
            DB::statement("ALTER TABLE follow_ups ALTER COLUMN status TYPE VARCHAR(20) USING status::text");
            DB::statement("UPDATE follow_ups SET status = 'Sold' WHERE status = 'Completed'");
            DB::statement("UPDATE follow_ups SET status = 'Unsold' WHERE status IN ('Pending', 'Rescheduled')");
            DB::statement("DROP TYPE IF EXISTS follow_ups_status_enum");
            DB::statement("CREATE TYPE follow_ups_status_enum AS ENUM ('Sold', 'Unsold')");
            DB::statement("ALTER TABLE follow_ups ALTER COLUMN status TYPE follow_ups_status_enum USING status::follow_ups_status_enum");
            DB::statement("ALTER TABLE follow_ups ALTER COLUMN status SET DEFAULT 'Unsold'");
        } elseif (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("UPDATE follow_ups SET status = 'Sold' WHERE status = 'Completed'");
            DB::statement("UPDATE follow_ups SET status = 'Unsold' WHERE status IN ('Pending', 'Rescheduled')");
            DB::statement("ALTER TABLE follow_ups MODIFY status ENUM('Sold', 'Unsold') DEFAULT 'Unsold'");
        } else {
            Schema::table('follow_ups', function (Blueprint $table) {
                $table->string('status', 20)->default('Unsold')->change();
            });

            DB::table('follow_ups')
                ->whereIn('status', ['Completed'])
                ->update(['status' => 'Sold']);

            DB::table('follow_ups')
                ->whereIn('status', ['Pending', 'Rescheduled'])
                ->update(['status' => 'Unsold']);
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('follow_ups') || !Schema::hasColumn('follow_ups', 'status')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE follow_ups ALTER COLUMN status DROP DEFAULT");
            DB::statement("ALTER TABLE follow_ups ALTER COLUMN status TYPE VARCHAR(20) USING status::text");
            DB::statement("UPDATE follow_ups SET status = 'Completed' WHERE status = 'Sold'");
            DB::statement("UPDATE follow_ups SET status = 'Pending' WHERE status = 'Unsold'");
            DB::statement("DROP TYPE IF EXISTS follow_ups_status_enum");
            DB::statement("CREATE TYPE follow_ups_status_enum AS ENUM ('Pending', 'Completed', 'Rescheduled')");
            DB::statement("ALTER TABLE follow_ups ALTER COLUMN status TYPE follow_ups_status_enum USING status::follow_ups_status_enum");
            DB::statement("ALTER TABLE follow_ups ALTER COLUMN status SET DEFAULT 'Pending'");
        } elseif (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("UPDATE follow_ups SET status = 'Completed' WHERE status = 'Sold'");
            DB::statement("UPDATE follow_ups SET status = 'Pending' WHERE status = 'Unsold'");
            DB::statement("ALTER TABLE follow_ups MODIFY status ENUM('Pending', 'Completed', 'Rescheduled') DEFAULT 'Pending'");
        } else {
            Schema::table('follow_ups', function (Blueprint $table) {
                $table->string('status', 20)->default('Pending')->change();
            });

            DB::table('follow_ups')
                ->where('status', 'Sold')
                ->update(['status' => 'Completed']);

            DB::table('follow_ups')
                ->where('status', 'Unsold')
                ->update(['status' => 'Pending']);
        }
    }
};

