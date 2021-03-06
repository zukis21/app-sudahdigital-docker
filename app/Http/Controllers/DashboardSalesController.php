<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
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
        //parameter pareto period
        $period_par = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                ->where('period','<=',$date_now)
                ->max('period');
        
        
        $order_ach = \App\Order::where('user_id',\Auth::user()->id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->get();

        $cust_total = \App\Customer::where('user_id',\Auth::user()->id)->count();
        $order = \App\Order::where('user_id',\Auth::user()->id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
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
                            ->where('status','!=','CANCEL')
                            ->where('status','!=','NO-ORDER');
                            
                })
                ->whereHas('store_targets', function ($query) use($period_par) {
                    return $query->where('period', $period_par)
                    ->where('client_id',\Auth::user()->client_id)
                    ->whereNotNull('version_pareto');
                })
                ->where('client_id',\Auth::user()->client_id)
                ->where('user_id',$user_id)->get();
        //dd($cus_not_exists);

        $cust_exists = \App\Customer::whereHas('orders', function($q) use($user_id,$month,$year)
                {
                    return $q->where('user_id','=',"$user_id")
                            ->whereNotNull('customer_id')
                            ->whereMonth('created_at', '=', $month)
                            ->whereYear('created_at', '=', $year)
                            ->where('status','!=','CANCEL')
                            ->where('status','!=','NO-ORDER')
                            ->groupBy('customer_id');
                })
                ->whereHas('store_targets', function ($query) use($period_par) {
                    return $query->where('period', $period_par)
                    ->where('client_id',\Auth::user()->client_id)
                    ->whereNotNull('version_pareto');
                })
                ->where('client_id',\Auth::user()->client_id)
                //->whereNotNull('pareto_id')
                ->get();

        //order > 5 days
        $from = date('2021-06-01');
        $order_minday = date('Y-m-d', strtotime("-5 day", strtotime(date("Y-m-d"))));
        $order_overday = \App\Order::where('user_id',\Auth::user()->id)
                        ->whereNotNull('customer_id')
                        ->whereBetween('created_at', [$from,$order_minday])
                        ->where(function($qr) {
                            $qr->where('status','=','SUBMIT')
                            ->orWhere('status','=','PROCESS')
                            ->orWhere('status','=','PARTIAL-SHIPMENT');
                        })
                        ->orderBy('created_at','DESC')
                        ->get();
        
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

        $cartuser = \App\Sales_Targets::whereHas('users', function($q){
                            $q->where('status','ACTIVE');
                        })
                        ->where('client_id',\Auth::user()->client_id)
                        ->whereMonth('period', '=', $month)
                        ->whereYear('period', '=', $year)
                        ->orderBy('user_id', 'ASC')->get();
                        //->pluck('user_id');
        
        $user_value=[];
        $percentage=[];
        $percentage_qty=[];
        $red_line = [];
        foreach ($cartuser as $userval) {
            $user_value[]= $userval->users->name;
            
            //total order qty
            $targ_ach_qty = \App\Order::with('products')
                    ->where('user_id',$userval->user_id)
                    ->whereNotNull('customer_id')
                    ->where('status','!=','CANCEL')
                    ->where('status','!=','NO-ORDER')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)->get();
            $qty = $targ_ach_qty->sum('TotalQuantity');
            
                       
            //total order nominal
            $targ_ach = \App\Order::where('user_id',$userval->user_id)
                        ->whereNotNull('customer_id')
                        ->where('status','!=','CANCEL')
                        ->where('status','!=','NO-ORDER')
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->get();
                        /*->selectRaw('sum(total_price) as sum')
                        ->pluck('sum');*/
            $targ_ach_total = 0;       
            foreach( $targ_ach as $orderTargAch){
                $PriceTotal = \App\Http\Controllers\TransaksiSalesController::cekDiscountVolume($orderTargAch->id);
                $targ_ach_total +=  $PriceTotal;
            }

            $ach_value = $targ_ach_total/1.1;
            //$ach = json_decode($targ_ach,JSON_NUMERIC_CHECK);
            //$ach_value_ppn = $ach[0];
            /*$ach_value_ppn = $targ_ach_total;
            if($userval->ppn == 1){
                $ach_value = $ach_value_ppn/1.1;
            }else{
                $ach_value = $ach_value_ppn;
            }*/

            
            if($userval->target_values > 0){
                $percentage[]= round(($ach_value / $userval->target_values) * 100 ,2);
            }else{
                $percentage[]= 0;
            }
            if($userval->target_quantity > 0){
                $percentage_qty[]= round(($qty / $userval->target_quantity) * 100 ,2);
            }else{
                $percentage_qty[]=0;
            }

            $red_line[]= $param_line;
        }
        $users_display = array_unique($user_value);
        //dd($percentage);
        //==========max average yearly nominal=============/
        if($year < 2022){
            $mxx = [];
            for($i=6;$i<13;$i++){
                $mxx[] = \DB::select("SELECT AVG(total) as total_average
                            FROM
                            (
                                SELECT created_at , user_id, SUM(total_price) AS total
                                FROM orders WHERE user_id = '$user_id' 
                                AND month(created_at)= '$i'
                                AND Year(created_at)='$year'
                                AND status != 'CANCEL'
                                AND customer_id IS NOT NULL
                                GROUP BY DATE(created_at) 
                                ORDER BY total
                            ) as inner_query;");
                
            }
        }else{
            $mxx = [];
            for($i=1;$i<13;$i++){
                $mxx[] = \DB::select("SELECT AVG(total) as total_average
                    FROM
                    (
                        SELECT created_at , user_id, SUM(total_price) AS total
                        FROM orders WHERE user_id = '$user_id' 
                        AND month(created_at)= '$i'
                        AND Year(created_at)='$year'
                        AND status != 'CANCEL'
                        AND customer_id IS NOT NULL
                        GROUP BY DATE(created_at) 
                        ORDER BY total 
                    ) as inner_query;");
                
            }
        }
        $collect_average =  max($mxx);
        $max=0;
        foreach($collect_average as $mx){
            $max = $mx->total_average;
        }
        //ppn max day/ per day
        if($target && $target->ppn == 1){
            $max_av = $max/1.1;
            //$get_per_day = round(($get_daily/1.1),2);
        }else{
            $max_av = $max;
           //$get_per_day = round($get_daily,2);
        }
        //=============end max average yearly===============//
        
        //=======daily achievement=====//
        /*$daily_ach = \App\Order::where('user_id',$user_id)
                        ->whereNotNull('customer_id')
                        ->where('status','!=','CANCEL')
                        ->whereRaw('DATE(created_at) = ?', [$date_now])
                        ->selectRaw('sum(total_price) as sum')
                        ->pluck('sum');
        if($daily_ach == NULL){
            $get_daily = 0;
        }else{
            $daily_ach_value = json_decode($daily_ach,JSON_NUMERIC_CHECK);
            $get_daily = $daily_ach_value[0];
        }*/
        

        //================max daily==============//
        /*$max_daily = \DB::select("SELECT  SUM(total_price) AS total
                        FROM orders WHERE user_id = '$user_id' 
                        AND month(created_at)= '$month' 
                        AND Year(created_at)='$year'
                        AND status != 'CANCEL'
                        AND customer_id IS NOT NULL
                        GROUP BY DATE(created_at) 
                        ORDER BY total DESC LIMIT 1");
        //dd($max_daily);
        $max=0;
        foreach($max_daily as $mx){
            $max = $mx->total;
        }
        //ppn max day/ per day
        if($target && $target->ppn == 1){
            $max_day = $max/1.1;
            //$get_per_day = round(($get_daily/1.1),2);
        }else{
            $max_day = $max;
           //$get_per_day = round($get_daily,2);
        }*/
        
        //dd($max_day);
        /* target order ---
        //===========Target & Ach chart yearly=============//
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
            'order_overday'=>$order_overday,
            'max_av'=>$max_av,
            //'order_chart'=>$order_chart
            ];
        
        return view('customer.dashboard',$data) ->with('percent',json_encode($percentage,JSON_NUMERIC_CHECK))
                                                ->with('percent_qty',json_encode($percentage_qty,JSON_NUMERIC_CHECK))
                                                ->with('users_display',json_encode($users_display))
                                                ->with('red_line',json_encode($red_line));
                                                //->with('get_per_day',json_encode($get_per_day))
                                                //->with('max_day',json_encode($max_day));
                                                /*
                                                ->with('target_order',json_encode($target_order,JSON_NUMERIC_CHECK))
                                                ->with('months',json_encode($months))
                                                ->with('target_ach',json_encode($target_ach,JSON_NUMERIC_CHECK));*/
    }

    
    public static function total_pareto($user_id,$pareto_id){
        /*$cust_total_p = \App\Customer::where('user_id',$user_id)
                                      ->where('pareto_id',$prt->id)
                                      ->count();*/
        $date_now = date('Y-m-d');
        $period_par = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                     ->where('period','<=',$date_now)
                     ->max('period');
        //dd($period_par);
        $count_pareto = \App\Store_Targets::whereHas('customers', function($q) use ($user_id){
                            return $q->where('user_id',$user_id);
                        })
                        ->where('version_pareto',$pareto_id)
                        ->where('client_id',\Auth::user()->client_id)
                        ->where('period',$period_par)->count();

        return $count_pareto;
    }

    public static function amountParetoOrder($user_id,$month,$year,$pareto_id){
        /*$cust_exists_p = \App\Customer::whereHas('orders', function($q) use($user_id,$month,$year)
                                      {
                                          return $q->where('user_id','=',"$user_id")
                                                  ->whereNotNull('customer_id')
                                                  ->whereMonth('created_at', '=', $month)
                                                  ->whereYear('created_at', '=', $year)
                                                  ->where('status','!=','CANCEL')
                                                  ->where('status','!=','NO-ORDER')
                                                  ->groupBy('customer_id');
                                      })
                                      ->where('pareto_id',$prt->id)
                                      ->get();*/
        $client_id = \Auth::user()->client_id;
        $date_now = date('Y-m-d');
        $period_par = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                     ->where('period','<=',$date_now)
                     ->max('period');
        //dd($period_par);
        $cust_exists_p = \DB::select("SELECT ts.client_id, ts.customer_id, ts.period, ts.version_pareto FROM store_target as ts
                        WHERE 
                        ts.period ='$period_par'AND
                        ts.client_id = '$client_id' AND
                        ts.version_pareto = '$pareto_id' AND
                        EXISTS (SELECT o.customer_id as ocs, o.client_id as oc, o.user_id, o.created_at, o.status FROM 
                        orders as o 
                        WHERE
                        o.user_id = '$user_id' AND
                        o.customer_id = ts.customer_id AND
                        MONTH (o.created_at) = '$month' AND
                        YEAR (o.created_at) = '$year' AND
                        o.status != 'CANCEL' AND o.status != 'NO-ORDER' AND
                        o.customer_id IS NOT NULL 
                        GROUP BY o.customer_id);");
        
        return $cust_exists_p;
    }

    public static function achUserPareto($user_id,$month,$year,$pr,$period_par)
    {
        /*$ach_p = \App\Order::whereHas('store_target', function($q) use($period_par,$pr)
                {
                    return $q->where('version_pareto',$pr)
                    ->where('period',$period_par);
                })
                ->where('user_id',$user_id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->selectRaw('sum(total_price) as sum')
                ->pluck('sum');*/

        $ach_p = \App\Order::whereHas('store_target', function($q) use($period_par,$pr)
                {
                    return $q->where('version_pareto',$pr)
                    ->where('period',$period_par);
                })
                ->where('user_id',$user_id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->get(); 
        $ach_p_total = 0;       
        foreach( $ach_p as $order){
            $PriceTotal = \App\Http\Controllers\TransaksiSalesController::cekDiscountVolume($order->id);
            $ach_p_total +=  $PriceTotal;
        }       
        
        return $ach_p_total;             
    }

    public static function achQuantity(){
        $user_id = \Auth::user()->id;
        $month = date('m');
        $year = date('Y');
        $targ_ach_qty = \App\Order::with('products')
                    ->where('user_id',$user_id)
                    ->whereNotNull('customer_id')
                    ->where('status','!=','CANCEL')
                    ->where('status','!=','NO-ORDER')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)->get();
            $qty = $targ_ach_qty->sum('TotalQuantity');
        
        return $qty;
    }

    public static function PeriodType($pr){
        
        $pr_type = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                ->where('period',$pr)
                ->first();

        return $pr_type;
    }

    public static function achUsrTgQtyPareto($user_id,$month,$year,$pr,$period_par)
    {
        $ach_qtypareto = \App\Order::whereHas('store_target', function($q) use($period_par,$pr)
                {
                    return $q->where('version_pareto',$pr)
                    ->where('period',$period_par);
                })
                ->with('products')
                ->where('user_id',$user_id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->get();
        $qty_ach = $ach_qtypareto->sum('TotalQuantity');
        return $qty_ach;           
    }

    public static function TrgValPareto($user_id,$period_par,$pr)
    {
        $target_str = \App\Store_Targets::whereHas('customers', function($q) use($user_id){
                        $q->where('user_id',$user_id);
                    })
                    ->where('period',$period_par)
                    ->where('version_pareto',$pr)
                    ->get();
                    //->selectRaw('sum(target_values) as sum')
                    //->pluck('sum');
        $totalNml = 0;
        foreach ($target_str as $value) {
            $totalNml += $value->TotalNominal;
        }
        return $totalNml;           
    }

    public static function TrgQtyPareto($user_id,$period_par,$pr)
    {
        $targ_qty_par = \App\Store_Targets::whereHas('customers', function($q) use($user_id){
                        $q->where('user_id',$user_id);
                    })
                    ->where('period',$period_par)
                    ->where('version_pareto',$pr)
                    ->get();
                    //->selectRaw('sum(target_quantity) as sum')
                    //->pluck('sum');
        $totalQty = 0;
        foreach ($targ_qty_par as $value) {
            $totalQty += $value->TotalQty;
        }
        return $totalQty;           
    }

    public static function MaxYearQuantity(){
        $user_id = \Auth::user()->id;
        $year = date('Y');
        if($year < 2022){
            $mxx = [];
            for($i=6;$i<13;$i++){
                $mxx[] = \DB::select("SELECT AVG(total) as total_average
                            FROM
                            (
                                SELECT o.created_at , o.user_id, op.quantity,  
                                SUM(op.quantity) AS total
                                FROM orders AS o
                                JOIN order_product as op ON o.id = op.order_id 
                                WHERE o.user_id = '$user_id' 
                                AND month(o.created_at)= '$i'
                                AND Year(o.created_at)='$year'
                                AND status != 'CANCEL'
                                AND customer_id IS NOT NULL
                                GROUP BY DATE(o.created_at) 
                                ORDER BY total
                            ) as inner_query;");
                
            }
        }else{
            $mxx = [];
            for($i=1;$i<13;$i++){
                $mxx[] = \DB::select("SELECT AVG(total) as total_average
                    FROM
                    (
                        SELECT o.created_at , o.user_id, op.quantity,  
                        SUM(op.quantity) AS total
                        FROM orders AS o
                        JOIN order_product as op ON o.id = op.order_id 
                        WHERE o.user_id = '$user_id' 
                        AND month(o.created_at)= '$i'
                        AND Year(o.created_at)='$year'
                        AND status != 'CANCEL'
                        AND customer_id IS NOT NULL
                        GROUP BY DATE(o.created_at) 
                        ORDER BY total 
                    ) as inner_query;");
                
            }
        }
        $collect_average =  max($mxx);
        $max_q=0;
        foreach($collect_average as $mx){
            $max_q = $mx->total_average;
        }
        
        return number_format($max_q,0);
    }

    public static function lastOrder($customer){
        $curDate = date('Y-m-d');
        $newDate = new DateTime($curDate);
        $lastOrder = \App\Order::where('customer_id',$customer)
                    ->where('status','!=','CANCEL')
                    ->where('status','!=','NO-ORDER')
                    ->orderBy('created_at','DESC')
                    ->first();
        if($lastOrder){
            $date = date('Y-m-d', strtotime($lastOrder->created_at));
            $newDate2 = new DateTime($date);
            $jarak = $newDate->diff($newDate2)->days;
        }else{
            $jarak = '';
        }
        return $jarak;
    }

    public static function visitNoOrder($customer){
        $month = date('m');
        $year = date('Y');
        $visit_off = \App\Order::where('customer_id',$customer)
                ->where('status','NO-ORDER')
                ->where('user_loc','Off Location')
                ->whereMonth('created_at',$month)
                ->whereYear('created_at',$year)
                ->count();

        $_this = new self;
        $visit_on = $_this->visitOnNoOrder($customer);
    return [$visit_off,$visit_on];
        
    }

    public static function visitOnNoOrder($customer){
        $month = date('m');
        $year = date('Y');
        $visit_on = \App\Order::where('customer_id',$customer)
                ->where('status','NO-ORDER')
                ->where('user_loc','On Location')
                ->whereMonth('created_at',$month)
                ->whereYear('created_at',$year)
                ->count();
        return $visit_on;
    }

    public static function visitOrder($customer){
        $month = date('m');
        $year = date('Y');
        $visit_off = \App\Order::where('customer_id',$customer)
                ->where('status','!=','NO-ORDER')
                ->where('user_loc','Off Location')
                ->whereMonth('created_at',$month)
                ->whereYear('created_at',$year)
                ->count();

        $_this = new self;
        $visit_on = $_this->visitOnOrder($customer);
    return [$visit_off,$visit_on];
        
    }

    public static function visitOnOrder($customer){
        $month = date('m');
        $year = date('Y');
        $visit_on = \App\Order::where('customer_id',$customer)
                ->where('status','!=','NO-ORDER')
                ->where('user_loc','On Location')
                ->whereMonth('created_at',$month)
                ->whereYear('created_at',$year)
                ->count();
        return $visit_on;
    }

    public static function amountDayNotDelv($id){
        $curDate = date('Y-m-d');
        $newDate = new DateTime($curDate);
        $lastOrder = \App\Order::where('id',$id)
                    ->first();
        if($lastOrder){
            $date = date('Y-m-d', strtotime($lastOrder->created_at));
            $newDate2 = new DateTime($date);
            $jarak = $newDate->diff($newDate2)->days;
        }else{
            $jarak = '';
        }
        return $jarak;
    }
}  
