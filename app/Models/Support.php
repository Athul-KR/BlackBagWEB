<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Support extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    public function supportType()
    {
        return $this->belongsTo(RefSupportType::class, 'type_id');
    }
}
