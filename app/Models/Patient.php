<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'sex',
        'marital_status',
        'address',
        'phone_number',
        'email',
        'blood_type',
        'allergies',
        'medical_conditions',
        'date_registered',
    ];

    protected $casts = [
        'date_of_birth'   => 'date',
        'date_registered' => 'date',
    ];

    public function nextOfKin()
    {
        return $this->hasOne(NextOfKin::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function latestAdmission()
    {
        return $this->hasOne(Admission::class)->latestOfMany();
    }

    // Computed: age
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : 0;
    }

    // Computed: full name
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Computed: status
    public function getStatusAttribute(): string
    {
        $latest = $this->latestAdmission;
        if ($latest && is_null($latest->date_actual_leave)) {
            return 'Admitted';
        }
        return 'Outpatient';
    }
}
