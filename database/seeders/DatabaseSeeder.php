<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create departments first
        $this->call(DepartmentSeeder::class);
        
        // Create wards
        $this->call(WardSeeder::class);
        
        // Create staff roles
        $this->call(StaffRoleSeeder::class);
        
        // Create staff members
        $this->call(StaffSeeder::class);
        
        // Create schedules
        $this->call(ScheduleSeeder::class);
        
        // Create responsibilities
        $this->call(ResponsibilitySeeder::class);
    }
}
