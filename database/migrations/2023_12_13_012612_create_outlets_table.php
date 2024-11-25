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
        Schema::create('outlets', function (Blueprint $table) {
            $table->id();
            $table->string('outlet_name');
            $table->string('outlet_tel')->nullable();
            $table->string('outlet_fax')->nullable();
            $table->string('outlet_email')->nullable();
            $table->string('outlet_website')->nullable();
            $table->string('outlet_gstno')->nullable();
            $table->string('outlet_gstpercent')->nullable();
            $table->string('outlet_license')->nullable();
            $table->string('outlet_description')->nullable();
            $table->string('outlet_address')->nullable();
            $table->integer('countries_id')->nullable();
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
        Schema::dropIfExists('outlets');
    }
};
