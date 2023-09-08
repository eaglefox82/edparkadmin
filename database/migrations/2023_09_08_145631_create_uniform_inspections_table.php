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
        Schema::create('uniform_inspections', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->integer('inspection_id');
            $table->integar('points_lost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uniform_inspections');
    }
};
