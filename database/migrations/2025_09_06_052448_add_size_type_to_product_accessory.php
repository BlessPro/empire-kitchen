<?php
// database/migrations/2025_09_06_000001_add_size_type_to_product_accessory.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('product_accessory', function (Blueprint $table) {
      if (!Schema::hasColumn('product_accessory','size')) {
        $table->string('size', 50)->nullable()->after('quantity');
      }
      if (!Schema::hasColumn('product_accessory','type')) {
        $table->string('type', 80)->nullable()->after('size'); // string, not enum
      }
      // Helpful indexes
      $table->index(['product_id']);
      $table->index(['accessory_id']);
      $table->index(['type']);
    });
  }

  public function down(): void {
    Schema::table('product_accessory', function (Blueprint $table) {
      if (Schema::hasColumn('product_accessory','type')) $table->dropColumn('type');
      if (Schema::hasColumn('product_accessory','size')) $table->dropColumn('size');
      $table->dropIndex(['product_accessory_product_id_index']);
      $table->dropIndex(['product_accessory_accessory_id_index']);
      $table->dropIndex(['product_accessory_type_index']);
    });
  }
};
