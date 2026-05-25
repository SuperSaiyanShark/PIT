<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Cardiology',
                'description' => 'Heart and cardiovascular diseases',
                'building' => 'Building A',
                'phone' => '555-0101',
            ],
            [
                'name' => 'Neurology',
                'description' => 'Nervous system and brain disorders',
                'building' => 'Building B',
                'phone' => '555-0102',
            ],
            [
                'name' => 'Orthopedics',
                'description' => 'Bones and joint disorders',
                'building' => 'Building A',
                'phone' => '555-0103',
            ],
            [
                'name' => 'Emergency',
                'description' => 'Emergency and trauma care',
                'building' => 'Building C',
                'phone' => '555-0104',
            ],
            [
                'name' => 'Pediatrics',
                'description' => 'Child health and development',
                'building' => 'Building D',
                'phone' => '555-0105',
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
