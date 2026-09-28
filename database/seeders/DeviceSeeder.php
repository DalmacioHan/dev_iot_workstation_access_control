<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Device::updateOrCreate(
                ['device_uid' => 'DVC' . str_pad($i, 3, '0', STR_PAD_LEFT)],
                [
                    'is_active'    => $i % 2, // alternate
                    'last_seen_at' => Carbon::now()->subDays(rand(0, 29))->subMinutes(rand(0, 1439)),
                ]
            );
        }
    }
}
