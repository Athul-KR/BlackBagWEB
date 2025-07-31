<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class RefConsultationTime extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ref_consultation_times';

    
    public static function getConsultationTime()
    {
        return self::whereNull('deleted_at')->orderBy('id','asc')->get();
    }

  
    public static function getConsultationTimeById($id)
    {
        return self::where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }

   
} 