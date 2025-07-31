<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicConsultant extends Model
{
    use HasFactory, SoftDeletes;


    public function clinicConsultant()
    {
        return $this->belongsTo(Consultant::class,  'id', 'consultant_id');
    }
}
