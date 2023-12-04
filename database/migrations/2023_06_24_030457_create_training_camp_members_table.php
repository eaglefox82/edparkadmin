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
        Schema::create('training_camp_members', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->integer('member_id');
            $table->integer('flight_id')->nullable();
            $table->integer('room_id')->nullable();
            $table->string('contact_person')->default('');
            $table->string('contact_number')->default('');
            $table->boolean('form17a_received')->default(false);
            $table->boolean('payment_received')->default(false);
            $table->dateTime('camp_checkin')->nullable();
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
        Schema::dropIfExists('training_camp_members');
    }
};