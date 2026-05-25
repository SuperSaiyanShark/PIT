<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['firstname', 'lastname', 'dob', 'sex', 'address', 'phonenumber', 'dateregistered'])]
class Patient extends Model
{
    protected $table = 'patient';
    protected $primaryKey = 'patient_no';
    public $timestamps = false;

    public function admissions()
    {
        return $this->hasMany(Admission::class, 'patient_no', 'patient_no');
    }

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
