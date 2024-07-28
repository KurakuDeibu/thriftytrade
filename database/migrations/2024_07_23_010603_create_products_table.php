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
            $table->foreignId('user_id');
            


            $table->string('prodName')->unique();
            $table->string('prodCondition');
            $table->decimal('prodCommissionFee')->nullable();
            $table->decimal('prodPrice');
            $table->string('prodImage')->nullable();          
            $table->string('prodDescription')->unique();
            // $table->string('title');
            $table->string('slug')->unique();
            // $table->string('description');
            $table->string('prodRefTag');
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
