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
            CREATE VIEW schools_view AS
            SELECT 
                schools.school_id,
                schools.name AS school_name,
                schools.slug AS school_slug,
                schools.created_at
            FROM schools
            INNER JOIN programs_view ON schools.school_id = programs_view.school_id
            GROUP BY schools.school_id, school_name, school_slug, created_at
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS schools_view');
    }
};
