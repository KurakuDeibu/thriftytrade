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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); //
            $table->string('name', 25); // username
            $table->string('firstName', 50); // firstname
            $table->string('lastName', 50); // lastname
            $table->string('middleName', 50)->nullable(); // middlename
            $table->string('userAddress', 255); // user address
            $table->date('birthDay'); // birthdate
            $table->string('phoneNum', 50); // phone num
            $table->string('userRefTag', 10)->nullable(); // user ref tag
            $table->boolean('isAdmin')->default(false); //added admin role

            $table->string('email', 50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();

            $table->boolean('isFinder')->default(false); //added finder role
            $table->enum('finder_status', ['pending', 'approved', 'rejected'])->default(null)->nullable();
            $table->string('finder_document_path')->nullable();
            $table->text('finder_verification_notes')->nullable();
            $table->timestamp('finder_verified_at')->nullable();

        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};