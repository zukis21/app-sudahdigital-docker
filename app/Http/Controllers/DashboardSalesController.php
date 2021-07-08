<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardSalesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $param = \Route::current()->parameter('vendor');
            //dd($param);
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            //dd($client->client_slug);
            if($client->client_slug == $param){
                
                //dd(\Request::session()->get('client_sess'));
                return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index($vendor){
        $user_id = \Auth::user()->id;
        $date_now = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
        
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        $paket = \App\Paket::where('client_id',\Auth::user()->client_id)->first();
        $target = \App\Sales_Targets::where('user_id',\Auth::user()->id)
                ->whereMonth('period', '=', $month)
                ->whereYear('period', '=', $year)
                ->first();
        $cust_total = \App\Customer::where('user_id',\Auth::user()->id)->count();
        $order = \App\Order::where('user_id',\Auth::user()->id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->distinct()->get(['customer_id'])->count();
       
        $order_ach = \App\Order::where('user_id',\Auth::user()->id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')->get();
        
        $cus_not_exists = \App\Customer::whereNotExists(function($q) use($user_id,$month,$year)
                {
                    $q->select(\DB::raw(1))
                            ->from('orders')
                            ->whereRaw('orders.customer_id = customers.id')
                            ->where('user_id','=',"$user_id")
                            ->whereMonth('created_at', '=', $month)
                            ->whereYear('created_at', '=', $year)
                            ->where('status','!=','CANCEL');
                            
                })
                ->where('user_id',$user_id)->get();
        //dd($cus_not_exists);
        $cus_exists = \App\Customer::whereHas('orders', function($q) use($user_id,$month,$year)
                {
                    return $q->where('user_id','=',"$user_id")
                            ->whereNotNull('customer_id')
                            ->whereMonth('created_at', '=', $month)
                            ->whereYear('created_at', '=', $year)
                            ->where('status','!=','CANCEL')
                            ->groupBy('customer_id');
                })
                ->get();
        
        $order_chart = \App\Order::where('user_id',\Auth::user()->id)
                ->whereNotNull('customer_id')
                ->where('status','!=','CANCEL')
                ->whereYear('created_at', $year)
                ->groupBy(\DB::raw("Month(created_at)"))
                ->selectRaw('sum(total_price) as sum')
                ->pluck('sum');
        
       //dd($order_chart);
        $data=
            [
            'vendor'=>$vendor, 
            'client'=>$client,
            'paket'=>$paket,
            'cust_total'=>$cust_total,
            'target'=>$target,
            'order'=>$order,
            'order_ach'=>$order_ach,
            'cust_exists'=>$cus_exists,
            'cust_not_exists'=>$cus_not_exists,
            'order_chart'=>$order_chart
            ];
        
        return view('customer.dashboard',$data);
    }
}
