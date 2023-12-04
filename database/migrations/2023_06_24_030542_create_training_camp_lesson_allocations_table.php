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
        Schema::create('training_camp_lesson_allocations', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->integer('schedule_id');
            $table->integer('classroom_id');
            $table->integer('lesson_id');
            $table->integer('flight_id');
            $table->string('instructor');
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
        Schema::dropIfExists('training_camp_lesson_allocations');
    }
};
