<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesignDateToDesignsTable extends Migration
{
    public function up()
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->date('design_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('design_date');
        });
    }
}
