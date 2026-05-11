<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'permissions'])]
class StaffRole extends Model
{
    protected function casts(): array
    {
        return [
            'permissions' => 'array',
        ];
    }

    public function staff()
    {
        return $this->hasMany(User::class);
    }
}
