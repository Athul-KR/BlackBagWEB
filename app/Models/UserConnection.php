<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;

class UserConnection extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'user_connections';

    public static function insertUserConnection($userId,$connectionID,$clinicId){
      
        $Id =  DB::table('user_connections')->insertGetId(array(
            'user_id'       =>  $userId,	  		  
            'connection_id' =>  $connectionID,	 
            'clinic_id' 	=> $clinicId,
            'status'	    =>  '1' ,
            'created_at'     => Carbon\Carbon::now()
        ));
        return $Id;
    }
    public static function updateUserConnection($connectionID){

        DB::table('user_connections')->where('connection_id',$connectionID)->update(array(
            'status'	    =>  '0' ,
            'created_at'     => Carbon\Carbon::now()
        ));

      
        return ;
    }
}
