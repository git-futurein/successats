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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_title')->unique();
            $table->integer('job_category_id')->nullable()->comment('get id from job category table');
            $table->string('job_salary')->nullable();
            $table->longText('remark')->nullable();
            $table->boolean('job_status')->default(1);
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->integer('co_owner_id')->nullable()->comment('get id from user table');
            $table->integer('client_id')->comment('get id from client table');
            $table->integer('person_incharge')->nullable()->comment('get id from user table');
            $table->integer('job_type_id')->nullable()->comment('get id from job type table');
            $table->longText('short_desc')->nullable();
            $table->date('job_added_date')->nullable();
            $table->integer('unit_no')->nullable();
            $table->string('display_address')->nullable();
            $table->string('job_link')->nullable();
            $table->longText('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_tag')->nullable();
            $table->longText('meta_description')->nullable();
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
        Schema::dropIfExists('jobs');
    }
};
