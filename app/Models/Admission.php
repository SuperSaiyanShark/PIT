<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'patient_id',
        'ward_id',
        'bed_number',
        'date_on_waiting_list',
        'expected_stay_days',
        'date_admitted',
        'date_expected_leave',
        'date_actual_leave',
        'discharge_notes',
    ];

    protected $casts = [
        'date_on_waiting_list' => 'date',
        'date_admitted'        => 'date',
        'date_expected_leave'  => 'date',
        'date_actual_leave'    => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
