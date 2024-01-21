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
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('membership_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->decimal('rank',3,0);
            $table->date('date_joined');
            $table->date('date_birth');
            $table->string('member_type');
            $table->string('active');
            $table->string('join_month');
            $table->string('join_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
