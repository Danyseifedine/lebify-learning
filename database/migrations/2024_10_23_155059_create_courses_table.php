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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description_ar');
            $table->text('description_en');
            $table->unsignedBigInteger('instructor_id');
            $table->integer('duration')->comment('Duration in minutes');
            $table->unsignedTinyInteger('difficulty_level')->default(1)->comment('Level of hardness from 1 to 5');
            $table->boolean('is_published')->default(false);
            $table->string('color')->default('#F77E15');
            $table->integer('views')->default(0);
            $table->timestamps();

            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
