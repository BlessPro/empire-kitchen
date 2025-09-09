<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            // add as a DATE; nullable so existing rows are fine
            $table->date('scheduled_date')->nullable()->index();
            // If you prefer to control placement:
            // $table->date('scheduled_date')->nullable()->after('some_existing_column')->index();
        });
    }

    public function down(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            if (Schema::hasColumn('measurements', 'scheduled_date')) {
                $table->dropIndex(['scheduled_date']); // drops the index
                $table->dropColumn('scheduled_date');
            }
        });
    }
};
