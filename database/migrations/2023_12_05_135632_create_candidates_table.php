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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_outlet_id')->default(0)->comment('Link with outlet table');
            $table->string('candidate_code')->nullable();
            $table->string('candidate_name')->nullable();
            $table->string('candidate_home_phone')->nullable();
            $table->string('candidate_email')->nullable();
            $table->integer('passtypes_id')->nullable()->comment('link to pass type table');
            $table->string('candidate_nric')->nullable();
            $table->string('candidate_mobile')->nullable();
            $table->string('candidate_tel')->nullable();
            $table->date('candidate_birthdate')->nullable();
            $table->date('candidate_joindate')->nullable();
            $table->date('candidate_confirmationdate')->nullable();
            $table->date('candidate_tc_date')->nullable();
            $table->integer('children_no')->nullable()->comment('general info end');
            $table->double('candidate_height', 8, 2)->default(0);
            $table->longText('avatar')->nullable();
            $table->double('candidate_weight', 8, 2)->default(0)->comment('general info end');


            $table->integer('candidate_type')->default(0)->comment('0=Candidate, 1=Walk in candidate');
            $table->integer('users_id')->nullable()->comment('link to user table');
            $table->integer('leave_aprv1_users_id')->nullable();
            $table->integer('leave_aprv2_users_id')->nullable();
            $table->integer('leave_aprv3_users_id')->nullable();
            $table->integer('claims_aprv1_users_id')->nullable();
            $table->integer('claims_aprv2_id')->nullable();
            $table->integer('claims_aprv3_users_id')->nullable();

            $table->string('candidate_n_level')->nullable()->comment('Skill info start');
            $table->string('candidate_o_level')->nullable();
            $table->string('candidate_a_level')->nullable();
            $table->string('candidate_diploma')->nullable();
            $table->string('candidate_degree')->nullable();
            $table->string('candidate_other')->nullable();
            $table->string('candidate_written')->nullable();
            $table->string('candidate_spocken')->nullable()->comment('Skill info end');

            $table->integer('paymodes_id')->nullable()->comment('link to paymode table');
            $table->string('candidate_bank')->nullable();
            $table->string('candidate_bank_acc_no')->nullable();
            $table->string('candidate_bank_acc_title')->nullable();

            $table->string('candidate_street')->nullable()->comment('candidate address start');
            $table->string('candidate_unit_number')->nullable();
            $table->string('candidate_postal_code')->nullable();
            $table->string('candidate_street2')->nullable();
            $table->string('candidate_unit_number2')->nullable();
            $table->string('candidate_postal_code2')->nullable()->comment('candidate address end');

            $table->string('candidate_emr_contact')->nullable()->comment('Emergency contact info start');
            $table->string('candidate_emr_relation')->nullable();
            $table->string('candidate_emr_phone1')->nullable();
            $table->string('candidate_emr_phone2')->nullable();
            $table->string('candidate_emr_address')->nullable();
            $table->string('candidate_emr_remarks')->nullable()->comment('Emergency contact info end');

            $table->string('candidate_referee_name1')->nullable()->comment('referee info start');
            $table->string('candidate_referee_occupation1')->nullable();
            $table->string('candidate_referee_year_know1')->nullable();
            $table->string('candidate_referee_contact1')->nullable();
            $table->string('candidate_referee_name2')->nullable();
            $table->string('candidate_referee_occupation2')->nullable();
            $table->string('candidate_referee_year_know2')->nullable();
            $table->string('candidate_referee_contact2')->nullable();
            $table->integer('candidate_referee_present_employer')->default(0);
            $table->integer('candidate_referee_previous_employer')->default(0)->comment('referee info end');

            $table->integer('candidate_dec_bankrupt')->default(0)->comment('declaration info start');
            $table->string('candidate_dec_bankrupt_details')->nullable();
            $table->integer('candidate_dec_physical')->default(0);
            $table->string('candidate_dec_physical_details')->nullable();
            $table->integer('candidate_dec_lt_medical')->default(0);
            $table->string('candidate_dec_lt_medical_details')->nullable();
            $table->integer('candidate_dec_law')->default(0);
            $table->string('candidate_dec_law_details')->nullable();
            $table->integer('candidate_dec_warning')->default(0);
            $table->string('candidate_dec_warning_details')->nullable();
            $table->integer('candidate_dec_applied')->default(0);
            $table->string('candidate_dec_applied_details')->nullable()->comment('declaration info end');

            $table->integer('races_id')->nullable()->comment('link to race table');
            $table->integer('religions_id')->nullable()->comment('link to religion table');
            $table->integer('dbsexes_id')->nullable()->comment('link to dbsex table');
            $table->integer('marital_statuses_id')->nullable()->comment('link to marital status table');
            $table->integer('clients_id')->nullable()->comment('link to client table');
            $table->integer('jobs_id')->nullable()->comment('link to jobs table');
            $table->integer('candidate_status')->default(1);
            $table->integer('candidate_isBlocked')->default(0)->commnet('delete mark- 0=Active or functional data, 1=Blocked  ');
            $table->integer('candidate_isDeleted')->default(0)->commnet('delete mark- 0=Active or functional data, 1=not functional data  ');
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
        Schema::dropIfExists('candidates');
    }
};
