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
        Schema::create('employee_salary_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->date('date');
            $table->float('salary_amount');
            $table->integer('no_of_working_day')->nullable();
            $table->float('hourly_salary_rate')->nullable();
            $table->float('hourly_overtime_rate')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('employee_salary_infos');
    }
};
