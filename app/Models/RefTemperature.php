<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;
use DB;

class RefTemperature extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ref_temperature';
    public static function getTemparatreTypes(){

        $Corefunctions = new \App\customclasses\Corefunctions;
        $temperature = $Corefunctions->convertToArray(self::whereNull('deleted_at')->get());
        return $temperature;
        
	}
}
