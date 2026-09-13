<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
    'device_uid',
    'name',
    'pairing_code',
    'is_active',
    'last_seen_at',
    'api_token',
    'token_created_at',
    'token_expires_at',
    ];
    
    protected $casts = [
        'last_seen_at' => 'datetime',
        'is_active' => 'boolean',
        'token_created_at' => 'datetime',
        'token_expires_at' => 'datetime',
    ];


    public function workstations()
    {
        return $this->hasMany(Workstations::class, 'device_id', 'id');
    }


    /**
     * Generate and store a new API token
     */
    public function generateApiToken(): string
    {
        $token = hash('sha256', \Str::random(40) . time());
        
        $this->update([
            'api_token' => $token,
            'token_created_at' => now(),
            'token_expires_at' => now()->addYear(),
        ]);

        return $token;
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

        return $this->is_active;
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
}