<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseKit extends Model
{
    use HasFactory;

    protected $table = 'nurse_kits';
    protected $primaryKey = 'nursekitid';

    protected $fillable = [
        'staff_id',
        'kit_id',
        'assigned_date',
        'returned_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'assigned_date' => 'datetime',
            'returned_date' => 'datetime',
        ];
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

    public function kit()
    {
        return $this->belongsTo(HospitalKit::class, 'kit_id', 'kitid');
    }
}
