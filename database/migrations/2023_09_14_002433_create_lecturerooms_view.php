<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW lecturerooms_view AS
            SELECT 
                lecture_rooms.lecture_room_id, 
                lecture_rooms.lecture_room_name, 
                lecture_rooms.lecture_room_capacity, 
                buildings.name, 
                schools.school_id,
                lecture_rooms.created_at
            FROM lecture_rooms
            INNER JOIN buildings ON lecture_rooms.building_id = buildings.building_id
            INNER JOIN school_buildings ON buildings.building_id = school_buildings.building_id
            INNER JOIN schools ON school_buildings.school_id = schools.school_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS lecturerooms_view');
    }
};
