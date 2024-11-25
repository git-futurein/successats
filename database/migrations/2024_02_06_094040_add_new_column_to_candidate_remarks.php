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
        Schema::table('candidate_remarks', function (Blueprint $table) {
            $table->date('email_notice_date')->nullable();
            $table->string('ar_no')->nullable();
            $table->integer('assign_to')->nullable();
            $table->integer('client_company')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_remarks', function (Blueprint $table) {
            $table->dropColumn('email_notice_date');
            $table->dropColumn('ar_no');
            $table->dropColumn('assign_to');
            $table->dropColumn('client_company');
        });
    }
};
