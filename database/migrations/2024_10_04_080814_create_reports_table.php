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
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); // Who is making the report
            $table->unsignedInteger('reported_user_id')->nullable(); // User being reported
            $table->unsignedInteger('products_id')->nullable(); // Listing being reported

            $table->enum('report_type', ['product', 'user'])->default('product');
            $table->enum('reason', [
                'inappropriate',
                'fraud',
                'harassment',
                'spam',
                'misleading',
                'impersonation',
                'offensive',
                'privacy',
                'malicious',
                'fake_profile',
                'duplicate',
                'prohibited',
                'condition',
                'copyright',
                'safety',
                'other'
            ])->nullable();

            $table->text('details')->nullable();
            $table->enum('status', ['pending','reviewed','resolved','dismissed'])->default('pending');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reported_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};