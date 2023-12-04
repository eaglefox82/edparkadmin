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
        Schema::table('training_camp_members', function (Blueprint $table) {
            $table->boolean('band_training')->default(false);
            $table->boolean('day_visitor')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training_camp_members', function (Blueprint $table) {
            $table->dropColumn('band_training');
            $table->dropColumn('day_visitor');
        });
    }
};
