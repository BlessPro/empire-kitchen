<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('follow_ups', function (Blueprint $table) {
            $table->dateTime('reminder_at')->nullable()->after('follow_up_time')->index();
            $table->string('reminder_status', 32)->nullable()->after('reminder_at')->index();
        });
    }

    public function down(): void
    {
        Schema::table('follow_ups', function (Blueprint $table) {
            if (Schema::hasColumn('follow_ups', 'reminder_status')) {
                $table->dropColumn('reminder_status');
            }
            if (Schema::hasColumn('follow_ups', 'reminder_at')) {
                $table->dropIndex(['reminder_at']);
                $table->dropColumn('reminder_at');
            }
        });
    }
};
