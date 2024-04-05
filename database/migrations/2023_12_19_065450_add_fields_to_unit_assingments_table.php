<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('unit_assingments', function (Blueprint $table) {
            $table->boolean('is_common')->default(false);
            $table->integer('common_value')->nullable();
            $table->integer('group_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_assingments', function (Blueprint $table) {
            $table->dropColumn('is_common');
            $table->dropColumn('common_value');
            $table->dropColumn('group_size');
        });
    }
};
