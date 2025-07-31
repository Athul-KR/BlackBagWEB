<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Impersonate extends Model
{
    use SoftDeletes;

    protected $guarded = [];


    public static function getImpersonateData($uuid)
    {
        return self::where('impersonate_uuid', $uuid)
            ->where(function ($query) {
                $query->where('is_used', '!=', '1')
                    ->orWhereNull('is_used');
            })
            ->first();
    }
    public static function getImpersonateUser($data)
    {
        return User::where('id', $data['user_id'])->first();
    }
}
