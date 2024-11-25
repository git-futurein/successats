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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_outlet_id')->default(1)->comment('Link with outlet table');
            $table->string('employee_code')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('employee_phone')->nullable();
            $table->string('employee_email')->nullable();
            $table->integer('passtypes_id')->nullable()->comment('link to pass type table');
            $table->string('employee_nric')->nullable();
            $table->date('employee_birthdate')->nullable();
            $table->integer('employee_numberofchildren')->nullable();

            $table->integer('users_id')->nullable()->comment('link to user table');
            $table->integer('roles_id')->nullable()->comment('link to role table');
            $table->integer('manager_users_id')->nullable();
            $table->integer('team_leader_users_id')->nullable();
            $table->string('employee_shrc')->nullable()->comment('only for payroll user-roll');
            $table->string('employee_defination')->nullable();
            $table->string('employee_avater')->nullable();

            $table->integer('races_id')->nullable()->comment('link to race table');
            $table->integer('religions_id')->nullable()->comment('link to religion table');
            $table->integer('dbsexes_id')->nullable()->comment('link to dbsex table');
            $table->integer('marital_statuses_id')->nullable()->comment('link to marital status table');
            $table->integer('clients_id')->nullable()->comment('link to client table');
            $table->integer('employee_status')->default(1);


            $table->integer('is_payroll_enable')->default(0)->comment('1=salary entry enable, 0=salary entry disable');
            $table->integer('is_cpf_enable')->default(0);

            // General Info Ends

            $table->string('employee_postal_code')->nullable();
            $table->string('employee_unit_number')->nullable();
            $table->string('employee_street')->nullable()->comment('employee address start');
            $table->string('employee_postal_code2')->nullable()->comment('employee address end');
            $table->string('employee_unit_number2')->nullable();
            $table->string('employee_street2')->nullable();

            $table->string('employee_emr_contact')->nullable()->comment('Emergency contact info start');
            $table->string('employee_emr_relation')->nullable();
            $table->string('employee_emr_phone1')->nullable();
            $table->string('employee_emr_phone2')->nullable();
            $table->string('employee_emr_address')->nullable();
            $table->string('employee_emr_remarks')->nullable()->comment('Emergency contact info end');
            // Contact Info
            $table->integer('departments_id')->nullable()->comment('link to depertment table');
            $table->integer('designations_id')->nullable()->comment('link to designation table');
            $table->string('employee_work_time_start')->nullable();
            $table->string('employee_work_time_end')->nullable();
            $table->date('employee_joindate')->nullable();
            $table->integer('employee_probation')->nullable();
            $table->date('employee_confirmationdate')->nullable();
            $table->integer('employee_extentionprobation')->nullable();
            $table->date('employee_prdate')->nullable();
            $table->date('employee_resigndate')->nullable();
            $table->string('employee_resignreason')->nullable();
            $table->integer('leave_aprv1_users_id')->nullable();
            $table->integer('leave_aprv2_users_id')->nullable();
            $table->integer('leave_aprv3_users_id')->nullable();
            $table->integer('claims_aprv1_users_id')->nullable();
            $table->integer('claims_aprv2_usersid')->nullable();
            $table->integer('claims_aprv3_users_id')->nullable();
            // Job Info Ends

            $table->integer('paymodes_id')->nullable()->comment('link to paymode table');
            $table->string('employee_bank')->nullable();
            $table->string('employee_bank_acc_no')->nullable();
            $table->string('employee_bank_acc_title')->nullable();
            // Bank Info Ends

            $table->string('employee_fw_permit_number')->nullable()->comment('Foreign Worker info Start');
            $table->date('employee_fw_application_date')->nullable();
            $table->date('employee_fw_issue_date')->nullable();
            $table->date('employee_fw_arrival_date')->nullable();
            $table->date('employee_fw_renewal_date')->nullable();
            $table->float('employee_fw_levy_amount')->nullable()->default(0)->comment('Foreign Worker info end');
            // Foreign worker ends
            $table->integer('employee_isovertime')->default(1);
            $table->integer('employee_isDeleted')->default(0)->commnet('delete mark- 0=Active or functional data, 1=not functional data  ');
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
        Schema::dropIfExists('employees');
    }
};
