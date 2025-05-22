<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('installations', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }

    public function down(): void
    {
        Schema::table('installations', function (Blueprint $table) {
            $table->string('images')->nullable(); // or use the original type of the column
        });
    }
};

