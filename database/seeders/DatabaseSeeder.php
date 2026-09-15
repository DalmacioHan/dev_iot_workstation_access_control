<?php

namespace Database\Seeders;




use Database\Seeders\DeviceSeeder;
use Database\Seeders\PcAccessLogSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        UserSeeder::class,
        DeviceSeeder::class,
        PcAccessLogSeeder::class,
    ]);
    }
}
