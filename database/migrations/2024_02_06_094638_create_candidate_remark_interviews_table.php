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
        Schema::create('candidate_remark_interviews', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_remark_id')->nullable();
            $table->date('interview_date')->nullable();
            $table->time('interview_time')->nullable();
            $table->string('interview_by')->nullable();
            $table->string('interview_position')->nullable();
            $table->string('interview_company')->nullable();
            $table->string('expected_salary')->nullable();
            $table->string('job_offer_salary')->nullable();
            $table->string('attend_interview')->nullable();
            $table->date('available_date')->nullable();
            $table->string('receive_job_offer')->nullable();
            $table->date('email_notice_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_remark_interviews');
    }
};
