<?php

namespace Modules\Module4\app\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\User;

class Treatment extends Model
{
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'user_id',
        'treatment_name',
        'description',
        'treatment_date',
        'treatment_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'treatment_date' => 'date',
        'treatment_time' => 'time',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
