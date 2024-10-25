<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->default('student@lebify.online');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->integer('age')->nullable();
            $table->string('uuid')->unique()->nullable();
            $table->string('password')->default(Hash::make('password'));
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedInteger('login_count')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
