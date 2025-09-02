<?php
// database/migrations/2025_09_01_171500_transform_users_to_employee_auth.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1) Add employee_id (nullable first), and last_seen_at if missing
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'employee_id')) {
                $table->foreignId('employee_id')->nullable()->after('id')->constrained('employees')->cascadeOnDelete();
                $table->unique('employee_id', 'users_employee_id_unique'); // allow only one user per employee
            }

            if (!Schema::hasColumn('users', 'last_seen_at')) {
                $table->timestamp('last_seen_at')->nullable()->after('updated_at');
            }

            // Ensure role exists (and keep it simple)
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role', 50)->default('employee')->after('employee_id');
            }
        });

        /**
         * 2) (Optional) Backfill employee_id.
         * Adjust the join conditions to match your schema.
         * Example: match users.email to employees.email, or phone_number to a field on employees.
         * If you don’t have email/phone on employees, you can match by name or staff_id, etc.
         */
        // Example backfill by email:
        if (Schema::hasColumn('users','email') && Schema::hasColumn('employees','email')) {
            // MySQL-only update join
            DB::statement("
                UPDATE users
                JOIN employees ON employees.email = users.email
                SET users.employee_id = employees.id
                WHERE users.employee_id IS NULL
            ");
        }

        // Example backfill by phone:
        if (Schema::hasColumn('users','phone_number') && Schema::hasColumn('employees','phone')) {
            DB::statement("
                UPDATE users
                JOIN employees ON employees.phone = users.phone_number
                SET users.employee_id = employees.id
                WHERE users.employee_id IS NULL
            ");
        }

        // If you prefer to backfill by staff_id stored temporarily somewhere, write another UPDATE ... JOIN here.

        /**
         * 3) Make employee_id NOT NULL (only if all rows got linked).
         * If some users couldn't be matched, set a default mapping manually before making it not nullable.
         */
        $unlinked = DB::table('users')->whereNull('employee_id')->count();
        if ($unlinked > 0) {
            // If any remain, you can either create placeholder employees or leave employee_id nullable for now.
            // For safety, we will NOT force NOT NULL if there are unlinked rows.
            // Remove this guard if you want to force it:
            // throw new RuntimeException("There are {$unlinked} users without employee mapping. Backfill required.");
        } else {
            Schema::table('users', function (Blueprint $table) {
                // Make NOT NULL
                $table->foreignId('employee_id')->nullable(false)->change();
            });
        }

        /**
         * 4) Drop user profile columns you no longer want to keep on users.
         * We keep password, remember_token, role, last_seen_at, timestamps.
         */
        Schema::table('users', function (Blueprint $table) {
            // drop ONLY if they exist
            foreach (['name','email','phone_number','profile_pic'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        // Recreate dropped columns (as nullable)
        Schema::table('users', function (Blueprint $table) {
            foreach (['name','email','phone_number','profile_pic'] as $col) {
                if (!Schema::hasColumn('users', $col)) {
                    if ($col === 'email') {
                        $table->string('email')->nullable();
                    } elseif ($col === 'phone_number') {
                        $table->string('phone_number')->nullable();
                    } elseif ($col === 'profile_pic') {
                        $table->string('profile_pic')->nullable();
                    } else {
                        $table->string('name')->nullable();
                    }
                }
            }
        });

        // Make employee_id nullable again and drop it + unique + FK
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'employee_id')) {
                // drop unique if it exists
                try { $table->dropUnique('users_employee_id_unique'); } catch (\Throwable $e) {}

                // drop FK
                try { $table->dropForeign(['employee_id']); } catch (\Throwable $e) {}

                $table->dropColumn('employee_id');
            }
        });

        Schema::enableForeignKeyConstraints();
    }
};
