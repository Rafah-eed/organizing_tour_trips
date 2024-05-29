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
            $table->bigInteger('id_restaurants');
            $table->bigInteger('id_user');
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
