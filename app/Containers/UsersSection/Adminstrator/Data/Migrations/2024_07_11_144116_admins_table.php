<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number');
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            $table->string('profile_picture')->nullable();
            $table->string('employee_id')->unique();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->date('date_of_hire');
            $table->enum('employment_type', ['Full-Time', 'Part-Time', 'Contract'])->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_email')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrators');
    }
}
