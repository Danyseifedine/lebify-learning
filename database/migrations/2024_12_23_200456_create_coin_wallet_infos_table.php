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
        Schema::create('coin_wallet_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('coin_wallet_id')->constrained('coin_wallets');
            $table->string('wallet_number', 12)->unique();
            $table->string('pin', 6);
            $table->string('nickname')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('wallet_number');
            $table->unique(['user_id', 'coin_wallet_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_wallet_infos');
    }
};
