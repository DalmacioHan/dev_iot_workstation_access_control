<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_commands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')
                  ->constrained('devices')
                  ->onDelete('cascade');
            $table->string('command', 20)->default('lock');
            $table->text('message')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_commands');
    }
};