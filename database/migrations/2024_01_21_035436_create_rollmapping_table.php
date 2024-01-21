<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rollmapping', function (Blueprint $table) {
           $table->increments('id');
            $table->date('roll_date');
            $table->integer('roll_year');
            $table->integer('roll_month');
            $table->integer('roll_week');
            $table->integer('roll_strenght');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rollmapping');
    }
};
