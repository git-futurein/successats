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
        Schema::create('candidate_payrolls', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id');
            $table->string('job_type');
            $table->string('admin_fee_monthly')->nullable();
            $table->integer('client_company');
            $table->string('invoice_rate')->nullable();
            $table->string('daily_rate')->nullable();
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->string('wica')->nullable();
            $table->string('university')->nullable();
            $table->string('cost_center')->nullable();
            $table->string('working_hour')->nullable();
            $table->date('start_date');
            $table->date('sales_period')->nullable();
            $table->integer('invoice_no')->nullable();
            $table->integer('charge')->nullable();
            $table->integer('close_by1')->nullable();
            $table->integer('close_by2')->nullable();
            $table->integer('close_by3')->nullable();
            $table->boolean('cut_off')->nullable();
            $table->string('recruitment_fee')->nullable();
            $table->string('admin_fee_daily')->nullable();
            $table->integer('ar_no')->nullable();
            $table->string('salary')->nullable();
            $table->string('daily_rate_night_shift')->nullable();
            $table->string('programme')->nullable();
            $table->string('hourly_rate')->nullable();
            $table->string('insurance_fee')->nullable();
            $table->string('team_lead')->nullable();
            $table->string('allowance')->nullable();
            $table->string('probation_period')->nullable();
            $table->date('end_date')->nullable();
            $table->string('guarantee_period')->nullable();
            $table->string('po_no')->nullable();
            $table->boolean('contribute_cpf')->nullable();
            $table->integer('close_rate1')->nullable();
            $table->integer('close_rate2')->nullable();
            $table->integer('close_rate3')->nullable();
            $table->longText('payroll_remark')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modify_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_payrolls');
    }
};
