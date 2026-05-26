<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'dob' => '1980-05-15',
                'sex' => 'M',
                'address' => '123 Main Street, Anytown',
                'phonenumber' => '555-0001',
                'dateregistered' => now()->toDateString(),
            ],
            [
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'dob' => '1990-08-22',
                'sex' => 'F',
                'address' => '456 Oak Avenue, Somewhere',
                'phonenumber' => '555-0002',
                'dateregistered' => now()->toDateString(),
            ],
            [
                'firstname' => 'Michael',
                'lastname' => 'Johnson',
                'dob' => '1975-12-10',
                'sex' => 'M',
                'address' => '789 Pine Road, Elsewhere',
                'phonenumber' => '555-0003',
                'dateregistered' => now()->toDateString(),
            ],
            [
                'firstname' => 'Sarah',
                'lastname' => 'Williams',
                'dob' => '1985-03-28',
                'sex' => 'F',
                'address' => '321 Elm Street, Nowhere',
                'phonenumber' => '555-0004',
                'dateregistered' => now()->toDateString(),
            ],
            [
                'firstname' => 'Robert',
                'lastname' => 'Brown',
                'dob' => '1970-07-14',
                'sex' => 'M',
                'address' => '654 Maple Drive, Somewhere Else',
                'phonenumber' => '555-0005',
                'dateregistered' => now()->toDateString(),
            ],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
