<?php

namespace App\Http\Controllers\clinics;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Report;
use Session;
use DB;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\Route;

class RevenueReportController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        if (!Session::has('user')) {
            return Redirect::to('/login');
        }
        if(session()->get('user.userType') != 'clinics' ){
            return Redirect::to('/dashboard');
        }

    }
    public function listing()
    {
        if(session()->get('user.userType') != 'clinics' ){
            return Redirect::to('/dashboard');
        }
        $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;
        if (isset($_GET['start_date']) && $_GET['start_date'] != '') {
            $startDate = Carbon::createFromFormat('m/d/Y', $_GET['start_date'])->format('Y-m-d');
        }else{
            $startDate = '';
        }

        if (isset($_GET['end_date']) && $_GET['end_date'] != '') {
            $endDate = Carbon::createFromFormat('m/d/Y', $_GET['end_date'])->format('Y-m-d');
        }else{
            $endDate = '';
        }
        
        $reports = Report::getClinicPayments($startDate,$endDate);
        $data['reportData'] = $reports['reportData'];
        $data['perPage'] = $reports['perPage'];
        $data['limit'] = $limit;

        return view('revenuereports.listing',$data);
    }
}