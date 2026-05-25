<?php

namespace Database\Seeders;

use App\Models\StaffRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Ward Head',
                'description' => 'Ward head/supervisor',
                'permissions' => ['manage_ward', 'assign_staff', 'view_ward_reports'],
            ],
            [
                'name' => 'Doctor',
                'description' => 'Medical doctor and physician',
                'permissions' => ['view_patients', 'prescribe_medication', 'manage_staff'],
            ],
            [
                'name' => 'Nurse',
                'description' => 'Registered nurse',
                'permissions' => ['view_patients', 'provide_care', 'monitor_vitals'],
            ],
            [
                'name' => 'Receptionist',
                'description' => 'Front desk receptionist',
                'permissions' => ['schedule_appointments', 'check_in_patients'],
            ],
            [
                'name' => 'Administrator',
                'description' => 'Hospital administrator',
                'permissions' => ['manage_staff', 'manage_departments', 'view_reports'],
            ],
            [
                'name' => 'Technician',
                'description' => 'Medical technician',
                'permissions' => ['perform_tests', 'view_results'],
            ],
        ];

        foreach ($roles as $role) {
            StaffRole::create($role);
        }
    }
}
