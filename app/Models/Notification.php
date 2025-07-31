<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    public static function notificationByKey($key)
    {
        $notifications =  DB::table('notifications')->where('notification_uuid', $key)->first();
        return $notifications;
    }

    public static function getNotifications($filterBy = null, $limit = 10)
    {
        $query = self::where('user_id', session()->get('user.userID'))
            ->where('clinic_id', session()->get('user.clinicID'))
            ->whereNull('deleted_at');

        if ($filterBy === 'week') {
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();
            $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
        } elseif ($filterBy === 'today') {
            $startOfDay = now()->startOfDay();
            $endOfDay = now()->endOfDay();
            $query->whereBetween('created_at', [$startOfDay, $endOfDay]);
        }

        $notifications = $query->orderBy('id', 'desc')->paginate($limit);
        return $notifications;
    }

    public static function getNotificationCount()
    {
        $notificationCount = DB::table('notifications')->where('user_id',session()->get('user.userID'))->where('clinic_id',session()->get('user.clinicID'))->whereNull('deleted_at')->orderBy('id','desc')->count();
        return $notificationCount;
    }

    public static function clearNotifications($userId, $clinicId)
    {
        DB::table('notifications')->where('user_id', $userId)
            ->where('clinic_id', $clinicId)
            ->whereNull('deleted_at')
            ->update(array(
                'is_read' => '1'
            ));
    }
    public static function markAsRead($key)
    {
        DB::table('notifications')->where('notification_uuid', $key)->update(array(
            'is_read' => '1',
        ));
    }
}
