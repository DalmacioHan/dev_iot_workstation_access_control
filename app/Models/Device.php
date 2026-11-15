<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Device extends Model
{
    protected $fillable = [
    'workstation_name',
    'pairing_code',
    'is_paired',
    'last_seen_at',
    'api_token',
    'token_created_at',
    'token_expires_at',
    ];
    
    protected $casts = [
        'last_seen_at' => 'datetime',
        'is_paired' => 'boolean',
        'token_created_at' => 'datetime',
        'token_expires_at' => 'datetime',
    ];


    /**
     * Generate and store a new API token
     */
    public function generateApiToken(): string
    {
        $token = hash('sha256', \Str::random(40) . time());
        
        $this->update([
            'api_token' => $token,
            'token_created_at' => now(),
            'token_expires_at' => null,
        ]);

        return $token;
    }

    public function accessLogs()
    {
        return $this->hasMany(PcAccessLogs::class);
    }

    public function remoteCommands()
    {
        return $this->hasMany(DeviceCommand::class);
    }

    /**
     * Check if token is valid
     */
    public function isTokenValid(): bool
    {
        if (!$this->api_token) {
            return false;
        }

        if ($this->token_expires_at && $this->token_expires_at->isPast()) {
            return false;
        }

        return $this->is_paired;
    }

    /**
     * Revoke the current token
     */
    public function revokeToken(): void
    {
        $this->update([
            'api_token' => null,
            'token_created_at' => null,
            'token_expires_at' => null,
        ]);
    }

    /**
     * Unpair this device and return the pairing code needed to pair it again.
     *
     * Serialized per device with a row lock so a client-side unpair and a
     * dashboard unpair landing at the same time cannot interleave (one wins,
     * the other sees the already-unpaired row and simply reuses its code).
     */
    public function unpair(): string
    {
        return DB::transaction(function (): string {
            /** @var Device $device */
            $device = static::query()
                ->whereKey($this->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $device->update([
                'is_paired'        => false,
                'last_seen_at'     => null,
                'api_token'        => null,
                'token_created_at' => null,
                'token_expires_at' => null,
            ]);

            $code = $device->pairing_code;

            if (empty($code)) {
                $code = static::assignPairingCode($device);
            }

            return $code;
        });
    }

    /**
     * Return a pairing code that is not currently assigned to another device.
     */
    public static function newPairingCode(): string
    {
        for ($attempt = 0; $attempt < 10; $attempt++) {
            $code = strtoupper(Str::random(6));

            if (!static::query()->where('pairing_code', $code)->exists()) {
                return $code;
            }
        }

        return strtoupper(Str::random(10));
    }

    /**
     * Assign a fresh, unique pairing code to a device. pairing_code has a
     * unique index, so a collision is retried instead of bubbling up.
     */
    private static function assignPairingCode(Device $device): string
    {
        for ($attempt = 0; $attempt < 10; $attempt++) {
            $code = static::newPairingCode();

            try {
                $device->update(['pairing_code' => $code]);
                return $code;
            } catch (QueryException) {
                // Unique-index collision: try another code.
            }
        }

        $code = strtoupper(Str::random(10));
        $device->update(['pairing_code' => $code]);

        return $code;
    }
}