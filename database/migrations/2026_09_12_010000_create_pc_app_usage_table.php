<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * In-session foreground app usage reported by the desktop kiosk.
     * Rows are per (session, app) and easily grouped for the dashboards.
     */
    public function up(): void
    {
        Schema::create('pc_app_usage', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 64)->nullable()->index();
            $table->string('rfid_uid', 100)->nullable();
            $table->string('app_name', 100);
            $table->unsignedInteger('seconds');
            $table->timestamp('occurred_at');
            $table->timestamps();
            $table->index(['app_name', 'occurred_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pc_app_usage');
    }
};