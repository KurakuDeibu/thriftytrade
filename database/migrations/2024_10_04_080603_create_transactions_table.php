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
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('products_id');
            $table->unsignedInteger('offer_id')->nullable(); // Reference to the accepted offer

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('products_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();

            $table->timestamp('tranDate')->nullable();
            $table->integer('quantity');
            $table->decimal('totalPrice', 10, 2);
            $table->enum('tranStatus', ['pending', 'completed', 'canceled'])->default('pending');
            $table->decimal('systemCommission', 10, 2)->nullable();
            $table->decimal('finderCommission', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};