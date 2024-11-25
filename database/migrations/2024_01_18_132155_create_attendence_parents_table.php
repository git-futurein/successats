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
        Schema::create('attendence_parents', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id');
            $table->integer('company_id');
            $table->string('month_year');
            $table->string('invoice_no')->nullable();
            $table->boolean('isApproved')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendence_parents');
    }
};
