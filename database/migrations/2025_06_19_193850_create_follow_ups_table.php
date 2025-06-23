<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowUpsTable extends Migration
{
    public function up()
    {
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');

            $table->date('follow_up_date');
            $table->time('follow_up_time');

            $table->enum('priority', ['Low', 'Medium', 'High']);
            $table->enum('status', ['Pending', 'Completed', 'Rescheduled']);

            $table->text('notes')->nullable();

            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('follow_ups');
    }
}

