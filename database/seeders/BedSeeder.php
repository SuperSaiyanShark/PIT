<?php

namespace Database\Seeders;

use App\Models\Bed;
use App\Models\Ward;
use Illuminate\Database\Seeder;

class BedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wards = Ward::all();

        if ($wards->isEmpty()) {
            return; // No wards, skip seeding
        }

        foreach ($wards as $ward) {
            // Create 5-6 beds per ward
            $bedCount = rand(5, 6);
            for ($i = 1; $i <= $bedCount; $i++) {
                Bed::create([
                    'wardid' => $ward->id,
                    'bednumber' => $i,
                    'status' => 'available',
                ]);
            }
        }
    }
}
