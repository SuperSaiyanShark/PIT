<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'appointment_date',
        'appointment_time',
        'patient_type',
        'reason_for_visit',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'appointment_time' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
