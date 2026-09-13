<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PcAppUsage extends Model
{
    protected $table = 'pc_app_usage';

    protected $fillable = [
        'session_id',
        'rfid_uid',
        'app_name',
        'seconds',
        'occurred_at',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
    ];
}