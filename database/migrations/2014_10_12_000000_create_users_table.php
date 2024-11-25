<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role_id')->default(0);
            $table->integer('parent_id')->default(0);
            $table->text('photo_link')->nullable();
            $table->string('google2fa_secret')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        // User::create(['name' => 'Admin','email' => 'admin@digipixel.sg','password' => Hash::make('password'),'role_id'=>'1','parent_id'=>'0', 'email_verified_at'=> now(), 'created_at' => now()]);
        //User::create(['name' => 'Admin','email' => 'admin@themesbrand1.com','password' => Hash::make('12345678'),'role_id'=>'1','parent_id'=>'0', 'email_verified_at'=> now(), 'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
