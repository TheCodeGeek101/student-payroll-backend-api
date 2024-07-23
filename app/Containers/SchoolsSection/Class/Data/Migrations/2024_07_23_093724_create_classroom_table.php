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
        Schema::create('classroom', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('tutor_id')->constrained('tutors')->onDelete('cascade');
            $table->json('schedule')->nullable();
            $table->string('term');
            $table->integer('capacity');
            $table->integer('enrolled_students_count')->default(0);
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('room')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom');
    }
};
