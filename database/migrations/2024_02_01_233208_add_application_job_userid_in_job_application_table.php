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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->foreignId('team_leader_id')->nullable()->constrained('employees')->onDelete('restrict');
            $table->foreignId('jobcreator_id')->nullable()->constrained('employees')->onDelete('restrict');
            $table->foreignId('job_ids')->nullable()->constrained('jobs')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn('team_leader_id');
            $table->dropColumn('jobcreator_id');
            $table->dropColumn('job_ids');
        });
    }
};
