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
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id')->nullable();
            $table->integer('manager_id')->nullable();
            $table->integer('teamleader_id')->nullable();
            $table->integer('consultent_id')->nullable();
            $table->integer('remark_id')->default(0)->comment('Previous Flowup Id');
            $table->dateTime('move_time')->nullable();
            $table->integer('follow_day')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->integer('insert_by')->nullable();
            $table->integer('update_by')->nullable();
            $table->dateTime('insert_date_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboards');
    }
};
