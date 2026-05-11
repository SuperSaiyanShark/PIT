<?php

namespace Database\Seeders;

use App\Models\Ward;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cardiology = Department::where('name', 'Cardiology')->first();
        $neurology = Department::where('name', 'Neurology')->first();
        $orthopedics = Department::where('name', 'Orthopedics')->first();
        $emergency = Department::where('name', 'Emergency')->first();
        $pediatrics = Department::where('name', 'Pediatrics')->first();

        $wards = [
            [
                'name' => 'Cardiac ICU',
                'department_id' => $cardiology->id,
                'floor' => 3,
                'capacity' => 10,
            ],
            [
                'name' => 'General Cardiology',
                'department_id' => $cardiology->id,
                'floor' => 2,
                'capacity' => 20,
            ],
            [
                'name' => 'Neurology Ward',
                'department_id' => $neurology->id,
                'floor' => 4,
                'capacity' => 15,
            ],
            [
                'name' => 'Orthopedic Ward',
                'department_id' => $orthopedics->id,
                'floor' => 2,
                'capacity' => 25,
            ],
            [
                'name' => 'Emergency Trauma',
                'department_id' => $emergency->id,
                'floor' => 1,
                'capacity' => 30,
            ],
            [
                'name' => 'Pediatric Ward',
                'department_id' => $pediatrics->id,
                'floor' => 5,
                'capacity' => 20,
            ],
        ];

        foreach ($wards as $ward) {
            Ward::create($ward);
        }
    }
}
