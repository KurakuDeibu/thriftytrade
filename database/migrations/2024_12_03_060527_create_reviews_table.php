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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('reviewer_id');
            $table->unsignedInteger('reviewee_id');
            $table->unsignedInteger('products_id');
            $table->unsignedInteger('offer_id');

            $table->foreign('reviewer_id')->references('id')->on('users');
            $table->foreign('reviewee_id')->references('id')->on('users');
            $table->foreign('products_id')->references('id')->on('products');
            $table->foreign('offer_id')->references('id')->on('offers');

            $table->text('content')->nullable();
            $table->integer('rating')->nullable(); //rating 1 to 5
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};