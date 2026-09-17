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
        
        Schema::table('devices', function (Blueprint $table) {
            $table->renameColumn('name', 'workstation_name');
        });

        
        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->renameColumn('workstation_id', 'device_id');
        });

        
        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback instructions in case you need to reverse this
        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->dropForeign(['device_id']);
            $table->renameColumn('device_id', 'workstation_id');
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->renameColumn('workstation_name', 'name');
        });
    }
};
