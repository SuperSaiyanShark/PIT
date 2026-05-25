<?php

namespace Modules\Module3\app\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['staff_id', 'start_date', 'end_date', 'shift_type', 'status', 'notes'])]
class Schedule extends Model
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
}
