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
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('products_id');

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete('cascade');
            $table->foreign('products_id')->references('id')->on('products')->cascadeOnDelete('cascade');
            $table->decimal('offer_price', 10, 2);
            $table->string('meetup_location');
            $table->dateTime('meetup_time');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};