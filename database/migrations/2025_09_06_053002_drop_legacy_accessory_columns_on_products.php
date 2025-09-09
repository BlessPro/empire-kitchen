<?php
// database/migrations/2025_09_06_000005_drop_legacy_accessory_columns_on_products.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('products', function (Blueprint $table) {
      if (Schema::hasColumn('products','accessory_name')) $table->dropColumn('accessory_name');
      if (Schema::hasColumn('products','accessory_size')) $table->dropColumn('accessory_size');
      if (Schema::hasColumn('products','accessory_type')) $table->dropColumn('accessory_type');
    });
  }
  public function down(): void {
    Schema::table('products', function (Blueprint $table) {
      $table->string('accessory_name')->nullable();
      $table->string('accessory_size')->nullable();
      $table->string('accessory_type')->nullable();
    });
  }
};
