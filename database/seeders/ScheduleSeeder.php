<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = User::where('role', '!=', null)->limit(10)->get();
        $wards = Ward::all();
        $shifts = ['morning', 'afternoon', 'night'];
        $today = Carbon::now();

        foreach ($staff as $person) {
            foreach ($shifts as $shift) {
                $ward = $wards->random();
                Schedule::create([
                    'staff_id' => $person->id,
                    'ward_id' => $ward->id,
                    'shift_date' => $today->copy()->addDays(rand(1, 30)),
                    'start_date' => $today->copy()->addDays(rand(1, 30)),
                    'end_date' => $today->copy()->addDays(rand(31, 60)),
                    'shift_type' => $shift,
                    'status' => 'active',
                    'notes' => 'Regular shift assignment',
                ]);
            }
        }
    }
}
