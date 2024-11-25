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
        Schema::create('leave_approveds', function (Blueprint $table) {
            $table->id();
            $table->integer('leaves_id');
            $table->timestamp('level_approve_date')->nullable();
            $table->integer('leave_approveds_Status')->nullable()->comment('0-Pending,1-Approved,2-Rejected');
            $table->integer('supervisor_employees_id')->nullable();
            $table->string('extraNote')->nullable();
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
        Schema::dropIfExists('leave_approveds');
    }
};
