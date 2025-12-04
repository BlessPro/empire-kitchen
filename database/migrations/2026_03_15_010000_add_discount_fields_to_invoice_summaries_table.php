<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invoice_summaries', function (Blueprint $table) {
            $table->decimal('raw_subtotal', 12, 2)->nullable()->after('invoice_id');
            $table->decimal('discount_percent', 5, 2)->nullable()->after('raw_subtotal');
            $table->decimal('discount_amount', 12, 2)->nullable()->after('discount_percent');
        });
    }

    public function down(): void
    {
        Schema::table('invoice_summaries', function (Blueprint $table) {
            if (Schema::hasColumn('invoice_summaries', 'discount_amount')) {
                $table->dropColumn('discount_amount');
            }
            if (Schema::hasColumn('invoice_summaries', 'discount_percent')) {
                $table->dropColumn('discount_percent');
            }
            if (Schema::hasColumn('invoice_summaries', 'raw_subtotal')) {
                $table->dropColumn('raw_subtotal');
            }
        });
    }
};
