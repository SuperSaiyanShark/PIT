<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdmissionSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('admissions')->count() > 0) {
            $this->command->info('Admissions already seeded, skipping.');
            return;
        }

        // Get ward IDs by name
        $wards = DB::table('wards')->pluck('id', 'name');

        $ward1  = $wards['General Medicine Ward'] ?? 1;
        $ward2  = $wards['Surgical Ward']         ?? 2;
        $ward3  = $wards['Pediatric Ward']        ?? 3;
        $ward4  = $wards['Maternity Ward']        ?? 4;
        $ward5  = $wards['Orthopedic Ward']       ?? 5;
        $ward6  = $wards['Cardiology Ward']       ?? 6;
        $ward7  = $wards['Neurology Ward']        ?? 7;
        $ward8  = $wards['Geriatric Ward']        ?? 8;
        $ward9  = $wards['Emergency Ward']        ?? 9;

        $admissions = [
            // Discharged patients
            [1,  $ward1, 'A-101', '2025-01-06', 14, '2025-01-10', '2025-01-24', '2025-01-23'],
            [3,  $ward2, 'B-201', '2025-01-11', 7,  '2025-01-15', '2025-01-22', '2025-01-21'],
            [5,  $ward5, 'E-501', '2025-01-16', 10, '2025-01-20', '2025-01-30', '2025-01-28'],
            [7,  $ward1, 'A-102', '2025-01-21', 5,  '2025-01-25', '2025-01-30', '2025-01-29'],
            [9,  $ward3, 'C-301', '2025-01-26', 12, '2025-01-30', '2025-02-11', '2025-02-10'],
            [11, $ward6, 'F-601', '2025-02-02', 8,  '2025-02-06', '2025-02-14', '2025-02-13'],
            [13, $ward7, 'G-701', '2025-02-06', 6,  '2025-02-10', '2025-02-16', '2025-02-15'],
            [15, $ward8, 'H-801', '2025-02-11', 15, '2025-02-15', '2025-03-02', '2025-02-28'],
            [17, $ward2, 'B-202', '2025-02-16', 9,  '2025-02-20', '2025-03-01', '2025-02-27'],
            [19, $ward4, 'D-401', '2025-02-21', 7,  '2025-02-25', '2025-03-04', '2025-03-03'],
            [21, $ward1, 'A-103', '2025-03-02', 11, '2025-03-06', '2025-03-17', '2025-03-16'],
            [23, $ward5, 'E-502', '2025-03-06', 8,  '2025-03-10', '2025-03-18', '2025-03-17'],
            [25, $ward3, 'C-302', '2025-03-11', 14, '2025-03-15', '2025-03-29', '2025-03-28'],
            [27, $ward6, 'F-602', '2025-03-16', 6,  '2025-03-20', '2025-03-26', '2025-03-25'],
            [29, $ward8, 'H-802', '2025-03-21', 10, '2025-03-25', '2025-04-04', '2025-04-03'],
            [31, $ward2, 'B-203', '2025-04-02', 7,  '2025-04-06', '2025-04-13', '2025-04-12'],
            [33, $ward1, 'A-104', '2025-04-06', 9,  '2025-04-10', '2025-04-19', '2025-04-18'],
            [35, $ward9, 'I-901', '2025-04-11', 3,  '2025-04-12', '2025-04-15', '2025-04-14'],
            [37, $ward5, 'E-503', '2025-04-16', 12, '2025-04-20', '2025-05-02', '2025-04-30'],
            [39, $ward7, 'G-702', '2025-04-21', 8,  '2025-04-25', '2025-05-03', '2025-05-02'],
            // Currently admitted (no date_actual_leave)
            [41, $ward1, 'A-105', '2025-05-02', 14, '2025-05-06', '2025-05-20', null],
            [43, $ward3, 'C-303', '2025-05-06', 10, '2025-05-10', '2025-05-20', null],
            [45, $ward6, 'F-603', '2025-05-11', 7,  '2025-05-15', '2025-05-22', null],
            [47, $ward8, 'H-803', '2025-05-16', 15, '2025-05-20', '2025-06-04', null],
            [49, $ward2, 'B-204', '2025-05-21', 5,  '2025-05-25', '2025-05-30', null],
        ];

        foreach ($admissions as $a) {
            DB::table('admissions')->insert([
                'patient_id'           => $a[0],
                'ward_id'              => $a[1],
                'bed_number'           => $a[2],
                'date_on_waiting_list' => $a[3],
                'expected_stay_days'   => $a[4],
                'date_admitted'        => $a[5],
                'date_expected_leave'  => $a[6],
                'date_actual_leave'    => $a[7],
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);
        }

        $this->command->info('Admissions seeded successfully.');
    }
}
