<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('tutors');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('grade'); // The letter grade
            $table->double('grade_value', 8, 2); // The numeric grade value
            $table->text('comments')->nullable(); // Comments for the grade
            $table->date('graded_at')->default(DB::raw('CURRENT_DATE')); // The date the grade was assigned
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
