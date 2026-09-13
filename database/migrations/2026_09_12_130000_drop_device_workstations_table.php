<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('device_workstations');
    }

    public function down(): void
    {
        Schema::create('device_workstations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')
                ->constrained('devices')
                ->cascadeOnDelete();
            $table->tinyInteger('pc_port');
            $table->foreignId('workstation_id')
                ->constrained('workstations')
                ->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['device_id', 'pc_port']);
            $table->unique('workstation_id');
        });
    }
};
