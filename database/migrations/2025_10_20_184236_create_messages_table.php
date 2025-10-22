<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    // If other tables have FKs to messages (or vice-versa), disable FKs first
    Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('messages');   // ⚠️ deletes existing data
    Schema::enableForeignKeyConstraints();

    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
        $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
        $table->enum('type', ['text', 'file', 'system']);
        $table->text('body')->nullable();
        $table->json('metadata')->nullable();
        $table->foreignId('reply_to_message_id')->nullable()->constrained('messages')->nullOnDelete();
        $table->timestamps();
        $table->index(['conversation_id', 'created_at']);
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
