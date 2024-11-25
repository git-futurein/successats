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
        Schema::create('candidate_remark_shortlists', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_remark_id')->nullable();
            $table->double('salary')->nullable();
            $table->string('depertment')->nullable();
            $table->double('hourly_rate')->nullable();
            $table->double('placement_recruitment_fee')->nullable();
            $table->double('admin_fee')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('job_title')->nullable();
            $table->string('reminder_period')->nullable();
            $table->integer('job_type')->nullable();
            $table->time('contact_signing_time')->nullable();
            $table->date('contact_signing_date')->nullable();
            $table->integer('probition_period')->nullable();
            $table->date('last_day')->nullable();
            $table->date('email_notice_date')->nullable();
            $table->time('email_notice_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_remark_shortlists');
    }
};
