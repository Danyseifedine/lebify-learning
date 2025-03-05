<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modify courses table
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('description_ar');
        });

        // Modify course_lessons table
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->dropColumn('description_ar');
            $table->string('language')->default('English')->change();
        });

        // Modify course_documents table
        Schema::table('course_documents', function (Blueprint $table) {
            $table->dropColumn([
                'title_ar',
                'description_ar'
            ]);
            // Keeping content_ar as requested
        });

        // Modify course_resources table
        Schema::table('course_resources', function (Blueprint $table) {
            $table->dropColumn([
                'title_ar',
                'description_ar'
            ]);
        });

        // Modify course_extentions table
        Schema::table('course_extentions', function (Blueprint $table) {
            $table->dropColumn('description_ar');
        });
    }

    public function down(): void
    {
        // Restore courses table
        Schema::table('courses', function (Blueprint $table) {
            $table->text('description_ar');
        });

        // Restore course_lessons table
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->text('description_ar')->nullable();
            $table->string('language')->default('Arabic')->change();
        });

        // Restore course_documents table
        Schema::table('course_documents', function (Blueprint $table) {
            $table->string('title_ar');
            $table->text('description_ar');
        });

        // Restore course_resources table
        Schema::table('course_resources', function (Blueprint $table) {
            $table->string('title_ar');
            $table->text('description_ar')->nullable();
        });

        // Restore course_extentions table
        Schema::table('course_extentions', function (Blueprint $table) {
            $table->text('description_ar')->nullable();
        });
    }
};
