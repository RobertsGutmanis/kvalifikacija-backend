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
        Schema::create('user_data', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('user_id');
            $table->string('name',16);
            $table->string('second_name',16);
            $table->string('last_name',16);
            $table->integer('phone_num');
            $table->integer('phone_code');
            $table->string('country',32);
            $table->string('address',64);
            $table->string('city',16);
            $table->string('zip',7);
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_data');
    }
};
