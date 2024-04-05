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
        Schema::create('unit_preferred_labs', function (Blueprint $table) {
            $table->increments('unit_preferred_lab_id');
            $table->unsignedInteger('unit_preference_id');
            $table->unsignedInteger('lab_id');
            $table->foreign('unit_preference_id')->references('unit_preference_id')->on('unit_preferences')->onDelete('cascade');
            $table->foreign('lab_id')->references('lab_id')->on('labs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_preferred_labs');
    }
};
