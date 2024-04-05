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
        Schema::create('school_full_day_locations', function (Blueprint $table) {
            $table->increments('school_full_day_location_id');
            $table->integer('school_id')->unsigned();
            $table->integer('full_day_location_id')->unsigned();
            $table->foreign('school_id')->references('school_id')->on('schools')->onDelete('cascade');
            $table->foreign('full_day_location_id')->references('full_day_location_id')->on('full_day_locations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_full_day_locations');
    }
};
