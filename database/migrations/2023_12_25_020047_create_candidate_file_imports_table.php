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
        Schema::create('candidate_file_imports', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable();
            $table->string('file_email')->nullable();
            $table->longText('file_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_file_imports');
    }
};
