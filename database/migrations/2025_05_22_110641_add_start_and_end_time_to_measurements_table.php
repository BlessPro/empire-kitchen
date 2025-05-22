<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartAndEndTimeToMeasurementsTable extends Migration
{
    public function up()
    {
        Schema::table('measurements', function (Blueprint $table) {
            $table->dateTime('start_time')->nullable()->after('id'); // or after any relevant column
            $table->dateTime('end_time')->nullable()->after('start_time');
        });
    }

    public function down()
    {
        Schema::table('measurements', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
        });
    }
}

