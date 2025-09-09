<?php
// database/migrations/2025_09_05_000001_add_accessory_fields_to_products.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->string('accessory_name')->nullable()->after('notes');
            $table->string('accessory_size')->nullable()->after('accessory_name');
            $table->string('accessory_type')->nullable()->after('accessory_size');
        });
    }

    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['accessory_name', 'accessory_size', 'accessory_type']);
        });
    }
};
