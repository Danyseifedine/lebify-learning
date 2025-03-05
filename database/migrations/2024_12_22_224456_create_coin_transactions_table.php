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
        Schema::create('coin_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('coin_wallets')->onDelete('cascade');
            $table->foreignId('source_id')->constrained('coin_sources');
            $table->enum('type', ['earned', 'spent']);
            $table->integer('amount');
            $table->integer('balance_after');
            $table->string('description');
            $table->nullableMorphs('reference');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_transactions');
    }
};
