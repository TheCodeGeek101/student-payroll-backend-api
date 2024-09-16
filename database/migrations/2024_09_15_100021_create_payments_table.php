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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->double('amount');
            $table->string('description')->nullable();
            $table->date('payment_date');
            $table->boolean('confirmed')->default(false);
            $table->string('tx_ref');
            $table->foreignId('class_id')->constrained('classroom');
            $table->foreignId('term_id')->constrained('terms');
            $table->string('currency');
            $table->string('title');
            $table->foreignId('confirmed_by')->nullable()->constrained('adminstrators');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
