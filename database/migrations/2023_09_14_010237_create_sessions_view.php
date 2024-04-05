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
            CREATE VIEW sessions_view AS
            SELECT 
                unit_assingments.unit_assingment_id,
                units.unit_id,
                units.name AS unit_name,
                units.code AS unit_code,
                units.department_id,
                units.has_lab,
                units.labtype_id,
                units.lab_alternative,
                units.lecturer_hours,
                units.lab_hours,
                units.is_full_day,
                unit_assingments.lecturer_id,
                cohorts.cohort_id,
                cohorts.name AS cohort_name,
                cohorts.code AS cohort_code,
                cohorts.program_id,
                groups.group_id,
                groups.name AS group_name,
                groups.student_count,
                unit_assingments.created_at
            FROM unit_assingments
            INNER JOIN units ON unit_assingments.unit_id = units.unit_id
            INNER JOIN cohorts ON unit_assingments.cohort_id = cohorts.cohort_id
            INNER JOIN groups ON cohorts.cohort_id = groups.cohort_id
            WHERE cohorts.status = 'INSESSION'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS sessions_view');
    }
};
