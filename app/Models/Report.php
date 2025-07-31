<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;
use DB;

class Report extends Model
{
    use HasFactory, SoftDeletes;
    public static function getClinicPayments($startDate,$endDate){
        $clinicId = session()->get('user.clinicID');
        $query = Payment::select('payments.*', 'transactions.clinic_id')
            ->join('transactions', 'transactions.id', '=', 'payments.transaction_id')
            ->whereIn('payments.parent_type', ['subscription','appointment','no_show_fee','cancellation_fee'])
            ->where('transactions.clinic_id', $clinicId)
            ->with('user','patientUser');

        if (isset($startDate) && $startDate != '' && isset($endDate) && $endDate != '') {
            $query->whereBetween('payments.created_at', [$startDate, $endDate]);
        } elseif (isset($startDate) && $startDate != '') {
            $query->whereDate('payments.created_at', '>=', $startDate);
        } elseif (isset($endDate) && $endDate != '') {
            $query->whereDate('payments.created_at', '<=', $endDate);
        }

        $perPage = request()->get('perPage', 10);

        $reportData = $query->orderBy('payments.id', 'desc')->paginate($perPage)->appends([
            'start_date' => request()->get('start_date'),
            'end_date' => request()->get('end_date'),
            'perPage' => request()->get('perPage', 10),
        ]);

        return [
            'perPage' => $perPage,
            'reportData' => $reportData,
        ];
    }
}