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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects'); // Foreign key for the subject
            $table->foreignId('tutor_id')->constrained('tutors'); // Foreign key for the tutor
            $table->string('day_of_week'); // E.g., 'Monday', 'Tuesday', etc.
            $table->time('start_time'); // Start time of the class
            $table->time('end_time'); // End time of the class
            $table->foreignId('class_id')->constrained('classroom'); // Optional: Foreign key for the classroom
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
