<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('conversations') && Schema::hasColumn('conversations', 'last_message_id')) {
            Schema::table('conversations', function (Blueprint $table) {
                try { $table->dropForeign(['last_message_id']); } catch (\Throwable $e) {}
            });
        }

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('messages');
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

        if (Schema::hasTable('conversations') && Schema::hasColumn('conversations', 'last_message_id')) {
            Schema::table('conversations', function (Blueprint $table) {
                $table->foreign('last_message_id')
                    ->references('id')->on('messages')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('conversations') && Schema::hasColumn('conversations', 'last_message_id')) {
            Schema::table('conversations', function (Blueprint $table) {
                try { $table->dropForeign(['last_message_id']); } catch (\Throwable $e) {}
            });
        }

        Schema::dropIfExists('messages');
    }
};
