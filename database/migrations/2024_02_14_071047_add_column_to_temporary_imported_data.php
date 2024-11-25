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
            $table->foreignId('assign_to')->nullable()->constrained('employees')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporary_imported_data', function (Blueprint $table) {
            $table->dropColumn('assign_to');
        });
    }
};
