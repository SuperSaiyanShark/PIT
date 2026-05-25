<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['wardid', 'bednumber', 'status'])]
class Bed extends Model
{
    protected $table = 'bed';
    protected $primaryKey = 'bedid';
    public $timestamps = false;

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'wardid', 'id');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class, 'bedid', 'bedid');
    }
}