<?php

namespace App\Models;


use App\Models\PcAccessLogs;
use Illuminate\Database\Eloquent\Model;

class Workstations extends Model
{
    protected $fillable = [
        'pc_code',
        'device_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function pcAccessLogs()
    {
        return $this->hasMany(PcAccessLogs::class);
    }
}
