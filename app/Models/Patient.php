<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['first_name', 'last_name', 'ward_id', 'allocation_id', 'date_admitted', 'expected_duration', 'date_expected_leave', 'status'])]
class Patient extends Model
{
    protected function casts(): array
    {
        return [
            'date_admitted' => 'date',
            'date_expected_leave' => 'date',
        ];
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
