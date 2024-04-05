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
        Schema::create('labs', function (Blueprint $table) {
            $table->increments('lab_id');
            $table->string('lab_name');
            $table->integer('lab_type')->unsigned();
            $table->integer('building_id')->unsigned();
            $table->integer('lab_capacity');
            $table->foreign('lab_type')->references('labtype_id')->on('labtypes')->onDelete('cascade');
            $table->foreign('building_id')->references('building_id')->on('buildings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs');
    }
};
