<?php
// database/migrations/2025_09_06_000003_add_is_active_to_accessories.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('accessories', function (Blueprint $table) {
      if (!Schema::hasColumn('accessories','is_active')) {
        $table->boolean('is_active')->default(true)->after('notes');
      }
    });
  }
  public function down(): void {
    Schema::table('accessories', function (Blueprint $table) {
      if (Schema::hasColumn('accessories','is_active')) $table->dropColumn('is_active');
    });
  }
};
