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
            CREATE VIEW groups_view AS
            SELECT 
                groups.group_id,
                groups.name AS group_name,
                groups.student_count,
                groups.cohort_id,
                cohorts.name AS cohort_name,
                programs.program_id,
                schools.school_id,
                cohorts.code as acronym
            FROM groups
            INNER JOIN cohorts ON groups.cohort_id = cohorts.cohort_id
            INNER JOIN programs ON cohorts.program_id = programs.program_id
            INNER JOIN schools ON programs.school_id = schools.school_id
            WHERE cohorts.status = 'INSESSION'
            GROUP BY groups.group_id, group_name, student_count, cohort_id, cohort_name, program_id, school_id, acronym
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS groups_view');
    }
};
