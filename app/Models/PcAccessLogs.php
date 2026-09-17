<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PcAccessLogs extends Model
{
    protected $fillable = [
        'occurred_at',
        'received_at',
        'rfid_uid',
        'device_id',
        'event_type',
        'result',
        'reason',
        'session_id',
        'student_external_id',
        'student_name',
        'course',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    public function appUsages()
{
    // Explicitly state the foreign key and local key since they aren't 'id'
    return $this->hasMany(PcAppUsage::class, 'session_id', 'session_id');
}
}
