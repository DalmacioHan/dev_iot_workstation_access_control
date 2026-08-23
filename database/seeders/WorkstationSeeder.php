<?php

namespace Database\Seeders;

use App\Models\Workstations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkstationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Workstations::create([
            'pc_code' => 'PC01',
            'is_active' => 1,
        ]);
        Workstations::create([
            'pc_code' => 'PC02',
            'is_active' => 1,
        ]);
    }
}
