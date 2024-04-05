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
        Schema::create('lecturer_preferred_times', function (Blueprint $table) {
            $table->increments('lecturer_preferred_time_id');
            $table->unsignedInteger('lecturer_id');
            $table->unsignedInteger('day');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->foreign('lecturer_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_preferred_times');
    }
};
