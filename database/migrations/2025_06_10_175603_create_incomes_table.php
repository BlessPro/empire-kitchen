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
    Schema::create('incomes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('client_id');
        $table->unsignedBigInteger('project_id');
        $table->unsignedBigInteger('category_id');
        $table->decimal('amount', 12, 2);
        $table->date('date');
        $table->string('material')->nullable(); // or required if needed
        $table->timestamps();

        // Foreign keys
        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });
}

};
