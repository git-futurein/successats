<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_code')->nullable();
            $table->string('client_name')->nullable()->comment('company name');
            $table->integer('industry_types_id')->nullable()->comment('link to industry_types table');
            $table->string('client_attention_person')->nullable();
            $table->string('client_attention_designation')->nullable();
            $table->string('client_designation')->nullable();
            $table->string('client_attention_phone')->nullable();
            $table->string('client_contact_person')->nullable();
            $table->string('client_contact_number')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_fax')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_street')->nullable();
            $table->string('client_unit_number')->nullable();
            $table->string('client_postal_code')->nullable();
            $table->string('client_website')->nullable();

            $table->integer('employees_id')->nullable()->comment('sales person employee id, link to employee table');
            $table->integer('users_id')->nullable()->comment('sales person user id, link to user table');

            $table->integer('payroll_employees_id')->nullable()->comment('payroll manager/incharge employee id, link to employee table');
            $table->integer('payroll_users_id')->nullable()->comment('payroll manager/incharge user id, link to user table');

            $table->integer('tnc_templates_id')->nullable()->comment('link to tnc_templates table');
            $table->date('tnc_renewal_date')->nullable();
            $table->integer('client_terms_id')->nullable()->comment('link to client_terms table');
            $table->string('client_remarks')->nullable();

            $table->integer('clients_seqno')->nullable();
            $table->integer('clients_status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('modify_by')->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('employees')->onDelete('restrict');
            $table->foreignId('team_leader_id')->nullable()->constrained('employees')->onDelete('restrict');
            $table->foreignId('consultant_id')->nullable()->constrained('employees')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
