<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /*
     * TODO :
     * MAKE A FUNCTION TO COUNT THE NUMBER OF TRIPS THE USER HAS GONE IN THE USER CONTROLLER
     */
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
            $table->enum('role', ['admin', 'guide', 'user']); // 1 for admin and 2 for guide and 3 for user
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
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
};
