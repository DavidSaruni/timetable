<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW unit_preferred_rooms_view AS
            SELECT 
                unit_preferences.unit_id,
                unit_preferred_rooms.lecture_room_id
            FROM unit_preferences
            INNER JOIN unit_preferred_rooms ON unit_preferences.unit_preference_id = unit_preferred_rooms.unit_preference_id
            GROUP BY unit_preferences.unit_id, unit_preferred_rooms.lecture_room_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS unit_preferred_rooms_view');
    }
};
