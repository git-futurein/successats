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
        Schema::create('time_sheet_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('time_sheet_id')->constrained(); // Foreign key referencing the time_sheets table
            $table->enum('day', ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->string('lunch_time')->nullable();
            $table->string('isWork')->nullable();
            $table->string('isNextDay')->nullable();
            $table->string('ot_rate')->nullable();
            $table->integer('minimum')->nullable();
            $table->integer('allowance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_sheet_entries');
    }
};
