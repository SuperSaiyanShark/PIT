<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedPatientCare extends Model
{
    use HasFactory;

    protected $table = 'assigned_patient_care';
    protected $primaryKey = 'assignmentid';

    protected $fillable = [
        'admissionid',
        'staff_id',
        'assignment_date',
        'end_date',
        'care_notes',
        'care_type',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'assignment_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admissionid', 'admissionid');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
}
