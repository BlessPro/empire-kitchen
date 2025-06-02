<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUserIdToDesignerIdInDesignsTable extends Migration
{
    public function up()
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->renameColumn('user_id', 'designer_id');
        });
    }

    public function down()
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->renameColumn('designer_id', 'user_id');
        });
    }
}
