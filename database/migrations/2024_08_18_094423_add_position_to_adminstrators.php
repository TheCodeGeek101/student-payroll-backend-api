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
        Schema::table('adminstrators', function (Blueprint $table) {
            $table->enum('position', [
                'head_teacher',
                'deputy_head_teacher',
                'bursar',
                'assistant_bursar',
                'secretary',
                'it_officer'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adminstrators', function (Blueprint $table) {
            //
        });
    }
};
