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
        Schema::create('client_terms', function (Blueprint $table) {
            $table->id();
            $table->string('client_term_code')->unique();
            $table->string('client_term_desc');
            $table->integer('client_term_seqno')->nullable();
            $table->integer('client_term_status')->default(1);
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
        Schema::dropIfExists('client_terms');
    }
};
