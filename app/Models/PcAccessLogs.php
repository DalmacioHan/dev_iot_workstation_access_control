<?php

namespace App\Models;

use App\Models\Workstations;
use Illuminate\Database\Eloquent\Model;

class PcAccessLogs extends Model
{
    protected $fillable = [
        'occurred_at',
        'received_at',
        'rfid_uid',
        'workstation_id',
        'event_type',
        'result',
        'reason',
        'session_id',
        'student_external_id',
        'student_name',
        'course',
    ];

    public function workstation()
    {
        return $this->belongsTo(Workstations::class);
    }
}
