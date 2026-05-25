<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('medical_records')->count() > 0) {
            $this->command->info('Medical records already seeded, skipping.');
            return;
        }

        $records = [
            [1,  'Hypertension',              'Amlodipine 5mg daily',              '2025-01-10', 'Monitor BP weekly'],
            [2,  'Type 2 Diabetes',           'Metformin 500mg twice daily',       '2025-01-08', 'Low sugar diet advised'],
            [3,  'Osteoarthritis',            'Celecoxib 200mg daily',             '2025-01-15', 'Physio referral given'],
            [4,  'Coronary Artery Disease',   'Aspirin 80mg, Atorvastatin',        '2025-01-13', 'Cardiology follow-up'],
            [5,  'Chronic Kidney Disease',    'Dietary modification, Erythropoietin','2025-01-20','Nephrology consult'],
            [6,  'COPD',                      'Salbutamol inhaler PRN',            '2025-01-19', 'Avoid smoke exposure'],
            [7,  'Stroke (Ischemic)',         'Aspirin, Clopidogrel, Rehab',       '2025-01-25', 'Neurological monitoring'],
            [8,  'Alzheimers Disease',        'Donepezil 10mg nightly',            '2025-01-23', 'Family counseled'],
            [9,  'Hip Fracture',              'ORIF surgery, PT',                  '2025-01-30', 'Weight-bearing precautions'],
            [10, 'Atrial Fibrillation',       'Warfarin, Rate control',            '2025-01-29', 'INR monitoring required'],
            [11, 'Pneumonia',                 'Amoxicillin-Clavulanate IV',        '2025-02-06', 'Oxygen support prn'],
            [12, 'UTI',                       'Ciprofloxacin 500mg',               '2025-02-04', 'Increase fluid intake'],
            [13, 'Parkinsons Disease',        'Levodopa-Carbidopa',                '2025-02-10', 'Fall risk - bed rails up'],
            [14, 'Osteoporosis',              'Alendronate 70mg weekly, Ca+',      '2025-02-09', 'DXA scan scheduled'],
            [15, 'Congestive Heart Failure',  'Furosemide, Carvedilol',            '2025-02-15', 'Daily weight monitoring'],
            [16, 'Dementia',                  'Supportive care, Memantine',        '2025-02-13', 'Wandering risk assessed'],
            [17, 'Peptic Ulcer',              'Omeprazole 40mg, Amoxicillin',      '2025-02-20', 'Avoid NSAIDs'],
            [18, 'Deep Vein Thrombosis',      'Heparin IV, then Warfarin',         '2025-02-19', 'Compression stockings'],
            [19, 'Lumbar Spondylosis',        'Tramadol, Physiotherapy',           '2025-02-25', 'Avoid heavy lifting'],
            [20, 'Anemia',                    'Iron supplementation, B12',         '2025-02-23', 'Monthly CBC'],
            [21, 'Hypertension, Diabetes',    'Combination therapy',               '2025-03-06', 'Dual condition monitoring'],
            [22, 'Rheumatoid Arthritis',      'Methotrexate, Folic Acid',          '2025-03-04', 'Joint protection education'],
            [23, 'Femur Fracture',            'ORIF, Post-op PT',                  '2025-03-10', 'Non-weight bearing 6 weeks'],
            [24, 'Chronic Heart Failure',     'Digoxin, Spironolactone',           '2025-03-09', 'Low sodium diet'],
            [25, 'Urinary Retention',         'Tamsulosin, Catheterization',       '2025-03-15', 'Urology referral'],
            [26, 'Pulmonary Embolism',        'Heparin IV, Warfarin',              '2025-03-13', 'Bed rest strictly'],
            [27, 'Transient Ischemic Attack', 'Aspirin, Statins',                  '2025-03-20', 'Brain MRI ordered'],
            [28, 'Cataract (bilateral)',      'Surgery scheduled',                 '2025-03-19', 'Pre-op clearance done'],
            [29, 'Prostate Hyperplasia',      'Tamsulosin, Finasteride',           '2025-03-25', 'Urology monitoring'],
            [30, 'Hypothyroidism',            'Levothyroxine 50mcg daily',         '2025-03-23', 'TSH recheck in 6 weeks'],
            [31, 'Hypertension',              'Losartan 50mg daily',               '2025-04-02', 'BP diary advised'],
            [32, 'Diabetes Mellitus',         'Insulin therapy',                   '2025-04-04', 'Blood glucose monitoring'],
            [33, 'Chronic Back Pain',         'Ibuprofen, Physical Therapy',       '2025-04-06', 'Posture correction'],
            [34, 'Glaucoma',                  'Timolol eye drops',                 '2025-04-09', 'Regular eye check'],
            [35, 'Appendicitis',              'Appendectomy performed',            '2025-04-12', 'Post-op wound care'],
            [36, 'Gout',                      'Allopurinol 100mg daily',           '2025-04-15', 'Low purine diet'],
            [37, 'Sciatica',                  'Pregabalin, PT',                    '2025-04-20', 'Avoid prolonged sitting'],
            [38, 'Cholecystitis',             'Laparoscopic cholecystectomy',      '2025-04-19', 'Low fat diet post-op'],
            [39, 'Epilepsy',                  'Valproic Acid 500mg',               '2025-04-25', 'Avoid driving'],
            [40, 'Anemia',                    'Blood transfusion, Iron IV',        '2025-04-23', 'Hgb monitoring'],
        ];

        foreach ($records as $r) {
            DB::table('medical_records')->insert([
                'patient_id'  => $r[0],
                'diagnosis'   => $r[1],
                'treatment'   => $r[2],
                'record_date' => $r[3],
                'notes'       => $r[4],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info('Medical records seeded successfully.');
    }
}
