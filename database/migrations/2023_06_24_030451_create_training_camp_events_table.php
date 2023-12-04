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
        Schema::create('training_camp_events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('from_date');
            $table->dateTime('to_date');
            $table->boolean('active')->default(true);
            $table->decimal('camp_fee')->default(160);
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
        Schema::dropIfExists('training_camp_events');
    }
};
