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
        Schema::create('unit_preferred_rooms', function (Blueprint $table) {
            $table->increments('unit_preferred_room_id');
            $table->unsignedInteger('unit_preference_id');
            $table->unsignedInteger('lecture_room_id');
            $table->foreign('unit_preference_id')->references('unit_preference_id')->on('unit_preferences')->onDelete('cascade');
            $table->foreign('lecture_room_id')->references('lecture_room_id')->on('lecture_rooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_preferred_rooms');
    }
};
