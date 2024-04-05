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
            CREATE VIEW locations_view AS
            SELECT 
                full_day_locations.full_day_location_id, 
                full_day_locations.name, 
                full_day_locations.days, 
                full_day_locations.cohorts, 
                school_full_day_locations.school_id
            FROM full_day_locations
            INNER JOIN school_full_day_locations ON full_day_locations.full_day_location_id = school_full_day_locations.full_day_location_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS locations_view');
    }
};
