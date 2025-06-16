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
    Schema::create('invoices', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_code')->unique(); // Frontend-generated invoice ID
        $table->date('due_date')->nullable();
        $table->foreignId('client_id')->constrained()->onDelete('cascade');
        $table->foreignId('project_id')->constrained()->onDelete('cascade');
        $table->boolean('send_email')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
