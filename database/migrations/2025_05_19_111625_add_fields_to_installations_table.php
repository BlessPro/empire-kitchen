<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('installations', function (Blueprint $table) {
        //     //
        // });
        Schema::table('installations', function (Blueprint $table) {
    $table->unsignedBigInteger('client_id')->nullable();
    $table->timestamp('start_time')->nullable();
    $table->timestamp('end_time')->nullable();

    $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('installations', function (Blueprint $table) {
            //
        });
    }
};
