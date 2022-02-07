<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use DateTime;

class DashboardController extends Controller
{
    public function __construct(){
        
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $param = \Route::current()->parameter('vendor');
            //dd($param);
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            //dd($client->client_slug);
            if($client->client_slug == $param){
                if(session()->get('client_sess')== null){
                    \Request::session()->put('client_sess',
                    ['client_name' => $client->client_name,'client_image' => $client->client_image]);
                }
                if(Gate::allows('home-admin')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function home_admin(Request $request , $vendor, $msgs = null){
        if($request->get('period') != ''){
            $param_reset = 1;
            $month = date('m', strtotime($request->get('period')));
            $year = date('Y', strtotime($request->get('period')));
            $jumHari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $date_now = $year.'-'.$month.'-'.$jumHari;
            $current_day = $jumHari;
            $period_info = date('F, Y', strtotime($request->get('period')));
        }else{
            $date_now = date('Y-m-d');
            $month = date('m');
            $year = date('Y');
            $current_day = date('d');
            $period_info = date('F, Y');
            $param_reset = 0;
        }
        
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);

        $message = \App\Message::where('client_id',$client->id)->first();
        $work_plan = \App\WorkPlan::where('client_id',\Auth::user()->client_id)
                    ->whereMonth('work_period', '=', $month)
                    ->whereYear('work_period', '=', $year)->first();
        if($work_plan){
            $day_off = \App\Holiday::where('wp_id',$work_plan->id)
                    ->where('date_holiday','<=',$date_now)->count();
            
        }else{
            $day_off = null;
        }
        if($msgs){
            return view('home',['vendor'=>$vendor,
            'client'=>$client,'message'=>$message,
            'msgs'=>$msgs,'work_plan'=>$work_plan,
            'day_off'=>$day_off,
            'date_now'=>$date_now,
            'month'=>$month,
            'year'=>$year,
            'current_day'=>$current_day,
            'period_info'=>$period_info,
            'param_reset'=>$param_reset
        ]);
        }else{
            $msgs = null;
            return view('home',['vendor'=>$vendor,
            'client'=>$client,'message'=>$message,
            'msgs'=>$msgs,'work_plan'=>$work_plan,
            'day_off'=>$day_off,
            'date_now'=>$date_now,
            'month'=>$month,
            'year'=>$year,
            'current_day'=>$current_day,
            'period_info'=>$period_info,
            'param_reset'=>$param_reset
        ]);
        }
        
    }

    public static function periodSalesTarget($clientId){
        $paramDate = date('Y-m-01');
        $period = \App\Sales_Targets::where('client_id',$clientId)
                ->where('period','<',$paramDate)
                ->groupBy('period')
                ->orderBy('period','DESC')
                ->get();
        return $period;
    }

    public function update(Request $request, $vendor, $id)
    {
        \Validator::make($request->all(), [
            'client_image' => 'mimes:jpg,jpeg,png|max:1000', //only allow this type extension file.
        ]);
        $client = \App\B2b_client::findOrFail($id);
        //dd($user);
        $client->client_name = $request->get('client_name');
        $client->company_name = $request->get('company_name');
        $client->email = $request->get('email');
        $client->phone_whatsapp = $request->get('phone_whatsapp');
        $client->phone = $request->get('phone');
        $client->client_address = $request->get('client_address');
        $client->fb_url = $request->get('fb_url');
        $client->inst_url = $request->get('inst_url');
        $client->ytb_url = $request->get('ytb_url');
        $client->twt_url = $request->get('twt_url');
        
        if($request->file('client_image')){
            $file_get = $request->file('client_image');
            $file = '/client_image/';
            //dd($file);
            $nama_file = time()."_".$file_get->getClientOriginalName();
            $tujuan_upload = public_path('/assets/image/client_image');
            $file_get->move($tujuan_upload,$nama_file);
            $client->client_image =$file.$nama_file;
        }
        $client->save();
        if($client->save()){
            $request->session()->forget('client_sess');
        }
        return redirect()->route('home_admin',[$vendor])->with('status','Profile Succsessfully Update');
    }

    public function store_message(Request $request, $vendor){
        $m_setting = new \App\Message();
        $m_setting->client_id = \Auth::user()->client_id;
        $m_setting->m_tittle =$request->get('m_tittle');
        $m_setting->s_tittle =$request->get('s_tittle');
        $m_setting->c_tittle =$request->get('c_tittle');
        $m_setting->o_tittle =$request->get('o_tittle');

        $m_setting->save();
        if($m_setting->save()){
            $msgs = 'create-messagesetting-success';
        }
        return redirect()->route('home_admin',[$vendor,$msgs])->with('status','Message Tiitle Succsessfully Create');
    }

    public function update_message(Request $request, $vendor, $id){
        $m_setting = \App\Message::findOrFail($id);
        $m_setting->m_tittle =$request->get('m_tittle');
        $m_setting->s_tittle =$request->get('s_tittle');
        $m_setting->c_tittle =$request->get('c_tittle');
        $m_setting->o_tittle =$request->get('o_tittle');

        $m_setting->save();
        if($m_setting->save()){
            $msgs = 'update-messagesetting-success';
        }
        return redirect()->route('home_admin',[$vendor,$msgs])->with('status','Message Tiitle Succsessfully Update');
    }

    public static function totalStoreOrder($clientId,$month,$year){
        $idSpv = \Auth::user()->id;
        $cust_total = \App\Customer::whereHas('spv_sales',function($q)use($idSpv){
                        $q->where('spv_id',$idSpv);
                    })
                    ->whereHas('sales_targets',function($query) use ($month,$year){
                        $query->where('period',$year.'-'.$month.'-01');
                    })
                    ->where('client_id',$clientId)
                    ->where('status','!=','NONACTIVE')->count();
        $order = \App\Order::whereHas('spv_sales',function($q)use($idSpv){
                    $q->where('spv_id',$idSpv);
                })
                ->whereHas('sales_targets',function($query) use ($month,$year){
                    $query->where('period',$year.'-'.$month.'-01');
                })
                ->where('client_id',$clientId)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->distinct()->get(['customer_id'])->count();
        return [$cust_total,$order]; 
    }

    public static function paretoStore($clientId){
        $pareto = \App\CatPareto::where('client_id',$clientId)
                 ->orderBy('position','ASC')
                 ->get();

        return $pareto;
    }

    public static function total_pareto($clientId,$pareto_id,$date_now){
        $idSpv = \Auth::user()->id;
        $period_par = \App\Store_Targets::where('client_id',$clientId)
                     ->where('period','<=',$date_now)
                     ->max('period');
        
        $count_pareto = \App\Customer::whereHas('store_targets', function($q) use ($clientId,$pareto_id,$period_par){
                            $q->where('version_pareto',$pareto_id)
                                ->where('client_id',$clientId)
                                ->where('period',$period_par);
                        })
                        ->whereHas('sales_targets',function($query) use ($date_now){
                            $query->where('period',date('Y-m-01',strtotime($date_now)));
                        })
                        ->where(function($subQuery)use($idSpv){
                            $subQuery->whereHas('spv_sales',function($q)use($idSpv){
                                $q->where('spv_id',$idSpv);
                            });
                        })
                        ->count();

        return $count_pareto;
    }

    public static function amountParetoOrder($clientId,$month,$year,$pareto_id,$date_now){
        $idSpv = \Auth::user()->id;
        $_this = new self;
        $prSlsTarget = date('Y-m-01',strtotime($date_now));
        $period_par = $_this->paramPeriod($date_now);
        $cust_exists_p = \DB::select("SELECT ts.client_id, ts.customer_id, ts.period, ts.version_pareto FROM store_target as ts
                        WHERE 
                        ts.period ='$period_par'AND
                        ts.client_id = '$clientId' AND
                        ts.version_pareto = '$pareto_id' AND
                        EXISTS (SELECT o.customer_id as ocs, o.client_id as oc, o.user_id, o.created_at, o.status FROM 
                        orders as o 
                        INNER JOIN spv_sales as spvs ON o.user_id = spvs.sls_id
                        INNER JOIN sales_targets as slstr ON o.user_id = slstr.user_id 
                        WHERE
                        slstr.period = '$prSlsTarget' AND
                        spvs.spv_id = '$idSpv' AND
                        o.client_id = '$clientId' AND
                        o.customer_id = ts.customer_id AND
                        MONTH (o.created_at) = '$month' AND
                        YEAR (o.created_at) = '$year' AND
                        o.status != 'CANCEL' AND o.status != 'NO-ORDER' AND
                        o.customer_id IS NOT NULL 
                        GROUP BY o.customer_id);");
        
        return $cust_exists_p;
    }

    public static function salesTarget($clientId,$month,$year){
        $idSpv = \Auth::user()->id;
        $target = \App\Sales_Targets::whereHas('sls_exists_spv', function($q) use ($idSpv){
                        $q->where('spv_id',$idSpv);
                })
                ->where('target_type','>',0)
                ->where('client_id',$clientId)
                ->whereMonth('period', '=', $month)
                ->whereYear('period', '=', $year)
                ->get();
        return $target;
    }

    public static function achQuantity($clientId,$month,$year){
        $idSpv = \Auth::user()->id;
        $_this = new self;
        $sales = $_this->salesList($idSpv);
        $period = $year.'-'.$month.'-01';
        $total_qty = 0;
        foreach($sales as $sls){
            $slsId = $sls->sls_id;
            $target = $_this->salesTargetperSales($sls->sls_id,$month,$year);
            $targ_ach_qty = \App\Order::with('products')
                        ->whereHas('spv_sales',function($q)use($idSpv){
                            $q->where('spv_id',$idSpv);
                        })
                        ->whereHas('sales_targets',function($query) use ($period){
                            $query->where('period','=',"$period")
                            ->where(function($qr) {
                                $qr->where('target_type','=',1)
                                   ->orWhere('target_type','=',3);
                            });
                        })
                        ->where('user_id',$slsId)
                        ->whereNotNull('customer_id')
                        ->where('status','!=','CANCEL')
                        ->where('status','!=','NO-ORDER')
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)->get();
                $qty = $targ_ach_qty->sum('TotalQuantity');
            
                if($target){
                    $total_qty_ = $qty;
                }else{
                    $total_qty_ = 0;
                }
    
                $total_qty += $total_qty_;

        }
        
        return $total_qty;
    }

    public static function paramPeriod($date_now){
        $period_par = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                ->where('period','<=',$date_now)
                ->max('period');
        
        return $period_par;
    }

    public static function TrgValPareto($idSpv,$period_par,$pr,$month,$year)
    {
        $period = $year.'-'.$month.'-01';
        $target_str = \App\Store_Targets::whereHas('customers', function($q) use($idSpv,$period){
                        $q->whereHas('spv_sales',function($subQuery)use($idSpv){
                            $subQuery->where('spv_id',$idSpv);
                        });
                        $q->whereHas('sales_targets',function($query) use ($period){
                            $query->where('period','=',"$period")
                            ->where(function($qr) {
                                $qr->where('target_type','=',2)
                                   ->orWhere('target_type','=',3);
                            });
                        });
                })
                ->where('period',$period_par)
                ->where('version_pareto',$pr)
                ->get();
                    
        $totalNml = 0;
        foreach ($target_str as $value) {
            $totalNml += $value->TotalNominal;
        }
        return $totalNml;           
    }

    public static function TrgQtyPareto($idSpv,$period_par,$pr,$month,$year)
    {
        $period = $year.'-'.$month.'-01';
        $targ_qty_par = \App\Store_Targets::whereHas('customers', function($q) use($idSpv,$period){
                            $q->whereHas('spv_sales',function($subQuery)use($idSpv){
                                $subQuery->where('spv_id',$idSpv);
                            });
                            $q->whereHas('sales_targets',function($query) use ($period){
                                $query->where('period','=',"$period")
                                ->where(function($qr) {
                                    $qr->where('target_type','=',1)
                                       ->orWhere('target_type','=',3);
                                });
                            });
                    })
                    ->where('period',$period_par)
                    ->where('version_pareto',$pr)
                    ->get();
        
        
        $totalQty = 0;
        foreach ($targ_qty_par as $value) {
            $totalQty += $value->TotalQty;
        }
        return $totalQty;           
    }

    public static function achUserPareto($idSpv,$month,$year,$pr,$period_par)
    {
        $period = $year.'-'.$month.'-01';
        $ach_p = \App\Order::select('id as orderId')->whereHas('store_target', function($q) use($period_par,$pr)
                {
                    return $q->where('version_pareto',$pr)
                    ->where('period',$period_par);
                })
                ->whereHas('spv_sales',function($q)use($idSpv){
                    $q->where('spv_id',$idSpv);
                })
                ->whereHas('sales_targets',function($query) use ($period){
                    $query->where('period','=',"$period")
                    ->where(function($qr) {
                        $qr->where('target_type','=',2)
                           ->orWhere('target_type','=',3);
                    });
                })
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->get();
                //->selectRaw('sum(total_price) as sum')
                //->pluck('sum');

        $total_nml = 0;
        foreach( $ach_p as $order){
                $PriceTotal = \App\Http\Controllers\OrderController::cekDiscountVolume($order->orderId);
                $total_nml += $PriceTotal;
        }
        
        return $total_nml;             
    }

    public static function achUsrTgQtyPareto($idSpv,$month,$year,$pr,$period_par)
    {
        $_this = new self;
        $sales = $_this->salesList($idSpv);
        $period = $year.'-'.$month.'-01';
        $total_qty = 0;
        foreach($sales as $sls){
            $slsId = $sls->sls_id;
            $target = $_this->salesTargetperSales($sls->sls_id,$month,$year);
            $ach_qtypareto = \App\Order::whereHas('store_target', function($q) use($period_par,$pr)
                    {
                        return $q->where('version_pareto',$pr)
                        ->where('period',$period_par);
                    })
                    ->whereHas('spv_sales',function($q)use($idSpv){
                        $q->where('spv_id',$idSpv);
                    })
                    ->whereHas('sales_targets',function($query) use ($period){
                        $query->where('period','=',"$period")
                        ->where(function($qr) {
                            $qr->where('target_type','=',1)
                               ->orWhere('target_type','=',3);
                        });
                    })
                    ->with('products')
                    ->whereNotNull('customer_id')
                    ->where('user_id',$slsId)
                    ->whereMonth('created_at', '=', $month)
                    ->whereYear('created_at', '=', $year)
                    ->where('status','!=','CANCEL')
                    ->where('status','!=','NO-ORDER')
                    ->get();
            $qty_ach = $ach_qtypareto->sum('TotalQuantity');

            if($target){
                $total_qty_ = $qty_ach;
            }else{
                $total_qty_ = 0;
            }

            $total_qty += $total_qty_;
        }
            return $total_qty;           
    }

    public static function PeriodType($pr){
        
        $pr_type = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                ->where('period',$pr)
                ->first();

        return $pr_type;
    }

    public static function MaxYearQuantity($year){
        $idSpv = \Auth::user()->id;
        if($year < 2022){
            $mxx = [];
            for($i=6;$i<13;$i++){
                $mxx[] = \DB::select("SELECT AVG(total) as total_average
                            FROM
                            (
                                SELECT o.created_at , o.user_id, op.quantity,  
                                SUM(op.quantity) AS total
                                FROM orders AS o
                                INNER JOIN spv_sales as spvs ON o.user_id = spvs.sls_id
                                JOIN order_product as op ON o.id = op.order_id 
                                WHERE 
                                spvs.spv_id = '$idSpv'  
                                AND month(o.created_at)= '$i'
                                AND Year(o.created_at)='$year'
                                AND o.status != 'CANCEL'
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
                        INNER JOIN spv_sales as spvs ON o.user_id = spvs.sls_id
                        JOIN order_product as op ON o.id = op.order_id 
                        WHERE spvs.spv_id = '$idSpv'
                        AND month(o.created_at)= '$i'
                        AND Year(o.created_at)='$year'
                        AND o.status != 'CANCEL'
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
        
        return number_format($max_q,2);
    }

    public static function MaxYearNominal($idSpv,$year){
        if($year < 2022){
            $mxx = [];
            for($i=6;$i<13;$i++){
                $mxx[] = \DB::select("SELECT AVG(total) as total_average
                            FROM
                            (
                                SELECT o.created_at , user_id, SUM(total_price) AS total
                                FROM orders AS o
                                INNER JOIN spv_sales as spvs ON o.user_id = spvs.sls_id
                                WHERE spvs.spv_id = '$idSpv' 
                                AND month(o.created_at)= '$i'
                                AND Year(o.created_at)='$year'
                                AND o.status != 'CANCEL'
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
                        SELECT o.created_at , user_id, SUM(total_price) AS total
                        FROM orders AS o
                        INNER JOIN spv_sales as spvs ON o.user_id = spvs.sls_id
                        WHERE spvs.spv_id = '$idSpv' 
                        AND month(o.created_at)= '$i'
                        AND Year(o.created_at)='$year'
                        AND o.status != 'CANCEL'
                        AND customer_id IS NOT NULL
                        GROUP BY DATE(o.created_at) 
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
        /*if($target && $target->ppn == 1){
            $max_av = $max/1.1;
            //$get_per_day = round(($get_daily/1.1),2);
        }else{
            $max_av = $max;
           //$get_per_day = round($get_daily,2);
        }*/
        
        return $max;
    }

    public static function salesList($idSpv){
        $sales = \App\Spv_sales::with('sales')
                ->join('users', 'spv_sales.sls_id', '=', 'users.id')
                ->orderBy('users.name', 'ASC')
                ->where('spv_id',$idSpv)
                ->get();
        return $sales;
    }

    public static function orderAch($idSpv,$month,$year){
        $_this = new self;
        $sales = $_this->salesList($idSpv);

        $total_ach = 0;
        foreach($sales as $sls){
            $target = $_this->salesTargetperSales($sls->sls_id,$month,$year);
            
                $order_ach = \App\Order::select('id as orderId')->whereHas('sales_targets',function($query) use ($month,$year){
                                $query->where('period',$year.'-'.$month.'-01')
                                      ->where(function($qr) {
                                            $qr->where('target_type','=',2)
                                            ->orWhere('target_type','=',3);
                                        });
                            })
                            ->where('user_id',$sls->sls_id)
                            ->whereNotNull('customer_id')
                            ->whereMonth('created_at', '=', $month)
                            ->whereYear('created_at', '=', $year)
                            ->where('status','!=','CANCEL')
                            ->where('status','!=','NO-ORDER')
                            ->get();
                            //->selectRaw('sum(total_price) as sum')
                            //->pluck('sum');
                //$ach = json_decode($order_ach,JSON_NUMERIC_CHECK);
                //$ach_value_ppn = $ach[0];
               
                $total_nml = 0;
                foreach( $order_ach as $order){
                        $PriceTotal = \App\Http\Controllers\OrderController::cekDiscountVolume($order->orderId);
                        $total_nml += $PriceTotal;
                }
                /*$total_ach_ppn = 0;
                foreach($order_ach as $p){
                    $total_ach_ppn += $p->total_price;
                }*/
                /*$ach_value_ppn = $total_nml;
                if($target){
                    if($target->ppn == 1){
                        $total_ach_ = $ach_value_ppn/1.1;
                    }else{
                        $total_ach_ = $ach_value_ppn;
                    }
                }else{
                    $total_ach_ = 0;
                }
                $total_ach += $total_ach_;*/

            $total_ach += $total_nml;
        }
        

        /*
        $order_ach = \App\Order::whereHas('spv_sales',function($q)use($idSpv){
                        $q->where('spv_id',$idSpv);
                    })
                    ->whereHas('sales_targets',function($query) use ($month,$year){
                        $query->where('period',$year.'-'.$month.'-01');
                    })
                    ->whereNotNull('customer_id')
                    ->whereMonth('created_at', '=', $month)
                    ->whereYear('created_at', '=', $year)
                    ->where('status','!=','CANCEL')
                    ->where('status','!=','NO-ORDER')
                    ->get();
        return $order_ach;
        */

        return $total_ach/1.1;
    }

    //sales dashboard
    public static function salesTargetperSales($sls_id,$month,$year){
        $target = \App\Sales_Targets::where('user_id',$sls_id)
                ->whereMonth('period', '=', $month)
                ->whereYear('period', '=', $year)
                ->first();
        return $target;
    }

    public static function OrderAchperSales($sls_id,$month,$year){
        $order_ach = \App\Order::where('user_id',$sls_id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->get();
        return $order_ach;
    }

    public static function totalStoreOrderPerSales($sls_id,$month,$year){
        $cust_total = \App\Customer::where('user_id',$sls_id)->count();
        $order = \App\Order::where('user_id',$sls_id)
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->distinct()->get(['customer_id'])->count();
        return [$cust_total,$order]; 
    }

    public static function total_paretoPerSales($clientId,$sls_id,$pareto_id,$date_now){
        $period_par = \App\Store_Targets::where('client_id',$clientId)
                    ->where('period','<=',$date_now)
                    ->max('period');
        //dd($period_par);
        $count_pareto = \App\Store_Targets::whereHas('customers', function($q) use ($sls_id){
                            return $q->where('user_id',$sls_id);
                        })
                        ->where('version_pareto',$pareto_id)
                        ->where('client_id',$clientId)
                        ->where('period',$period_par)->count();

        return $count_pareto;
    }

    public static function amountParetoOrderPerSales($client_id,$user_id,$month,$year,$date_now,$pareto_id){
        $period_par = \App\Store_Targets::where('client_id',$client_id)
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

    public static function achQuantityPerSales($user_id,$month,$year){
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

    public static function TrgValParetoPerSales($user_id,$period_par,$pr)
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

    public static function TrgQtyParetoPerSales($user_id,$period_par,$pr)
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

    public static function achUserParetoPerSales($user_id,$month,$year,$pr,$period_par)
    {
        $ach_p = \App\Order::select('id as orderId')->whereHas('store_target', function($q) use($period_par,$pr)
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
                //->selectRaw('sum(total_price) as sum')
                //->pluck('sum');
        $total_price = 0;
        foreach($ach_p as $order){
            $PriceTotal = \App\Http\Controllers\OrderController::cekDiscountVolume($order->orderId);
            $total_price += $PriceTotal;
        }
                
        return $total_price / 1.1;             
    }

    public static function achUsrTgQtyParetoPerSales($user_id,$month,$year,$pr,$period_par)
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

    public static function MaxYearQuantityPerSales($user_id,$year){
        if($year < 2022){
            $mxx = [];
            for($i=6;$i<13;$i++){
                $mxx[] = \DB::select("SELECT AVG(total) as total_average
                            FROM
                            (
                                SELECT o.created_at , o.user_id, o.status, op.quantity,  
                                SUM(op.quantity) AS total
                                FROM orders AS o
                                JOIN order_product as op ON o.id = op.order_id 
                                WHERE o.user_id = '$user_id' 
                                AND month(o.created_at)= '$i'
                                AND Year(o.created_at)='$year'
                                AND o.status != 'CANCEL'
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
                        SELECT o.created_at , o.user_id,o.status, op.quantity,  
                        SUM(op.quantity) AS total
                        FROM orders AS o
                        JOIN order_product as op ON o.id = op.order_id 
                        WHERE o.user_id = '$user_id' 
                        AND month(o.created_at)= '$i'
                        AND Year(o.created_at)='$year'
                        AND o.status != 'CANCEL'
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
        
        return number_format($max_q,2);
    }

    public static function MaxYearNominalPerSales($user_id,$year){
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
        /*if($target && $target->ppn == 1){
            $max_av = $max/1.1;
            //$get_per_day = round(($get_daily/1.1),2);
        }else{
            $max_av = $max;
           //$get_per_day = round($get_daily,2);
        }*/
        
        return $max;
    }

    //==========================end sales=========================//

    public static function salesType($sls_id,$period){
        $type = \App\Sales_Targets::where('user_id',$sls_id)
                ->where('period',$period)
                ->first();
        return $type;
    }

    public static function paramTypeAll($client_id,$period){
        $spv_id = \Auth::user()->id;
        $param = \DB::select("SELECT COUNT(target_type) AS total FROM
                                (SELECT target_type, count(target_type) as jumlah 
                                FROM sales_targets 
                                INNER JOIN spv_sales ON spv_sales.sls_id = sales_targets.user_id
                                WHERE client_id = '$client_id'
                                AND spv_sales.spv_id = '$spv_id'
                                AND period = '$period'
                                AND target_type > 0
                                GROUP BY target_type 
                                ORDER BY jumlah)AS INNER_QUERY;"
                            );
        $total = $param[0]->total;
        
        if($total == 1){
            $paramType = \DB::select("SELECT target_type, count(target_type) as jumlah 
                        FROM sales_targets 
                        INNER JOIN spv_sales ON spv_sales.sls_id = sales_targets.user_id
                        WHERE client_id = '$client_id'
                        AND spv_sales.spv_id = '$spv_id'
                        AND period = '$period'
                        GROUP BY target_type 
                        ORDER BY jumlah LIMIT 1");
            
            foreach($paramType as $prm){
                $prType = $prm->target_type;
            }
        }elseif($total > 1) {
            $prType = 3;
        }else{
            $prType = 0;
        }                
    
        return  $prType;
        
    }

    
    public static function storeNotOrder($user_id,$month,$year,$date_now){
        $_this = new self;
        $period_par = $_this->paramPeriod($date_now);

        //================store not order==================/
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

        //================pareto has orders==================/
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

        //===========order > 5 days============/
        //$from = date('2021-06-01');
        $dateCurrent = date('Y-m');
        $dateThisPeriod = date('Y-m',strtotime($date_now));

        if($dateCurrent == $dateThisPeriod){
            $from = date('2021-06-01');
            $order_minday = date('Y-m-d', strtotime("-5 day", strtotime(date("Y-m-d")))); 
        }else{
            //$from = date('Y-m-01',strtotime($date_now));
            $from = date('2021-06-01');
            $order_minday = date('Y-m-d', strtotime("-5 day", strtotime($date_now)));
        }
        /*
        $from = date('Y-m-01',strtotime($date_now));
        $order_minday = date('Y-m-d', strtotime("-5 day", strtotime($date_now)));
        */
        
        $order_overday = \App\Order::where('user_id',$user_id)
                        ->whereNotNull('customer_id')
                        ->whereBetween('created_at', [$from,$order_minday])
                        ->where(function($qr) {
                            $qr->where('status','=','SUBMIT')
                            ->orWhere('status','=','PROCESS')
                            ->orWhere('status','=','PARTIAL-SHIPMENT');
                        })
                        ->orderBy('created_at','DESC')
                        ->get();
        

        return [$cust_not_exists,$cust_exists,$order_overday];
    }

    public static function lastOrder($customer,$date_now){
        $curDate = $date_now;
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

    public static function visitNoOrder($customer,$month,$year){
        $visit_off = \App\Order::where('customer_id',$customer)
                ->where('status','NO-ORDER')
                ->where('user_loc','Off Location')
                ->whereMonth('created_at',$month)
                ->whereYear('created_at',$year)
                ->count();

        $_this = new self;
        $visit_on = $_this->visitOnNoOrder($customer,$month,$year);
        return [$visit_off,$visit_on];
        
    }

    public static function visitOnNoOrder($customer,$month,$year){
        $visit_on = \App\Order::where('customer_id',$customer)
                ->where('status','NO-ORDER')
                ->where('user_loc','On Location')
                ->whereMonth('created_at',$month)
                ->whereYear('created_at',$year)
                ->count();
        return $visit_on;
    }

    public static function visitOrder($customer,$month,$year){
        $visit_off = \App\Order::where('customer_id',$customer)
                ->where('status','!=','NO-ORDER')
                ->where('user_loc','Off Location')
                ->whereMonth('created_at',$month)
                ->whereYear('created_at',$year)
                ->count();

        $_this = new self;
        $visit_on = $_this->visitOnOrder($customer,$month,$year);
        return [$visit_off,$visit_on];
        
    }

    public static function visitOnOrder($customer,$month,$year){
        $visit_on = \App\Order::where('customer_id',$customer)
                ->where('status','!=','NO-ORDER')
                ->where('user_loc','On Location')
                ->whereMonth('created_at',$month)
                ->whereYear('created_at',$year)
                ->count();
        return $visit_on;
    }

    public static function chartSpv($month,$year,$date_now){
        $spv_id = \Auth::user()->id;
        $work_plan = \App\WorkPlan::where('client_id',\Auth::user()->client_id)
                    ->whereMonth('work_period', '=', $month)
                    ->whereYear('work_period', '=', $year)->first();

        if($work_plan){
            $day_off = \App\Holiday::where('wp_id',$work_plan->id)
                  ->where('date_holiday','<=',$date_now)->count();
            $tgl = date('d',strtotime($date_now));
            $day = (int)$tgl;
            $hari_berjalan = $day-$day_off;
            $param_line = round((($hari_berjalan/$work_plan->working_days) * 100) ,2);
        }else{
            $day_off = null;
            $param_line = 0;
        }

        $cartuser = \App\Sales_Targets::whereHas('sls_exists_spv',function($q) use($spv_id){
                                $q->where('spv_id',$spv_id);
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
                        //->selectRaw('sum(total_price) as sum')
                        //->pluck('sum');
            //$ach = json_decode($targ_ach,JSON_NUMERIC_CHECK);
            //$ach_value_ppn = $ach[0];

            $targ_ach_total = 0;       
            foreach( $targ_ach as $orderTargAch){
                $PriceTotal = \App\Http\Controllers\OrderController::cekDiscountVolume($orderTargAch->id);
                $targ_ach_total +=  $PriceTotal;
            }
            $ach_value = $targ_ach_total/1.1;

            /*if($userval->ppn == 1){
                $ach_value = $ach_value_ppn/1.1;
            }else{
                $ach_value = $ach_value_ppn;
            }*/

            //nominal
            if($userval->target_values > 0){
                $percentage[]= round(($ach_value / $userval->target_values) * 100 ,2);
            }else{
                $percentage[]= 0;
            }

            //qty
            if($userval->target_quantity > 0){
                $percentage_qty[]= round(($qty / $userval->target_quantity) * 100 ,2);
            }else{
                $percentage_qty[]=0;
            }

            $red_line[]= $param_line;

            
        }
        $users_display = array_unique($user_value);

        $percent = json_encode($percentage,JSON_NUMERIC_CHECK);
        $percent_qty = json_encode($percentage_qty,JSON_NUMERIC_CHECK);
        $users_display = json_encode($users_display);
        $red_line = json_encode($red_line);

        return[$percent,$percent_qty,$users_display,$red_line,$param_line];
    }

    public static function amountDayNotDelv($id,$date_now){
        $curDate = $date_now;
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
