<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->unique('session_id');
        });


        Schema::table('pc_app_usage', function (Blueprint $table) {
            $table->foreign('session_id')
                    ->references('session_id')
                    ->on('pc_access_logs')
                    ->onDelete('cascade'); 
        });
    }

    public function down(): void
    {
        Schema::table('pc_app_usage', function (Blueprint $table) {
            $table->dropForeign(['session_id']);
        });

        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->dropUnique(['session_id']);
        });
    }
};