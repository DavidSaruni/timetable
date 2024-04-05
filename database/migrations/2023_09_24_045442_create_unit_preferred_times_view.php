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
            CREATE VIEW unit_preferred_times_view AS
            SELECT 
                unit_preferences.unit_id,
                school_periods.day_of_week,
                school_periods.start_time,
                school_periods.end_time
            FROM unit_preferences
            INNER JOIN unit_preferred_periods ON unit_preferences.unit_preference_id = unit_preferred_periods.unit_preference_id
            INNER JOIN school_periods ON unit_preferred_periods.school_period_id = school_periods.school_period_id
            GROUP BY unit_preferences.unit_id, school_periods.day_of_week, school_periods.start_time, school_periods.end_time
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS unit_preferred_times_view');
    }
};
