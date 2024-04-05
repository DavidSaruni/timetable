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
        Schema::create('unit_assingments', function (Blueprint $table) {
            $table->increments('unit_assingment_id');
            $table->integer('unit_id')->unsigned();
            $table->integer('lecturer_id')->unsigned();
            $table->integer('cohort_id')->unsigned();
            $table->foreign('unit_id')->references('unit_id')->on('units')->onDelete('cascade');
            $table->foreign('lecturer_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('cohort_id')->references('cohort_id')->on('cohorts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_assingments');
    }
};
