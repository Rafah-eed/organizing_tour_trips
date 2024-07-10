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
        Schema::create('is_opened', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->Integer('trip_id');
            $table->Integer('guide_id');
            $table->boolean('opened')->nullable()->default(false);
            $table->Date('date');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('is_opened');
    }
};
