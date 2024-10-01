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
        Schema::table('grades', function (Blueprint $table) {
            // Check for the term_id column before adding it
            if (!Schema::hasColumn('grades', 'term_id')) {
                $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            }

            // Check for the class_id column before adding it
            if (!Schema::hasColumn('grades', 'class_id')) {
                $table->foreignId('class_id')->constrained('classrooms')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            if (Schema::hasColumn('grades', 'term_id')) {
                $table->dropForeign(['term_id']);
                $table->dropColumn('term_id');
            }

            if (Schema::hasColumn('grades', 'class_id')) {
                $table->dropForeign(['class_id']);
                $table->dropColumn('class_id');
            }
        });
    }
};
