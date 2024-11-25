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
        Schema::create('tnc_templates', function (Blueprint $table) {
            $table->id();
            $table->string('tnc_template_code')->unique();
            $table->string('tnc_template_desc');
            $table->integer('tnc_template_isDefault')->default(0);
            $table->string('tnc_template_file_path')->nullable();
            $table->integer('tnc_template_seqno')->nullable();
            $table->integer('tnc_template_status')->default(1);
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
        Schema::dropIfExists('tnc_templates');
    }
};
