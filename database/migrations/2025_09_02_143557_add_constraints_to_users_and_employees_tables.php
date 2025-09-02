<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** Helpers */
    private function indexExists(string $table, string $index): bool
    {
        $db = DB::getDatabaseName();
        $row = DB::selectOne(
            "SELECT COUNT(1) AS c
             FROM information_schema.statistics
             WHERE table_schema = ? AND table_name = ? AND index_name = ?",
            [$db, $table, $index]
        );
        return (int)($row->c ?? 0) > 0;
    }

    private function foreignKeyExists(string $table, string $fkName): bool
    {
        $db = DB::getDatabaseName();
        $row = DB::selectOne(
            "SELECT COUNT(1) AS c
             FROM information_schema.table_constraints
             WHERE constraint_schema = ? AND table_name = ? AND constraint_name = ? AND constraint_type = 'FOREIGN KEY'",
            [$db, $table, $fkName]
        );
        return (int)($row->c ?? 0) > 0;
    }

    public function up(): void
    {
        // employees.staff_id UNIQUE
        if (! $this->indexExists('employees', 'employees_staff_id_unique')) {
            Schema::table('employees', function (Blueprint $table) {
                // name the index explicitly so we can detect it later
                $table->unique('staff_id', 'employees_staff_id_unique');
            });
        }

        // users.employee_id column + FK + UNIQUE (guarded)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'employee_id')) {
                $table->foreignId('employee_id')
                      ->after('id')
                      ->constrained('employees')
                      ->cascadeOnDelete();
            }
        });

        // users.employee_id UNIQUE
        if (! $this->indexExists('users', 'users_employee_id_unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('employee_id', 'users_employee_id_unique');
            });
        }

        // users -> employees FK (name depends on Laravel’s auto-naming)
        // Default name is usually "users_employee_id_foreign"
        if (! $this->foreignKeyExists('users', 'users_employee_id_foreign')) {
            // If your FK was added above when adding the column, this will already exist.
            // Otherwise, add it explicitly:
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('employee_id', 'users_employee_id_foreign')
                      ->references('id')->on('employees')
                      ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        // Drop users unique + FK safely
        if ($this->indexExists('users', 'users_employee_id_unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_employee_id_unique');
            });
        }

        if ($this->foreignKeyExists('users', 'users_employee_id_foreign')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign('users_employee_id_foreign');
            });
        }

        // (Optional) drop column — only if you want to undo schema entirely
        if (Schema::hasColumn('users', 'employee_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('employee_id');
            });
        }

        // Drop employees.staff_id unique safely
        if ($this->indexExists('employees', 'employees_staff_id_unique')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropUnique('employees_staff_id_unique');
            });
        }
    }
};
