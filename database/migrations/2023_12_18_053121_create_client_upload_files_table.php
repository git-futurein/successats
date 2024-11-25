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
        Schema::create('client_upload_files', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('file_path');
            $table->integer('file_type_id');
            $table->integer('file_type_for')->default(1)->comment('1=Candidate,0=client');
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
        Schema::dropIfExists('client_upload_files');
    }
};
