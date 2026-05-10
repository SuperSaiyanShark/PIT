<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $primaryKey = 'PatientID';

    protected $fillable = [
        'FirstName',
        'LastName',
        'DOB',
        'Sex',
        'Address',
        'PhoneNumber',
        'Email',
        'BloodType',
        'Allergies',
        'MedicalConditions',
        'DateRegistered',
    ];

    protected $casts = [
        'DOB' => 'date',
        'DateRegistered' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->FirstName} {$this->LastName}";
    }

    public function getAgeAttribute(): int
    {
        return $this->DOB ? $this->DOB->age : 0;
    }

    public function nextOfKin()
    {
        return $this->hasOne(NextOfKin::class, 'PatientID', 'PatientID');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'PatientID', 'PatientID');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class, 'PatientID', 'PatientID');
    }

    public function latestAdmission()
    {
        // Add 'AdmissionID' inside the parentheses
        return $this->hasOne(Admission::class, 'PatientID', 'PatientID')->latestOfMany('AdmissionID');
    }

    public function getStatusAttribute(): string
    {
        $latest = $this->latestAdmission;
        return $latest ? $latest->Status : 'Outpatient';
    }

    public function getBedAndWardAttribute(): string
    {
        $latest = $this->latestAdmission;
        if ($latest && $latest->Status === 'Admitted') {
            $ward = $latest->ward ? $latest->ward->WardName : 'N/A';
            return "{$latest->BedNumber} & {$ward}";
        }
        return 'N/A';
    }
}
