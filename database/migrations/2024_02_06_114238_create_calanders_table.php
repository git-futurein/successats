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
        Schema::create('calanders', function (Blueprint $table) {
            $table->id();
            $table->integer('manager_id')->nullable();
            $table->integer('teamleader_id')->nullable();
            $table->integer('consultant_id')->nullable();
            $table->integer('candidate_remark_id')->nullable();
            $table->integer('candidate_remark_shortlist_id')->nullable();
            $table->string('title');
            $table->tinyInteger('status')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calanders');
    }
};
