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
        Schema::create('units', function (Blueprint $table) {
            $table->increments('unit_id');
            $table->string('name');
            $table->string('code')->unique();
            $table->unsignedInteger('department_id');
            $table->boolean('has_lab')->default(false);
            $table->unsignedInteger('labtype_id')->nullable();
            $table->boolean('lab_alternative')->default(false);
            $table->unsignedInteger('lecturer_hours')->default(0);
            $table->unsignedInteger('lab_hours')->default(0);
            $table->boolean('is_full_day')->default(false);
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
            $table->foreign('labtype_id')->references('labtype_id')->on('labtypes')->onDelete('set null');
            $table->unique(['name', 'department_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
