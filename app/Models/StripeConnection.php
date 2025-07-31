<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StripeConnection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stripe_connections';

    /**
     * Retrieve Stripe connection information for a given user ID.
     *
     * @param int $userId The ID of the user
     * @return array|null Stripe connection data or null if not found
     */
    public static function getStripeConnectionInfo($id)
    {
        return self::where('id', $id)
            ->select('id', 'stripe_user_id', 'status', 'deleted_at')
            ->withTrashed()
            ->orderBy('created_at', 'desc') // Order by `created_at` in descending order
            ->first()
            ?->toArray();
    }
}