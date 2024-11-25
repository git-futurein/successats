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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->date('date');
            $table->string('day');
            $table->string('in_time')->nullable();
            $table->string('out_time')->nullable();
            $table->string('next_day')->default(0);
            $table->string('lunch_hour')->default(0);
            $table->string('total_hour_min')->default(0);
            $table->string('normal_hour_min')->default(0);
            $table->string('ot_hour_min')->default(0);
            $table->tinyInteger('ot_calculation')->default(0);
            $table->tinyInteger('ot_edit')->default(0);
            $table->tinyInteger('work')->default(0);
            $table->tinyInteger('ph')->default(0);
            $table->tinyInteger('ph_pay')->default(0);
            $table->text('remark')->nullable();
            $table->string('type_of_leave')->nullable();
            $table->string('leave_day')->nullable();
            $table->string('leave_attachment')->nullable();
            $table->string('claim_attachment')->nullable();
            $table->string('type_of_reimbursement')->nullable();
            $table->decimal('amount_of_reimbursement', 10, 2)->nullable();
            $table->timestamps();


            // candidate_id, company_id, invoice_no, date, day, in_time, out_time, next_day, lunch_hour, total_hour_min, normal_hour_min, ot_hour_min, ot_calculation, ot_edit, work, ph, ph_pay, remark, type_of_leave, leave_day, leave_attachment, claim_attachment, type_of_reimbursement, amount_of_reimbursement,
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
