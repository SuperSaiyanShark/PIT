<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Ward;
use App\Models\Admission;
use App\Models\NextOfKin;
use Carbon\Carbon;

class PatientModuleSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample wards
        $wards = [
            ['WardName' => 'General Ward',     'Location' => 'Building A, Floor 1', 'TotalBeds' => 20],
            ['WardName' => 'Surgical Ward',    'Location' => 'Building A, Floor 2', 'TotalBeds' => 15],
            ['WardName' => 'Pediatric Ward',   'Location' => 'Building B, Floor 1', 'TotalBeds' => 12],
            ['WardName' => 'ICU',              'Location' => 'Building A, Floor 3', 'TotalBeds' => 8],
            ['WardName' => 'Maternity Ward',   'Location' => 'Building B, Floor 2', 'TotalBeds' => 10],
        ];

        foreach ($wards as $w) {
            Ward::firstOrCreate(['WardName' => $w['WardName']], $w);
        }

        // Sample patients
        $samplePatients = [
            [
                'patient' => [
                    'FirstName' => 'Sarah',       'LastName' => 'Johnson',
                    'DOB' => '1985-06-15',         'Sex' => 'Female',
                    'Address' => '123 Main St, Springfield, IL 62701',
                    'PhoneNumber' => '+63-912-345-6789',
                    'Email' => 'sarah.j@email.com',
                    'BloodType' => 'A+',
                    'Allergies' => 'Penicillin',
                    'MedicalConditions' => 'Hypertension',
                    'DateRegistered' => today(),
                ],
                'nok' => [
                    'FullName' => 'Michael Johnson', 'Relationship' => 'Spouse',
                    'PhoneNumber' => '+63-912-987-6543',
                ],
                'admit' => ['WardName' => 'General Ward', 'BedNumber' => '101'],
            ],
            [
                'patient' => [
                    'FirstName' => 'Juan',        'LastName' => 'Dela Cruz',
                    'DOB' => '1990-03-22',         'Sex' => 'Male',
                    'PhoneNumber' => '+63-917-222-3333',
                    'BloodType' => 'O+',
                    'DateRegistered' => today(),
                ],
                'nok' => [
                    'FullName' => 'Maria Dela Cruz', 'Relationship' => 'Mother',
                    'PhoneNumber' => '+63-917-444-5555',
                ],
            ],
            [
                'patient' => [
                    'FirstName' => 'Gerry',       'LastName' => 'Ratunil',
                    'DOB' => '2004-08-10',         'Sex' => 'Male',
                    'PhoneNumber' => '+63-936-780-0211',
                    'BloodType' => 'B+',
                    'DateRegistered' => today(),
                ],
                'nok' => null,
                'admit' => ['WardName' => 'General Ward', 'BedNumber' => '201'],
            ],
        ];

        foreach ($samplePatients as $data) {
            $patient = Patient::create($data['patient']);

            if ($data['nok']) {
                NextOfKin::create(array_merge($data['nok'], ['PatientID' => $patient->PatientID]));
            }

            if (isset($data['admit'])) {
                $ward = Ward::where('WardName', $data['admit']['WardName'])->first();
                if ($ward) {
                    Admission::create([
                        'PatientID'     => $patient->PatientID,
                        'WardID'        => $ward->WardID,
                        'BedNumber'     => $data['admit']['BedNumber'],
                        'AdmissionDate' => today(),
                        'Status'        => 'Admitted',
                    ]);
                }
            }
        }
    }
}
