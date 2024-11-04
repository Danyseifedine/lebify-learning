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
        Schema::table('course_resources', function (Blueprint $table) {
            $table->dropColumn('video_id');
            $table->string('url')->before('title_en');
            $table->boolean('is_published')->default(true)->before('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_resources', function (Blueprint $table) {
            $table->string('video_id');
            $table->dropColumn(['url', 'is_published']);
        });
    }
};