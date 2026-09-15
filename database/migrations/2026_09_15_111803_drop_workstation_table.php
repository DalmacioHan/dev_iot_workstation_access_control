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
            $table->dropForeign(['workstation_id']);
        });

        Schema::dropIfExists('workstations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('workstations', function (Blueprint $table) {
            $table->id();
            $table->string('pc_code', 50)->unique();
            $table->boolean('is_active')->default(true);
            $table->foreignId('device_id')
                ->nullable()
                ->unique()
                ->constrained('devices')
                ->nullOnDelete();
            $table->timestamps();
        });

        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->foreign('workstation_id')
                ->references('id')
                ->on('workstations')
                ->nullOnDelete();
        });
    }
};
