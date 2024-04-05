<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timetable_instances', function (Blueprint $table) {
            $table->increments('timetable_instance_id');
            $table->string('name');
            $table->string('status')->default('queued')->comment('Generating, Done, queued');
            $table->string('table_prefix')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $instances = DB::table('timetable_instances')->get();
        foreach ($instances as $instance) {
            Schema::dropIfExists($instance->table_prefix.'_lecturers');
            Schema::dropIfExists($instance->table_prefix.'_programs');
            Schema::dropIfExists($instance->table_prefix.'_schools');
            Schema::dropIfExists($instance->table_prefix.'_labs');
            Schema::dropIfExists($instance->table_prefix.'_lecturerooms');
            Schema::dropIfExists($instance->table_prefix.'_locations');
            Schema::dropIfExists($instance->table_prefix.'_sessions');
            Schema::dropIfExists($instance->table_prefix.'_groups');
            Schema::dropIfExists($instance->table_prefix.'_group_schema');
            Schema::dropIfExists($instance->table_prefix.'_lecturer_preferred_times');
            Schema::dropIfExists($instance->table_prefix.'_unit_preferred_times');
            Schema::dropIfExists($instance->table_prefix.'_unit_preffered_rooms');
            Schema::dropIfExists($instance->table_prefix.'_unit_preffered_labs');
        }
        Schema::dropIfExists('timetable_instances');
    }
};
