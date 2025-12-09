<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('follow_ups')) {
            return;
        }

        if (!Schema::hasColumn('follow_ups', 'client_name')) {
            Schema::table('follow_ups', function (Blueprint $table) {
                $table->string('client_name')->nullable()->after('client_id');
            });
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE follow_ups ALTER COLUMN client_id DROP NOT NULL');
        } elseif (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE follow_ups MODIFY client_id BIGINT UNSIGNED NULL');
        } else {
            Schema::table('follow_ups', function (Blueprint $table) {
                $table->foreignId('client_id')->nullable()->change();
            });
        }

        if ($driver === 'pgsql') {
            DB::statement("
                UPDATE follow_ups f
                SET client_name = TRIM(CONCAT(COALESCE(c.firstname, ''), ' ', COALESCE(c.lastname, '')))
                FROM clients c
                WHERE f.client_id = c.id
                  AND (f.client_name IS NULL OR f.client_name = '')
            ");
        } elseif (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("
                UPDATE follow_ups f
                JOIN clients c ON c.id = f.client_id
                SET f.client_name = TRIM(CONCAT(COALESCE(c.firstname, ''), ' ', COALESCE(c.lastname, '')))
                WHERE (f.client_name IS NULL OR f.client_name = '')
            ");
        } else {
            DB::statement("
                UPDATE follow_ups
                SET client_name = (
                    SELECT TRIM(COALESCE(clients.firstname, '') || ' ' || COALESCE(clients.lastname, ''))
                    FROM clients
                    WHERE clients.id = follow_ups.client_id
                )
                WHERE client_id IS NOT NULL
                  AND (client_name IS NULL OR client_name = '')
            ");
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('follow_ups')) {
            return;
        }

        if (Schema::hasColumn('follow_ups', 'client_name')) {
            Schema::table('follow_ups', function (Blueprint $table) {
                $table->dropColumn('client_name');
            });
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            $fallbackClient = DB::table('clients')->orderBy('id')->value('id');
            if ($fallbackClient) {
                DB::table('follow_ups')->whereNull('client_id')->update(['client_id' => $fallbackClient]);
            } else {
                DB::table('follow_ups')->whereNull('client_id')->delete();
            }
            DB::statement('ALTER TABLE follow_ups ALTER COLUMN client_id SET NOT NULL');
        } elseif (in_array($driver, ['mysql', 'mariadb'], true)) {
            $fallbackClient = DB::table('clients')->orderBy('id')->value('id');
            if ($fallbackClient) {
                DB::table('follow_ups')->whereNull('client_id')->update(['client_id' => $fallbackClient]);
            } else {
                DB::table('follow_ups')->whereNull('client_id')->delete();
            }
            DB::statement('ALTER TABLE follow_ups MODIFY client_id BIGINT UNSIGNED NOT NULL');
        } else {
            Schema::table('follow_ups', function (Blueprint $table) {
                $table->foreignId('client_id')->nullable(false)->change();
            });
        }
    }
};
