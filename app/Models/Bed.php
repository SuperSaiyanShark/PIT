<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $table = 'beds'; // Explicitly set table name
    // Update app/Models/Bed.php
    protected $fillable = [
        'bedNumber',
        'wardNumber',
        'status',
        'patient_name',  
        'is_occupied',   
    ];
    public function ward()
    {
        // Ensure both foreign and local keys use 'wardNumber' to match the SQL above
        return $this->belongsTo(Ward::class, 'wardNumber', 'wardNumber');
    }

    public function patient()
    {
        // If a bed belongs to one patient
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}