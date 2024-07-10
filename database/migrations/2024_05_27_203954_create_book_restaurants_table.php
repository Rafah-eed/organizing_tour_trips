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
        Schema::create('book_restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurants_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->date('date'); // Corrected method name to lowercase
            $table->integer('daysNum'); // Corrected method name to integer
            $table->float('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_restaurants');
    }
};
