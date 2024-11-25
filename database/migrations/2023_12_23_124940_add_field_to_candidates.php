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
        Schema::table('candidates', function (Blueprint $table) {
            $table->integer('nationality_id')->nullable();
            $table->date('nationality_date_of_issue')->nullable();
            $table->integer('manager_id')->nullable();
            $table->integer('team_leader_id')->nullable();
            $table->integer('rc_id')->nullable();
            $table->time('interview_time')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('interview_expected_salary')->nullable();
            $table->string('interview_position')->nullable();
            $table->string('interview_received_job_offer')->nullable();
            $table->string('interviewEmailNoticeDate')->nullable();
            $table->date('interview_date')->nullable();
            $table->string('interview_by')->nullable();
            $table->string('inteview_job_offer_salary')->nullable();
            $table->string('attendInterview')->nullable();
            $table->date('available_date')->nullable();
            $table->time('interviewEmailNoticeTime')->nullable();
            $table->integer('client_company')->nullable();
            $table->integer('client_ar_no')->nullable();
            $table->integer('shortlistClientCompany')->nullable();
            $table->string('shortlistDepartment')->nullable();
            $table->string('shortlistPlacement')->nullable();
            $table->string('shortlistJobTitle')->nullable();
            $table->integer('shortlistJobType')->nullable();
            $table->string('shortlistProbationPeriod')->nullable();
            $table->date('shortlistContractSigningDate')->nullable();
            $table->date('shortlistEmailNoticeDate')->nullable();
            $table->string('shortlistSalary')->nullable();
            $table->string('shortlistArNo')->nullable();
            $table->string('shortlistHourlyRate')->nullable();
            $table->string('shortlistAdminFee')->nullable();
            $table->date('shortlistStartDate')->nullable();
            $table->string('shortlistReminderPeriod')->nullable();
            $table->time('shortlistContractSigningTime')->nullable();
            $table->date('shortlistLastDay')->nullable();
            $table->time('shortlistEmailNoticeTime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            //
        });
    }
};
