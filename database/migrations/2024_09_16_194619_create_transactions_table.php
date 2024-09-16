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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->string('event_type');
            $table->string('tx_ref')->unique();
            $table->string('mode');
            $table->string('type');
            $table->string('status');
            $table->integer('number_of_attempts');
            $table->string('reference')->unique();
            $table->string('currency');
            $table->decimal('amount', 10, 2);
            $table->decimal('charges', 10, 2);

            // Customization fields
            $table->string('customization_title');
            $table->string('customization_description');
            $table->string('customization_logo')->nullable();

            // Meta fields
            $table->string('meta_uuid');
            $table->text('meta_response');

            // Authorization fields
            $table->string('authorization_channel');
            $table->string('authorization_card_number')->nullable();
            $table->string('authorization_expiry')->nullable();
            $table->string('authorization_brand')->nullable();
            $table->string('authorization_provider');
            $table->string('authorization_mobile_number');
            $table->timestamp('authorization_completed_at')->nullable();

            // Customer fields
            $table->string('customer_email');
            $table->string('customer_first_name');
            $table->string('customer_last_name');

            // Logs fields - you can store logs as JSON in a single column
            $table->json('logs')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
