<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->nullable()->after('employee_id');
                $table->index('email');
            }
        });

        if (
            Schema::hasColumn('users', 'employee_id') &&
            Schema::hasColumn('users', 'email') &&
            Schema::hasColumn('employees', 'email')
        ) {
            DB::statement("
                UPDATE users
                SET email = employees.email
                FROM employees
                WHERE employees.id = users.employee_id
                  AND employees.email IS NOT NULL
            ");
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email')) {
                try {
                    $table->dropIndex(['email']);
                } catch (\Throwable $e) {
                    // ignore if index does not exist
                }
                $table->dropColumn('email');
            }
        });
    }
};
