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
    Schema::create('conversation_participants', function (Blueprint $table) {
        $table->id();
        $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->enum('role', ['owner', 'admin', 'member'])->default('member');
        $table->timestamp('last_read_at')->nullable()->index();
        $table->timestamp('muted_until')->nullable();
        $table->timestamp('pinned_at')->nullable();
        $table->timestamp('left_at')->nullable();
        $table->timestamps();

        $table->unique(['conversation_id', 'user_id']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversation_participants');
    }
};
