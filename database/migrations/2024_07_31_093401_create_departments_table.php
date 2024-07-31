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
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Primary key: id
            $table->string('name'); // Name of the department
            $table->string('code')->unique(); // Unique code for the department
            $table->foreignId('head_of_department')->nullable()->constrained('tutors')->onDelete('set null');
            $table->text('description')->nullable(); // Description of the department
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
