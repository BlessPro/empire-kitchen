<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Business identifiers
            $table->string('staff_id')->unique()->nullable(); // auto-generate if null

            // Core profile
            $table->string('name');
            $table->string('designation')->nullable(); // Designer, Technical Supervisor, Sales, Accountant, ...
            $table->date('commencement_date')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();

            // Personal
            $table->string('nationality')->nullable();
            $table->date('dob')->nullable();
            $table->string('hometown')->nullable();
            $table->string('language')->nullable();

            // Address
            $table->string('address')->nullable();
            $table->string('gps')->nullable();

            // Next of kin
            $table->string('next_of_kin')->nullable();
            $table->string('relation')->nullable();
            $table->string('nok_phone')->nullable();

            // Bank
            $table->string('bank')->nullable();
            $table->string('branch')->nullable();
            $table->string('account_number')->nullable();

            // Media
            $table->string('avatar_path')->nullable(); // stored file path

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
