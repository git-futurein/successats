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
        Schema::create('deshboard_menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_group')->nullable();
            $table->string('menu_icon')->nullable();
            $table->string('menu_name')->unique();
            $table->string('slug')->nullable();
            $table->string('menu_path')->nullable();
            $table->integer('menu_perent')->nullable();
            $table->integer('menu_short')->nullable();
            $table->integer('userRole_id')->nullable();
            $table->integer('menu_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modify_by')->nullable();
            $table->string('exception')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deshboard_menus');
    }
};
