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
        Schema::create('jobcategories', function (Blueprint $table) {
            $table->id();
            $table->string('jobcategory_name');
            $table->integer('jobcategory_parent')->nullable();
            $table->integer('jobcategory_seqno')->nullable();
            $table->integer('jobcategory_status')->default(1);
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
        Schema::dropIfExists('jobcategories');
    }
};
