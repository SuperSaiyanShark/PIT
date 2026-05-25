<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Ward;
use App\Models\StaffRole;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = StaffRole::where('name', 'Doctor')->first();
        $nurses = StaffRole::where('name', 'Nurse')->first();
        $admin = StaffRole::where('name', 'Administrator')->first();
        $tech = StaffRole::where('name', 'Technician')->first();
        
        $cardiology = Department::where('name', 'Cardiology')->first();
        $emergency = Department::where('name', 'Emergency')->first();
        $pediatrics = Department::where('name', 'Pediatrics')->first();
        $neuro = Department::where('name', 'Neurology')->first();
        $ortho = Department::where('name', 'Orthopedics')->first();
        
        $cardiac_icu = Ward::where('name', 'Cardiac ICU')->first();
        $trauma = Ward::where('name', 'Emergency Trauma')->first();
        $neuro_ward = Ward::where('name', 'Neurology Ward')->first();
        $peds_ward = Ward::where('name', 'Pediatric Ward')->first();

        $staff = [
            // DOCTORS (5)
            [
                'name' => 'Dr. Joshlie Daven G. Mirales',
                'email' => 'jd@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
                'department_id' => $cardiology->id,
                'ward_id' => $cardiac_icu->id,
                'staff_role_id' => $doctors->id,
                'phone' => '555-0001',
                'building' => 'Building A',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2020-01-15',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Zild Jan F Abuga-a',
                'email' => 'zj@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
                'department_id' => $neuro->id,
                'ward_id' => $neuro_ward->id,
                'staff_role_id' => $doctors->id,
                'phone' => '555-0003',
                'building' => 'Building C',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2019-05-22',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. John Benedict R. Acebido',
                'email' => 'jb@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
                'department_id' => $pediatrics->id,
                'ward_id' => $peds_ward->id,
                'staff_role_id' => $doctors->id,
                'phone' => '555-0004',
                'building' => 'Building D',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2021-08-18',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Carlos Rodriguez',
                'email' => 'cr@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
                'department_id' => $cardiology->id,
                'ward_id' => $cardiac_icu->id,
                'staff_role_id' => $doctors->id,
                'phone' => '555-0006',
                'building' => 'Building A',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2020-06-14',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Sarah Michelle Wong',
                'email' => 'sw@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'doctor',
                'department_id' => $emergency->id,
                'ward_id' => $trauma->id,
                'staff_role_id' => $doctors->id,
                'phone' => '555-0009',
                'building' => 'Building B',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2021-11-03',
                'status' => 'active',
            ],

            // NURSES (5)
            [
                'name' => 'Loniel Jade D. Rana',
                'email' => 'lj@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'nurse',
                'department_id' => $emergency->id,
                'ward_id' => $trauma->id,
                'staff_role_id' => $nurses->id,
                'phone' => '555-0002',
                'building' => 'Building B',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2021-03-10',
                'status' => 'active',
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'ms@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'nurse',
                'department_id' => $emergency->id,
                'ward_id' => $trauma->id,
                'staff_role_id' => $nurses->id,
                'phone' => '555-0005',
                'building' => 'Building B',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2022-01-09',
                'status' => 'active',
            ],
            [
                'name' => 'Angela Marie Thompson',
                'email' => 'at@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'nurse',
                'department_id' => $pediatrics->id,
                'ward_id' => $peds_ward->id,
                'staff_role_id' => $nurses->id,
                'phone' => '555-0010',
                'building' => 'Building D',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2022-05-15',
                'status' => 'active',
            ],
            [
                'name' => 'Jennifer Marie Parker',
                'email' => 'jp@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'nurse',
                'department_id' => $cardiology->id,
                'ward_id' => $cardiac_icu->id,
                'staff_role_id' => $nurses->id,
                'phone' => '555-0011',
                'building' => 'Building A',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2020-07-22',
                'status' => 'active',
            ],
            [
                'name' => 'Patricia Anne Martinez',
                'email' => 'pm@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'nurse',
                'department_id' => $neuro->id,
                'ward_id' => $neuro_ward->id,
                'staff_role_id' => $nurses->id,
                'phone' => '555-0012',
                'building' => 'Building C',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Part-time',
                'hire_date' => '2023-02-14',
                'status' => 'active',
            ],

            // ADMINISTRATIVE STAFF (2)
            [
                'name' => 'Jean Smith',
                'email' => 'js@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'department_id' => $cardiology->id,
                'staff_role_id' => $admin->id,
                'phone' => '555-0007',
                'building' => 'Building A',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2021-02-01',
                'status' => 'active',
            ],
            [
                'name' => 'David Lawrence Miller',
                'email' => 'dm@meadow.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'department_id' => $emergency->id,
                'staff_role_id' => $admin->id,
                'phone' => '555-0013',
                'building' => 'Building B',
                'profile_image' => 'https://via.placeholder.com/150',
                'employment_type' => 'Full-time',
                'hire_date' => '2020-09-08',
                'status' => 'active',
            ],
        ];

        foreach ($staff as $member) {
            User::create($member);
        }
    }
}
