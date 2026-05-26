<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalKit extends Model
{
    use HasFactory;

    protected $table = 'hospital_kit';
    protected $primaryKey = 'kitid';

    protected $fillable = [
        'kit_name',
        'description',
        'kit_type',
        'quantity',
        'location',
        'status',
        'last_checked',
    ];

    protected function casts(): array
    {
        return [
            'last_checked' => 'datetime',
        ];
    }

    public function nurseKits()
    {
        return $this->hasMany(NurseKit::class, 'kit_id', 'kitid');
    }
}
