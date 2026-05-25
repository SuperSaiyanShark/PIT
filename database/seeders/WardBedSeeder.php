<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardBedSeeder extends Seeder
{
    public function run(): void
    {
        // Insert ward
        DB::table('wards')->insert([
            'id' => 16,
            'capacity' => 20,
            'allocationid' => 'ALC-7765',
            'wardName' => 'Patient Ward B',
            'location' => 'Ground Floor',
            'telExtn' => '09051013893',
            'wardNumber' => 'w-101',
            'created_at' => null,
            'updated_at' => null,
        ]);

        // Reset sequence
        DB::statement('SELECT setval(\'wards_id_seq\', 16, true)');

        // Insert 20 beds
        for ($i = 1; $i <= 20; $i++) {
            DB::table('beds')->insert([
                'id' => 73 + $i,
                'wardNumber' => 'w-101',
                'is_occupied' => false,
                'patient_name' => null,
                'bedNumber' => 'B-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'status' => 'Available',
                'created_at' => '2026-05-23 11:36:47',
                'updated_at' => '2026-05-24 12:41:10.367578',
            ]);
        }

        // Reset beds sequence
        DB::statement('SELECT setval(\'beds_id_seq\', 163, true)');
    }
}