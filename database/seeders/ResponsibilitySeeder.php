<?php

namespace Database\Seeders;

use App\Models\Responsibility;
use App\Models\User;
use App\Models\Department;
use App\Models\Ward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ResponsibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = User::where('role', '!=', null)->limit(10)->get();
        $departments = Department::all();
        $wards = Ward::all();
        $today = Carbon::now();
        
        $responsibilityTypes = ['Patient Care', 'Ward Management', 'Staff Supervision', 'Medical Records', 'Training'];

        foreach ($staff as $person) {
            foreach ($responsibilityTypes as $type) {
                Responsibility::create([
                    'staff_id' => $person->id,
                    'department_id' => $departments->random()->id,
                    'ward_id' => $wards->random()->id,
                    'responsibility_type' => $type,
                    'description' => "Responsible for $type in assigned department and ward",
                    'status' => 'active',
                    'start_date' => $today->copy()->subDays(30),
                    'end_date' => $today->copy()->addDays(90),
                ]);
            }
        }
    }
}
