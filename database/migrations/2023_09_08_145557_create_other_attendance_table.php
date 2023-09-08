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
        Schema::create('other_attendance', function (Blueprint $table) {
            $table->id();
            $table->string('member_id');
            $table->string('event_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('relationship');
            $table->string('status');
            $table->string('form17');
            $table->string('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_attendance');
    }
};
