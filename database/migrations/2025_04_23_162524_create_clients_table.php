<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('clients', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamps();
    //     });
    // }

    // database/migrations/xxxx_xx_xx_create_clients_table.php
public function up()
{
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Mr., Mrs., Miss., Bro
        $table->string('firstname');
        $table->string('lastname');
        $table->string('othernames')->nullable();
        $table->string('phone_number');
        $table->string('location');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
