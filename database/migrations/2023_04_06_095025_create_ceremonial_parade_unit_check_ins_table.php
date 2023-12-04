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
        Schema::create('ceremonial_parade_unit_check_ins', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->integer('squadron_id')->nullable();
            $table->integer('wing_id')->nullable();
            $table->integer('on_parade')->default(0);
            $table->string('arm_band')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ceremonial_parade_unit_check_ins');
    }
};
