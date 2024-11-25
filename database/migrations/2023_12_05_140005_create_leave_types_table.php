<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\LeaveType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('leavetype_code')->unique();
            $table->integer('leavetype_block')->nullable();
            $table->string('leavetype_desc')->nullable();
            $table->integer('leavetype_default')->nullable();
            $table->integer('leavetype_bringover')->nullable();
            $table->integer('leavetype_custom_field')->nullable();
            $table->integer('leavetype_seqno')->nullable();
            $table->integer('leavetype_status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('modify_by')->nullable();
            $table->timestamps();
        });
    }
    //LeaveType::create(['leavetype_code' => 'Annual Leave','email' => 'admin@themesbrand.com','password' => Hash::make('12345678'),'role_id'=>'1','parent_id'=>'0', 'email_verified_at'=> now(), 'created_at' => now()]);
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
