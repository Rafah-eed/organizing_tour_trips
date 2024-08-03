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
        Schema::create('actives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained();
            $table->foreignId('user_id')->constrained();// which is the guide
            $table->boolean('isOpened')->nullable()->default(false);
            $table->timestamp('start_date');
            $table->float('price');
            $table->boolean('has_paid')->nullable()->default(false);
            $table->boolean('reserve_statue')->nullable()->default(true);
            $table->timestamps();
            $table->unique(['trip_id', 'user_id', 'start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actives');
    }
};
