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
    Schema::create('conversations', function (Blueprint $table) {
        $table->id();
        $table->enum('type', ['direct', 'group']);
        $table->string('title')->nullable(); // Groups only
        $table->string('avatar_url')->nullable();
        $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
        $table->string('dm_key')->nullable()->unique(); // For direct chats (stable pair key)
        $table->foreignId('last_message_id')->nullable()->constrained('messages')->nullOnDelete();
        $table->timestamp('last_message_at')->nullable()->index();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
