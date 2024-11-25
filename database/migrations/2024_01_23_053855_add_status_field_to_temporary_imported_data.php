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
        Schema::table('temporary_imported_data', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0);
            $table->integer('candidate_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporary_imported_data', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('candidate_id');
        });
    }
};
