<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->string('ended_reason', 150)->nullable()->after('reason');
            $table->string('ended_by', 20)->nullable()->after('ended_reason');

            // The "is this session still open?" check runs on every scan,
            // heartbeat, and dashboard poll.
            $table->index(['session_id', 'event_type'], 'pc_access_logs_session_event_index');
        });
    }

    public function down(): void
    {
        Schema::table('pc_access_logs', function (Blueprint $table) {
            $table->dropIndex('pc_access_logs_session_event_index');
            $table->dropColumn(['ended_reason', 'ended_by']);
        });
    }
};
