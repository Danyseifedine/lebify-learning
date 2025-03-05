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
        Schema::table('course_documents', function (Blueprint $table) {
            // Drop the description_ar column
            $table->dropColumn('description_en');

            // Ensure description_en exists (in case it doesn't)
            if (!Schema::hasColumn('course_documents', 'description_en')) {
                $table->text('description_en');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_documents', function (Blueprint $table) {
            // Add back the description_ar column
            $table->text('description_en');
        });
    }
};
