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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fatherName');
            $table->string('lastName');
            $table->string('phone', 10);
            $table->string('address');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('bankName');
            $table->string('accountNumber');
            $table->string('role',255);
            //$table->enum('role', ['admin', 'guide', 'user']); // 1 for admin and 2 for guide and 3 for user
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }

    public function getRememberToken()
    {
        return $this->remember_token= null;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }
};
