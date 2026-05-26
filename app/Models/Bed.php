<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    protected $table = 'beds';

    protected $fillable = [
        'bedNumber',
        'wardNumber',
        'status',
        'patient_name',
        'is_occupied'
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'wardNumber', 'wardNumber');
    }
}