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
        Schema::create('candidate_working_hours', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id');
            $table->integer('timesheet_id');
            $table->string('schedul_type');
            $table->integer('schedul_day');
            $table->longText('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_working_hours');
    }
};
