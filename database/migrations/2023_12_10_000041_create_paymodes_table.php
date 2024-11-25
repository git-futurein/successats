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
        Schema::create('paymodes', function (Blueprint $table) {
            $table->id();
            $table->string('paymode_code')->unique();
            $table->string('paymode_desc');
            $table->integer('paymode_seqno')->nullable();
            $table->integer('paymode_status')->default(1);
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
        Schema::dropIfExists('paymodes');
    }
};
