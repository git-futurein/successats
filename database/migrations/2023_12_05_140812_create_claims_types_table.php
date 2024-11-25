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
        Schema::create('claims_types', function (Blueprint $table) {
            $table->id();
            $table->string('claimstype_code')->unique();
            $table->string('claimstype_desc');
            $table->double('claimstype_maxamt',8,2)->default(0);
            $table->integer('claimstype_seqno')->nullable();
            $table->integer('claimstype_status')->default(1);
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
        Schema::dropIfExists('claims_types');
    }
};
