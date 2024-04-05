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
        Schema::create('cohorts', function (Blueprint $table) {
            $table->increments('cohort_id');
            $table->string('name');
            $table->string('code');
            $table->unsignedInteger('program_id');
            $table->integer('student_count')->default(0);
            $table->enum('status', ['INSESSION', 'NOTINSESSION'])->default('NOTINSESSION');
            $table->foreign('program_id')->references('program_id')->on('programs')->onDelete('cascade');
            $table->unique(['program_id', 'code']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cohorts');
    }
};
