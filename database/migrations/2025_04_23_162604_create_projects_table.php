<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_projects_table.php
public function up()
{
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->unsignedBigInteger('client_id');
        $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
        $table->date('start_date');
        $table->date('measurement_date')->nullable();
        $table->date('design_date')->nullable();
        $table->date('production_date')->nullable();
        $table->date('installation_date')->nullable();
        $table->unsignedBigInteger('first_assigned_tech_supervisor')->nullable();
        $table->unsignedBigInteger('second_assigned_tech_supervisor')->nullable();
        $table->unsignedBigInteger('first_assigned_designer')->nullable();
        $table->unsignedBigInteger('second_assigned_designer')->nullable();
        $table->decimal('cost', 10, 2)->default(0.00);
        $table->timestamps();

        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
