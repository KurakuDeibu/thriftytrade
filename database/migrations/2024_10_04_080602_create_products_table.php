<?php

use App\Models\Category;
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

        Schema::create('productimages', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('products_id');

            // $table->foreign('products_id')->references('id')->on('products')->cascadeOnDelete();
            $table->string('imageURL', 255);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedInteger('productimages_id');

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('category')->cascadeOnDelete();
            $table->foreign('productimages_id')->references('id')->on('productimages')->cascadeOnDelete();

            $table->string('prodName', 255);
            $table->string('prodCondition', 20);
            $table->decimal('prodPrice', 10, 2);

            // $table->string('prodImage')->nullable();
            $table->string('prodDescription')->nullable();
            // $table->string('prodRefTag', 10)->unique();
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
        Schema::dropIfExists('productimages');
    }
};
