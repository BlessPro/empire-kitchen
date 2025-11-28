<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'client_id')) {
                $table->dropForeign(['client_id']);
            }
            if (Schema::hasColumn('invoices', 'project_id')) {
                $table->dropForeign(['project_id']);
            }
        });

        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'client_id')) {
                $table->foreignId('client_id')->nullable()->change();
            }
            if (Schema::hasColumn('invoices', 'project_id')) {
                $table->foreignId('project_id')->nullable()->change();
            }
        });

        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'client_id')) {
                $table->foreign('client_id')->references('id')->on('clients')->nullOnDelete();
            }
            if (Schema::hasColumn('invoices', 'project_id')) {
                $table->foreign('project_id')->references('id')->on('projects')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'client_id')) {
                $table->dropForeign(['client_id']);
            }
            if (Schema::hasColumn('invoices', 'project_id')) {
                $table->dropForeign(['project_id']);
            }
        });

        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'client_id')) {
                $table->foreignId('client_id')->nullable(false)->change();
            }
            if (Schema::hasColumn('invoices', 'project_id')) {
                $table->foreignId('project_id')->nullable(false)->change();
            }
        });

        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'client_id')) {
                $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            }
            if (Schema::hasColumn('invoices', 'project_id')) {
                $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
            }
        });
    }
};
