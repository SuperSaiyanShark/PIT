<?php

namespace Modules\Module1\app\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'diagnosis',
        'treatment',
        'record_date',
        'notes',
    ];

    protected $casts = [
        'record_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
