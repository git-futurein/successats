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
        Schema::create('candidate_families', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id');
            $table->string('name');
            $table->integer('age');
            $table->string('relationship');
            $table->string('occupation');
            $table->string('contact_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_families');
    }
};
