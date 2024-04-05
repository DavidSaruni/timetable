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
            CREATE VIEW lecturers_view AS
            SELECT 
                users.user_id,
                users.title,
                users.name AS lecturer_name,
                users.email,
                users.created_at
            FROM users
            INNER JOIN sessions_view ON users.user_id = sessions_view.lecturer_id
            GROUP BY users.user_id, title, lecturer_name, email, created_at
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS lecturers_view');
    }
};
