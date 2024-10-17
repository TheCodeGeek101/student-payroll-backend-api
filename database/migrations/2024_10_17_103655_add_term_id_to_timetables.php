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
        Schema::table('timetables', function (Blueprint $table) {
            if (!Schema::hasColumn('grades', 'term_id')) {
                $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timetables', function (Blueprint $table) {
            if (!Schema::hasColumn('grades', 'term_id')) {
                $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            }
        });
    }
};
