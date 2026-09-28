<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// A session is modelled as TWO rows in pc_access_logs: a `time_in` row created
// on scan, and a `time_out` row created on logout - both share the same
// session_id. The unique('session_id') index added by
// 2026_09_16_112943_link_app_usage_to_access_logs_via_session conflicts with
// that, so logout() would fail on the DB constraint.
//
// This migration replaces the unique index with a plain index (still required
// by the pc_app_usage foreign key) so time_in + time_out can coexist.
//
// InnoDB auto-creates the index backing a foreign key, so the migration is
// written to be idempotent: it inspects the current schema and only alters
// what actually needs changing (works on a fresh DB and a half-applied one).
return new class extends Migration
{
    public function up(): void
    {
        if ($this->hasForeignKey()) {
            Schema::table('pc_app_usage', function (Blueprint $table) {
                $table->dropForeign(['session_id']);
            });
        }

        foreach ($this->indexesOnSessionId() as $index) {
            if ((int) $index->NON_UNIQUE === 0) {
                Schema::table('pc_access_logs', function (Blueprint $table) use ($index) {
                    $table->dropUnique($index->INDEX_NAME);
                });
            }
        }

        if (! $this->hasIndex('pc_access_logs_session_id_index')) {
            Schema::table('pc_access_logs', function (Blueprint $table) {
                $table->index('session_id');
            });
        }

        Schema::table('pc_app_usage', function (Blueprint $table) {
            $table->foreign('session_id')
                ->references('session_id')
                ->on('pc_access_logs')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        if ($this->hasForeignKey()) {
            Schema::table('pc_app_usage', function (Blueprint $table) {
                $table->dropForeign(['session_id']);
            });
        }

        if ($this->hasIndex('pc_access_logs_session_id_index')) {
            Schema::table('pc_access_logs', function (Blueprint $table) {
                $table->dropIndex('session_id');
            });
        }

        if (! $this->hasUniqueIndexOnSessionId() && ! $this->hasDuplicateSessionIds()) {
            Schema::table('pc_access_logs', function (Blueprint $table) {
                $table->unique('session_id');
            });
        }

        Schema::table('pc_app_usage', function (Blueprint $table) {
            $table->foreign('session_id')
                ->references('session_id')
                ->on('pc_access_logs')
                ->onDelete('cascade');
        });
    }

    private function indexesOnSessionId(): array
    {
        return DB::select(
            "SELECT INDEX_NAME, NON_UNIQUE
             FROM information_schema.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = 'pc_access_logs'
               AND COLUMN_NAME = 'session_id'"
        );
    }

    private function hasIndex(string $name): bool
    {
        return count(DB::select(
            'SELECT 1 FROM information_schema.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ? AND INDEX_NAME = ?
             LIMIT 1',
            ['pc_access_logs', $name]
        )) > 0;
    }

    private function hasUniqueIndexOnSessionId(): bool
    {
        foreach ($this->indexesOnSessionId() as $index) {
            if ((int) $index->NON_UNIQUE === 0) {
                return true;
            }
        }

        return false;
    }

    private function hasForeignKey(): bool
    {
        return count(DB::select(
            'SELECT 1 FROM information_schema.REFERENTIAL_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = DATABASE()
               AND TABLE_NAME = ? AND CONSTRAINT_NAME = ?
             LIMIT 1',
            ['pc_app_usage', 'pc_app_usage_session_id_foreign']
        )) > 0;
    }

    private function hasDuplicateSessionIds(): bool
    {
        return count(DB::select(
            'SELECT session_id FROM pc_access_logs
             WHERE session_id IS NOT NULL
             GROUP BY session_id HAVING COUNT(*) > 1
             LIMIT 1'
        )) > 0;
    }
};