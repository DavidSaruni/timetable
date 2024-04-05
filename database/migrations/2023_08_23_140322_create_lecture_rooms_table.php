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
        Schema::create('lecture_rooms', function (Blueprint $table) {
            $table->increments('lecture_room_id');
            $table->string('lecture_room_name');
            $table->integer('building_id')->unsigned();
            $table->integer('lecture_room_capacity');
            $table->foreign('building_id')->references('building_id')->on('buildings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_rooms');
    }
};
