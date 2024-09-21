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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable(); // Optional for recurring events
            $table->softDeletes(); // Add soft delete functionality
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
