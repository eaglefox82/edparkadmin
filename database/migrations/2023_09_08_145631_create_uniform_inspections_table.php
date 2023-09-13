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
            $table->integar('membership_card');
            $table->integar('cap');
            $table->integar('cap_badge');
            $table->integar('hair');
            $table->integar('shirt');
            $table->integar('badges');
            $table->integar('lanyard');
            $table->integar('buttons');
            $table->integar('trousers');
            $table->integar('belt');
            $table->integar('shoes');
            $table->integar('socks');
            $table->integar('tie');
            $table->integar('tie_pin');
            $table->integar('bearing');
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
