<?php

namespace Modules\Module1\app\Models;

use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    protected $table = 'next_of_kins';

    protected $fillable = [
        'patient_id',
        'full_name',
        'relationship',
        'address',
        'phone_number',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
