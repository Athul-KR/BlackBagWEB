<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefSupportType extends Model
{
    use HasFactory, SoftDeletes;


    protected $guarded = [];


    public function support()
    {
        return $this->hasOne(Support::class, 'type_id', 'id');
    }
}
