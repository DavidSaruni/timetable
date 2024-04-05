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
            CREATE VIEW programs_view AS
            SELECT 
                programs.program_id,
                programs.name AS program_name,
                programs.code AS program_code,
                programs.school_id,
                programs.created_at
            FROM programs
            INNER JOIN sessions_view ON programs.program_id = sessions_view.program_id
            GROUP BY programs.program_id, program_name, program_code, school_id, created_at
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS programs_view');
    }
};
