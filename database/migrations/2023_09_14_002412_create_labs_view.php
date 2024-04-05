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
            CREATE VIEW labs_view AS
            SELECT 
                labs.lab_id,
                labs.lab_name, 
                labs.lab_capacity, 
                labs.lab_type,
                buildings.name, 
                schools.school_id,
                labs.created_at 
            FROM labs
            INNER JOIN buildings ON labs.building_id = buildings.building_id
            INNER JOIN school_buildings ON buildings.building_id = school_buildings.building_id
            INNER JOIN schools ON school_buildings.school_id = schools.school_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS labs_view');
    }
};
