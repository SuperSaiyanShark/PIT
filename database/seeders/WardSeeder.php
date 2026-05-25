<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardSeeder extends Seeder
{
    public function run(): void
    {
        // Check if wards already have data
        if (DB::table('wards')->count() > 0) {
            $this->command->info('Wards already seeded, skipping.');
            return;
        }

        // Get department IDs — adjust if your departments table has different names
        $depts = DB::table('departments')->pluck('id', 'name');

        $wards = [
            ['name' => 'General Medicine Ward',  'floor' => 'A Block, Floor 1', 'capacity' => 24],
            ['name' => 'Surgical Ward',          'floor' => 'B Block, Floor 1', 'capacity' => 20],
            ['name' => 'Pediatric Ward',         'floor' => 'C Block, Floor 1', 'capacity' => 18],
            ['name' => 'Maternity Ward',         'floor' => 'D Block, Floor 1', 'capacity' => 16],
            ['name' => 'Orthopedic Ward',        'floor' => 'E Block, Floor 2', 'capacity' => 20],
            ['name' => 'Cardiology Ward',        'floor' => 'F Block, Floor 2', 'capacity' => 16],
            ['name' => 'Neurology Ward',         'floor' => 'G Block, Floor 3', 'capacity' => 14],
            ['name' => 'Geriatric Ward',         'floor' => 'H Block, Floor 1', 'capacity' => 24],
            ['name' => 'Emergency Ward',         'floor' => 'A Block, Ground',  'capacity' => 20],
            ['name' => 'Out-Patient Clinic',     'floor' => 'Main Bldg, GF',    'capacity' => 28],
        ];

        foreach ($wards as $ward) {
            DB::table('wards')->insertOrIgnore([
                'name'       => $ward['name'],
                'floor'      => $ward['floor'],
                'capacity'   => $ward['capacity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Wards seeded successfully.');
    }
}
