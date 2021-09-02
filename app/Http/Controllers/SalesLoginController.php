<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LoggedinSalesExport;

class SalesLoginController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $param = \Route::current()->parameter('vendor');
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            if($client->client_slug == $param){
                if(session()->get('client_sess')== null){
                    \Request::session()->put('client_sess',
                    ['client_name' => $client->client_name,'client_image' => $client->client_image]);
                }
                if(Gate::allows('sales-login')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index($vendor){
        $year = date('Y');
        $month = date ('m');
        $day = date ('d');
        $saleslogin = \App\LoginRecord::where('client_id',auth()->user()->client_id)
                ->whereYear('logged_in',$year)
                ->whereMonth('logged_in',$month)
                ->whereDay('logged_in',$day)
                ->orderBy('logged_in','DESC')
                ->get();
        $users = \App\User::where('roles','=','SALES')
                ->where('client_id','=',auth()->user()->client_id)
                ->get();
        return view ('workplan.login_list',['saleslogin'=>$saleslogin,'vendor'=>$vendor,'users'=>$users]);
    }

    public function filter_login(Request $request, $vendor, $period, $user_name = null, $user_id){
        $date_explode = explode('-',$period);
        $year = $date_explode[0];
        $month = $date_explode[1];
        $sales_id = \Crypt::decrypt($user_id);
        $saleslogin = \App\LoginRecord::where('client_id',auth()->user()->client_id)
                ->where('user_id',$sales_id)
                ->whereYear('logged_in',$year)
                ->whereMonth('logged_in',$month)
                ->orderBy('logged_in','DESC')
                ->get();
        $users = \App\User::where('roles','=','SALES')
                ->where('client_id','=',auth()->user()->client_id)
                ->get();
        return view ('workplan.login_list',['saleslogin'=>$saleslogin,
                                            'vendor'=>$vendor,
                                            'users'=>$users,
                                            'user_id'=>$sales_id,
                                            'period'=>$period]);
    }

    public function export(Request $request) 
    {   
        $period = $request->get('period');
        $date_explode = explode('-',$period);
        $year = $date_explode[0];
        $month = $date_explode[1];

        return Excel::download(new LoggedinSalesExport($year, $month), 'Logged_in_records.xlsx');
    }
}
