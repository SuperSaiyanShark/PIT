<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $primaryKey = 'WardID';

    protected $fillable = [
        'WardName', 'Location', 'TotalBeds',
    ];

    public function admissions()
    {
        return $this->hasMany(Admission::class, 'WardID', 'WardID');
    }

    public function getOccupiedBedsAttribute(): int
    {
        return $this->admissions()->where('Status', 'Admitted')->count();
    }

    public function getAvailableBedsAttribute(): int
    {
        return max(0, $this->TotalBeds - $this->occupied_beds);
    }
}
