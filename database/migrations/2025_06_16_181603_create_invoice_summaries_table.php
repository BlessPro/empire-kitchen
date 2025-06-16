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
    Schema::create('invoice_summaries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
        $table->decimal('subtotal', 10, 2);
        $table->decimal('vat', 10, 2)->default(0);
        $table->decimal('total_amount', 10, 2);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_summaries');
    }
};
