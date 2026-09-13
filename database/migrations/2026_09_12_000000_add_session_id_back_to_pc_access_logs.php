<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Restore the nullable session_id column dropped by
     * 2026_07_11_140152_rc_drop_unnecessary_columns_from_pc_access_logs
     * so time_in / time_out rows can be paired again.
     */
    public function up(): void
    {
        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->string('session_id', 64)->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->dropColumn('session_id');
        });
    }
};