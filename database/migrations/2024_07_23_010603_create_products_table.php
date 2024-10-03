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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->string('prodName');
            $table->string('prodCondition');
            $table->decimal('prodCommissionFee')->nullable();
            $table->decimal('prodPrice');
            $table->string('prodImage')->nullable();
            $table->string('prodDescription');
            $table->string('prodRefTag')->nullable();
            $table->boolean('featured')->default(false);

            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};