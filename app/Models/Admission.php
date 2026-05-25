<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $table = 'admission';
    protected $primaryKey = 'admissionid';
    
    // FIXED: Tell Eloquent not to expect auto-increment keys from the DB layer
    public $incrementing = false; 
    public $timestamps = false;

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_no', 'patient_no');
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class, 'bedid', 'bedid');
    }

    public function ward()
    {
        return $this->bed()->ward();
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'Staff_no', 'id');
    }

    public function isActive()
    {
        return is_null($this->dischargedate);
    }
}