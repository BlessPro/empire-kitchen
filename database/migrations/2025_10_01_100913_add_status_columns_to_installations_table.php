<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('installations', function (Blueprint $t) {
            if (!Schema::hasColumn('installations', 'is_done')) {
                $t->boolean('is_done')->default(false)->after('notes');
            }
            if (!Schema::hasColumn('installations', 'done_at')) {
                $t->timestamp('done_at')->nullable()->after('is_done');
            }
        });
    }

    public function down(): void
    {
        Schema::table('installations', function (Blueprint $t) {
            if (Schema::hasColumn('installations', 'done_at')) $t->dropColumn('done_at');
            if (Schema::hasColumn('installations', 'is_done')) $t->dropColumn('is_done');
        });
    }
};
