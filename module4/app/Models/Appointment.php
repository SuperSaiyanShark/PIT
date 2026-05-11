<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'appointment_date',
        'appointment_time',
        'patient_type',
        'reason_for_visit',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
