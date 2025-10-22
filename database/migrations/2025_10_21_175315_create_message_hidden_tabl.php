<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// database/migrations/xxxx_xx_xx_xxxxxx_create_message_hidden_table.php
return new class extends Migration {
    public function up(): void {
        Schema::dropIfExists('message_hidden');

        Schema::create('message_hidden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('messages')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['message_id','user_id']);
            $table->index(['user_id','message_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('message_hidden');
    }
};

