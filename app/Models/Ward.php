<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $table = 'wards';

    protected $primaryKey = 'allocationid';

    public $incrementing = true;

    protected $fillable = [
        'wardName',
        'wardNumber',
        'capacity',
        'location',
        'allocationid'
    ];

    public function beds()
    {
        return $this->hasMany(Bed::class, 'wardNumber', 'wardNumber');
    }
}