<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicNurse extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function nurses()
    {
        return $this->belongsTo(Nurse::class,  'clinic_nurse_uuid', 'nurse_uuid');
    }
}
