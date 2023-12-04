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
        Schema::create('training_camp_inspection_results', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->integer('member_id');
            $table->integer('field_id');
            $table->integer('points_lost')->default(0);
            $table->string('inspected_by')->default('');
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
        Schema::dropIfExists('training_camp_inspection_results');
    }
};
