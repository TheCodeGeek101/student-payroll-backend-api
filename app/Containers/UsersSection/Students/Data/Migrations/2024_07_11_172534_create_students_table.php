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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('address');
            $table->string('postal_address');
            $table->enum('gender', ['F', 'M']);
            $table->string('guardian_name');
            $table->string('guardian_contact');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->date('admission_date');
            $table->string('previous_school')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('medical_info')->nullable();
            $table->string('enrollment_status')->default('Active');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('registered_by')->constrained('users', 'id');
            $table->text('remarks')->nullable();
            $table->string('registration_number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
