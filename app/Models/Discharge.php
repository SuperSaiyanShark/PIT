<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discharge extends Model
{
    use HasFactory;

    protected $table = 'discharge';
    protected $primaryKey = 'dischargeid';

    protected $fillable = [
        'admissionid',
        'dischargedate',
        'discharge_notes',
        'discharge_type',
        'discharged_by',
    ];

    protected function casts(): array
    {
        return [
            'dischargedate' => 'datetime',
        ];
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admissionid', 'admissionid');
    }

    public function dischargedByStaff()
    {
        return $this->belongsTo(User::class, 'discharged_by', 'id');
    }
}
