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
        Schema::create('unit_lecturers', function (Blueprint $table) {
            $table->increments('unit_lecturer_id');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('lecturer_id')->nullable();
            $table->unsignedInteger('cohort_id');
            $table->foreign('unit_id')->references('unit_id')->on('units')->onDelete('cascade');
            $table->foreign('lecturer_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('cohort_id')->references('cohort_id')->on('cohorts')->onDelete('cascade');
            $table->unique(['unit_id', 'lecturer_id', 'cohort_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_lecturers');
    }
};
