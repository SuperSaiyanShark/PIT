<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'department_id', 'floor', 'capacity', 'ward_head_id'])]
class Ward extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function head()
    {
        return $this->belongsTo(User::class, 'ward_head_id');
    }

    public function staff()
    {
        return $this->hasMany(User::class);
    }

    public function responsibilities()
    {
        return $this->hasMany(Responsibility::class);
    }
}
