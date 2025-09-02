<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            $table->dateTime('start_time')->nullable()->change();
            $table->dateTime('end_time')->nullable()->change();
            $table->decimal('length', 8, 2)->nullable()->change();
            $table->decimal('width', 8, 2)->nullable()->change();
            $table->decimal('height', 8, 2)->nullable()->change();
            $table->text('obstacles')->nullable()->change();
            $table->json('images')->nullable()->change();
            $table->text('notes')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            $table->dateTime('start_time')->nullable(false)->change();
            $table->dateTime('end_time')->nullable(false)->change();
            $table->decimal('length', 8, 2)->nullable(false)->change();
            $table->decimal('width', 8, 2)->nullable(false)->change();
            $table->decimal('height', 8, 2)->nullable(false)->change();
            $table->text('obstacles')->nullable(false)->change();
            $table->json('images')->nullable(false)->change();
            $table->text('notes')->nullable(false)->change();
        });
    }
};
