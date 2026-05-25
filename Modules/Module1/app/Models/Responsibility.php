<?php

namespace Modules\Module1\app\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['staff_id', 'department_id', 'ward_id', 'patient_id', 'responsibility_type', 'description', 'status', 'start_date', 'end_date'])]
class Responsibility extends Model
{
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function staff()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
