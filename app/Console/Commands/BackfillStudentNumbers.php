<?php

namespace App\Console\Commands;

use App\Services\MisStudentLookup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillStudentNumbers extends Command
{
    protected $signature = 'access:backfill-student-numbers
                            {--dry-run : Show what would change without writing}';

    protected $description = 'Replace RFID card IDs stored in student_external_id with the MIS StudentNo';

    public function handle(MisStudentLookup $mis): int
    {
        $cardIds = DB::table('pc_access_logs')
            ->select('rfid_uid')
            ->whereNotNull('rfid_uid')
            ->where('rfid_uid', '!=', '')
            ->whereColumn('student_external_id', 'rfid_uid')
            ->distinct()
            ->orderBy('rfid_uid')
            ->pluck('rfid_uid');

        if ($cardIds->isEmpty()) {
            $this->info('No rows need backfilling.');

            return self::SUCCESS;
        }

        $dryRun = (bool) $this->option('dry-run');
        $updated = 0;
        $skipped = 0;

        foreach ($cardIds as $cardId) {
            [$student, $reason] = $mis->lookup((string) $cardId);

            $studentNumber = $student['studentNumber'] ?? '';

            if ($student === null || $studentNumber === '') {
                $this->warn("Skipped {$cardId}: " . ($reason ?: 'MIS returned no StudentNo.'));

                $skipped++;

                continue;
            }

            $rows = DB::table('pc_access_logs')
                ->where('rfid_uid', $cardId)
                ->whereColumn('student_external_id', 'rfid_uid')
                ->count();

            $this->line("{$cardId} -> {$studentNumber} ({$rows} row(s))");

            if (! $dryRun) {
                DB::table('pc_access_logs')
                    ->where('rfid_uid', $cardId)
                    ->whereColumn('student_external_id', 'rfid_uid')
                    ->update(['student_external_id' => $studentNumber]);

                $updated += $rows;
            }
        }

        if ($dryRun) {
            $this->info('Dry run complete. No rows were changed.');
        } else {
            $this->info("Updated {$updated} row(s). Skipped {$skipped} card(s).");
        }

        return self::SUCCESS;
    }
}
