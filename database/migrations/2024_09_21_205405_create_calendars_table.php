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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade'); // Foreign key to the terms table
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('description')->nullable();
            $table->softDeletes(); // Add soft delete functionality
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
