<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('project_id')
                    ->constrained()
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('invoices', 'invoice_type')) {
                $table->string('invoice_type', 50)
                    ->default('accounting')
                    ->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('invoices', 'invoice_type')) {
                $table->dropColumn('invoice_type');
            }
        });
    }
};
