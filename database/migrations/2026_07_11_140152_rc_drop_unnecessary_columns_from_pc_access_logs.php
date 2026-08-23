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
        Schema::table('pc_access_logs', function (Blueprint $table) {
            // Dropping the hardware, session, metadata, and update timestamp columns
            $table->dropColumn([
                'pc_port',
                'device_uid',
                'session_id',
                'metadata',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->tinyInteger('pc_port')->nullable();
            $table->string('device_uid', 100)->nullable();
            $table->string('session_id', 64)->nullable();
            $table->json('metadata')->nullable();
        });
    }
};