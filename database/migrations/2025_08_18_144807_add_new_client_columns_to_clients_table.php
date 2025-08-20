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
    Schema::table('clients', function (Blueprint $table) {
        $table->string('other_phone')->nullable()->after('phone_number');
        $table->string('contact_person')->nullable()->after('other_phone');
        $table->string('contact_phone')->nullable()->after('contact_person');
        $table->string('address')->nullable()->after('location');
    });
}

public function down()
{
    Schema::table('clients', function (Blueprint $table) {
        $table->dropColumn(['other_phone', 'contact_person', 'contact_phone', 'address']);
    });
}

};
