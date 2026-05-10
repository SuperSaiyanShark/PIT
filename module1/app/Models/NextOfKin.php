<?php
// app/Models/NextOfKin.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    protected $table = 'next_of_kins';
    protected $primaryKey = 'NOKID';

    protected $fillable = [
        'PatientID', 'FullName', 'Relationship', 'Address', 'PhoneNumber',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }
}
