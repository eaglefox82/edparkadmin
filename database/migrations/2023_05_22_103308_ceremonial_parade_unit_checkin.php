<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ceremonial_parade_unit_check_ins', function (Blueprint $table) {
            $table->dateTime('checked_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ceremonial_parade_unit_check_ins', function (Blueprint $table) {
            $table->dropColumn('checked_in');
        });
    }
};
