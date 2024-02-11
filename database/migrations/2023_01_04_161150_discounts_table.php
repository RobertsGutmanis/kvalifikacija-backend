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
        Schema::create('discounts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('product_id');
            $table->integer('discount');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreign('product_id')->references('id')->on('products');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
