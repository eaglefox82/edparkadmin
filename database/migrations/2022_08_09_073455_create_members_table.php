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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('cert_no');
            $table->string('last_name');
            $table->string('first_name');
            $table->date('dob');
            $table->date('doj');
            $table->integer('type');
            $table->string('annual_subs')->default('');
            $table->integer('squadron_id')->nullable();
            $table->integer('wing_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->boolean('active')->default(true);
            $table->string('gender');
            $table->string('current_rank')->default('');
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
        Schema::dropIfExists('members');
    }
};
