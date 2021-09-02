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

        $order_ach = \App\Order::where('user_id',\Auth::user()->id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')->get();

        $cust_total = \App\Customer::where('user_id',\Auth::user()->id)->count();
        $order = \App\Order::where('user_id',\Auth::user()->id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->distinct()->get(['customer_id'])->count();

        $pareto = \App\CatPareto::where('client_id',(auth()->user()->client_id))
                 ->orderBy('position','ASC')
                 ->get();

        $cust_not_exists = \App\Customer::whereNotExists(function($q) use($user_id,$month,$year)
                {
                    $q->select(\DB::raw(1))
                            ->from('orders')
                            ->whereRaw('orders.customer_id = customers.id')
                            ->where('user_id','=',"$user_id")
                            ->whereMonth('created_at', '=', $month)
                            ->whereYear('created_at', '=', $year)
                            ->where('status','!=','CANCEL');
                            
                })
                ->where('client_id',\Auth::user()->client_id)
                ->whereNotNull('pareto_id')
                ->where('user_id',$user_id)->get();

        //dd($cus_not_exists);
        $cust_exists = \App\Customer::whereHas('orders', function($q) use($user_id,$month,$year)
                {
                    return $q->where('user_id','=',"$user_id")
                            ->whereNotNull('customer_id')
                            ->whereMonth('created_at', '=', $month)
                            ->whereYear('created_at', '=', $year)
                            ->where('status','!=','CANCEL')
                            ->groupBy('customer_id');
                })
                ->where('client_id',\Auth::user()->client_id)
                ->whereNotNull('pareto_id')
                ->get();

        //target pareto
        $period_par = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                     ->where('period','<=',$date_now)
                     ->max('period');
        //dd($period_par);
            
        //--hari berjalan
        $work_plan = \App\WorkPlan::where('client_id',\Auth::user()->client_id)
                    ->whereMonth('work_period', '=', $month)
                    ->whereYear('work_period', '=', $year)->first();

        //$tgl = date('d');
        //$jumHari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        //$day = (int)$tgl;
        //$param_line = round((($day/(int)$jumHari) * 100) ,2);
        
        if($work_plan){
            $day_off = \App\Holiday::where('wp_id',$work_plan->id)
                  ->where('date_holiday','<=',$date_now)->count();
            $tgl = date('d');
            $day = (int)$tgl;
            $hari_berjalan = $day-$day_off;
            $param_line = round((($hari_berjalan/$work_plan->working_days) * 100) ,2);
            //dd(json_encode($red_line));
        }else{
            $day_off = null;
            $param_line = 0;
        }
        
        //dd($day);
        //$current_day = date('d');
        //$work_current = $current_day - $day_off;
        //dd($work_plan->working_days);

       $cartuser = \App\Sales_Targets::where('client_id',\Auth::user()->client_id)
                        ->whereMonth('period', '=', $month)
                        ->whereYear('period', '=', $year)
                        ->orderBy('user_id', 'ASC')->get();
                        //->pluck('user_id');
        
        $user_value=[];
        $percentage=[];
        $red_line = [];
        foreach ($cartuser as $userval) {
            $user_value[]= $userval->users->name;
            $targ_ach = \App\Order::where('user_id',$userval->user_id)
                        ->whereNotNull('customer_id')
                        ->where('status','!=','CANCEL')
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->selectRaw('sum(total_price) as sum')
                        ->pluck('sum');
            $ach = json_decode($targ_ach,JSON_NUMERIC_CHECK);
            $ach_value_ppn = $ach[0];
            if($userval->ppn == 1){
                $ach_value = $ach_value_ppn/1.1;
            }else{
                $ach_value = $ach_value_ppn;
            }            
            $percentage[]= round(($ach_value / $userval->target_values) * 100 ,2);
            $red_line[]= $param_line;
        }
        $users_display = array_unique($user_value);
        //$percentcart = json_encode($percentage);
        //dd($users_display);
        //dd($red_line);
        
        /* target order ---

        //---Target & Ach chart yearly----//
        $target_order = \App\Sales_Targets::where('user_id',\Auth::user()->id)
                        ->whereYear('period', '=', $year)
                        ->orderBy('period', 'ASC')
                        ->pluck('target_values');

        $target_ach = \App\Sales_Targets::where('user_id',\Auth::user()->id)
                        ->whereYear('period', '=', $year)
                        ->orderBy('period', 'ASC')
                        ->pluck('target_achievement');

        $month_ach = \App\Sales_Targets::where('user_id',\Auth::user()->id)
                        ->whereYear('period', '=', $year)
                        ->orderBy('period', 'ASC')
                        ->pluck('period');
       
        $month_value=[];
        foreach ($month_ach as $key => $monthval) {
            $month_value[] = date('F',strtotime($monthval));
            }
        $months = array_unique($month_value);
        //dd($months);
        ===============////==================

        //target order ---
        $order_ach = \App\Order::where('user_id',\Auth::user()->id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')->get();
        end target order---*/
        
        /*---order chart month----
        $order_chart = \App\Order::where('user_id',\Auth::user()->id)
                ->whereNotNull('customer_id')
                ->where('status','!=','CANCEL')
                ->whereYear('created_at', $year)
                ->groupBy(\DB::raw("Month(created_at)"))
                ->selectRaw('sum(total_price) as sum')
                ->pluck('sum');

        $order_month = \App\Order::where('user_id',\Auth::user()->id)
                ->whereNotNull('customer_id')
                ->where('status','!=','CANCEL')
                ->whereYear('created_at', $year)
                ->groupBy(\DB::raw("Month(created_at)"))
                ->pluck('created_at');
            
            
            
            $month_value=[];
            foreach ($order_month as $key => $monthval) {
                $month_value[] = date('F',strtotime($monthval));
             }
            $months = array_unique($month_value);
        end order chart month----*/   
        
        $data=
            [
            'vendor'=>$vendor, 
            'client'=>$client,
            'paket'=>$paket,
            'cust_total'=>$cust_total,
            'target'=>$target,
            'order'=>$order,
            'order_ach'=>$order_ach,
            'cust_exists'=>$cust_exists,
            'cust_not_exists'=>$cust_not_exists, 
            'pareto'=>$pareto,
            'period_par'=>$period_par,
            'work_plan'=>$work_plan,
            'day_off'=>$day_off,
            'param_line'=>$param_line,
            //'order_chart'=>$order_chart
            ];
        
        return view('customer.dashboard',$data) ->with('percent',json_encode($percentage,JSON_NUMERIC_CHECK))
                                                ->with('users_display',json_encode($users_display))
                                                ->with('red_line',json_encode($red_line));
                                                /*
                                                ->with('target_order',json_encode($target_order,JSON_NUMERIC_CHECK))
                                                ->with('months',json_encode($months))
                                                ->with('target_ach',json_encode($target_ach,JSON_NUMERIC_CHECK));*/
    }
}
