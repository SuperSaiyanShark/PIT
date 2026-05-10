<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $primaryKey = 'AdmissionID';

    protected $fillable = [
        'PatientID', 'WardID', 'BedNumber', 'AdmissionDate',
        'DischargeDate', 'Status', 'DischargeNotes',
    ];

    protected $casts = [
        'AdmissionDate' => 'date',
        'DischargeDate' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'WardID', 'WardID');
    }
}
