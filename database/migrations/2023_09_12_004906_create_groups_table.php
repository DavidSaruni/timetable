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
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('group_id');
            $table->string('name');
            $table->unsignedInteger('student_count')->default(0);
            $table->unsignedInteger('cohort_id');
            $table->foreign('cohort_id')->references('cohort_id')->on('cohorts')->onDelete('cascade');
            $table->unique(['cohort_id', 'name']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
