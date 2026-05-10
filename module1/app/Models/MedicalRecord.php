<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $primaryKey = 'RecordID';

    protected $fillable = [
        'PatientID', 'Diagnosis', 'Treatment', 'RecordDate', 'Notes',
    ];

    protected $casts = [
        'RecordDate' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }
}
