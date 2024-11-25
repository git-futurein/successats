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
        Schema::create('paybanks', function (Blueprint $table) {
            $table->id();
            $table->string('paybank_code')->unique();
            $table->string('paybank_no');
            $table->string('paybank_desc');
            $table->string('paybank_swift');
            $table->integer('paybank_seqno')->nullable();
            $table->integer('paybank_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paybanks');
    }
};
