<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ward extends Model
{
    protected $table = 'wards';
    protected $primaryKey = 'allocationid';
    public $incrementing = false; // Because allocationid is a string
    protected $keyType = 'string';

    protected $fillable = [
        'allocationid',
        'wardNumber',
        'wardName',
        'location',
        'capacity',
        'telExtn'
    ];

    public $timestamps = false;

    public function beds()
    {
        // 2nd param: the foreign key on the 'beds' table
        // 3rd param: the local key on the 'wards' table
        return $this->hasMany(Bed::class, 'wardNumber', 'wardNumber');
    }

    public function staff()
    {
        // Use 'WardID' if that's the pivot column name, or 'wardNumber' if matching ERD
        return $this->belongsToMany(Staff::class, 'ward_staff_allocation', 'WardID', 'StaffID');
    }

    public function patients()
    {
        // Updated to use the correct case-sensitive column name
        return $this->belongsToMany(Patient::class, 'patient_allocation', 'wardNumber', 'PatientID');
    }

    public function getRouteKeyName()
    {
        return 'allocationid';
    }
}