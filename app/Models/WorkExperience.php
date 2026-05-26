<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $table = 'work_experience';
    protected $primaryKey = 'experienceid';

    protected $fillable = [
        'staff_id',
        'organization_name',
        'position',
        'start_date',
        'end_date',
        'responsibilities',
        'employment_type',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
}
