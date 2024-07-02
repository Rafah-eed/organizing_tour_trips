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
            $table->bigInteger('restaurants_id');
            $table->bigInteger('user_id');
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
