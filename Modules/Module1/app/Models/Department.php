<?php

namespace Modules\Module1\app\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'head_id', 'building', 'phone'])]
class Department extends Model
{
    public function head()
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class);
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
