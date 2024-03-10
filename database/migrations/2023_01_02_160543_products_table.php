<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name',32);
            $table->string('manufacturer', 64);
            $table->string('description',32);
            $table->unsignedDouble('price');
            $table->unsignedDouble('last_price');
            $table->date('price_change')->default(Carbon::now());
            $table->integer('category_id');
            $table->longText('image_url');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
