<?php
// database/migrations/2025_09_06_000002_create_accessory_types_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('accessory_types', function (Blueprint $table) {
      $table->id();
      $table->foreignId('accessory_id')->constrained('accessories')->cascadeOnDelete();
      $table->string('value', 80); // e.g. Inbuilt, Freestanding, Undercabinet, Chimney
      $table->timestamps();
      $table->unique(['accessory_id', 'value']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('accessory_types');
  }
};
