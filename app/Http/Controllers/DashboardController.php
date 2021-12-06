<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

    public function home_admin($vendor, $msgs = null){
        $date_now = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
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
            'day_off'=>$day_off
        ]);
        }else{
            $msgs = null;
            return view('home',['vendor'=>$vendor,
            'client'=>$client,'message'=>$message,
            'msgs'=>$msgs,'work_plan'=>$work_plan,
            'day_off'=>$day_off
        ]);
        }
        
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

    public static function totalStoreOrder($clientId){
        $date_now = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
        $idSpv = \Auth::user()->id;
        $cust_total = \App\Customer::whereHas('spv_sales',function($q)use($idSpv){
                        $q->where('spv_id',$idSpv);
                    })
                    ->where('client_id',$clientId)
                    ->where('status','!=','NONACTIVE')->count();
        $order = \App\Order::whereHas('spv_sales',function($q)use($idSpv){
                    $q->where('spv_id',$idSpv);
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

    public static function total_pareto($clientId,$pareto_id){
        $idSpv = \Auth::user()->id;
        $date_now = date('Y-m-d');

        $period_par = \App\Store_Targets::where('client_id',$clientId)
                     ->where('period','<=',$date_now)
                     ->max('period');
        
        $count_pareto = \App\Customer::whereHas('store_targets', function($q) use ($clientId,$pareto_id,$period_par){
                            $q->where('version_pareto',$pareto_id)
                                ->where('client_id',$clientId)
                                ->where('period',$period_par);
                        })
                        ->where(function($subQuery)use($idSpv){
                            $subQuery->whereHas('spv_sales',function($q)use($idSpv){
                                $q->where('spv_id',$idSpv);
                            });
                        })
                        ->count();

        return $count_pareto;
    }

    public static function amountParetoOrder($clientId,$month,$year,$pareto_id){
        $idSpv = \Auth::user()->id;
        $_this = new self;
        $period_par = $_this->paramPeriod();
        $cust_exists_p = \DB::select("SELECT ts.client_id, ts.customer_id, ts.period, ts.version_pareto FROM store_target as ts
                        WHERE 
                        ts.period ='$period_par'AND
                        ts.client_id = '$clientId' AND
                        ts.version_pareto = '$pareto_id' AND
                        EXISTS (SELECT o.customer_id as ocs, o.client_id as oc, o.user_id, o.created_at, o.status FROM 
                        orders as o 
                        INNER JOIN spv_sales as spvs ON o.user_id = spvs.sls_id 
                        WHERE
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

    public static function salesTarget($clientId){
        $month = date('m');
        $year = date('Y');
        $idSpv = \Auth::user()->id;
        $target = \App\Sales_Targets::whereHas('sls_exists_spv', function($q) use ($idSpv){
                        $q->where('spv_id',$idSpv);
                })
                ->where('client_id',$clientId)
                ->whereMonth('period', '=', $month)
                ->whereYear('period', '=', $year)
                ->get();
        return $target;
    }

    public static function achQuantity($clientId){
        $month = date('m');
        $year = date('Y');
        $idSpv = \Auth::user()->id;
        $targ_ach_qty = \App\Order::with('products')
                    ->whereHas('spv_sales',function($q)use($idSpv){
                        $q->where('spv_id',$idSpv);
                    })
                    ->where('client_id',$clientId)
                    ->whereNotNull('customer_id')
                    ->where('status','!=','CANCEL')
                    ->where('status','!=','NO-ORDER')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)->get();
            $qty = $targ_ach_qty->sum('TotalQuantity');
        
        return $qty;
    }

    public static function paramPeriod(){
        $date_now  = date('Y-m-d');
        $period_par = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                ->where('period','<=',$date_now)
                ->max('period');
        
        return $period_par;
    }

    public static function TrgValPareto($idSpv,$period_par,$pr)
    {
        $target_str =  \App\Customer::whereHas('store_targets',function($q)use($period_par,$pr){
                        $q->where('period',$period_par)
                        ->where('version_pareto',$pr);
                    })
                    ->whereHas('spv_sales',function($q)use($idSpv){
                            $q->where('spv_id',$idSpv);
                    })
                    ->get();
                    
        $totalNml = 0;
        foreach ($target_str as $value) {
            $totalNml += $value->TotalNominal;
        }
        return $totalNml;           
    }

    public static function TrgQtyPareto($idSpv,$period_par,$pr)
    {
        $targ_qty_par = \App\Customer::whereHas('store_targets',function($q)use($period_par,$pr){
                        $q->where('period',$period_par)
                        ->where('version_pareto',$pr);
                    })
                    ->whereHas('spv_sales',function($q)use($idSpv){
                            $q->where('spv_id',$idSpv);
                        })
                    ->get();
        $totalQty = 0;
        foreach ($targ_qty_par as $value) {
            $totalQty += $value->TotalQty;
        }
        return $totalQty;           
    }

    public static function achUserPareto($idSpv,$month,$year,$pr,$period_par)
    {
        $ach_p = \App\Order::whereHas('store_target', function($q) use($period_par,$pr)
                {
                    return $q->where('version_pareto',$pr)
                    ->where('period',$period_par);
                })
                ->whereHas('spv_sales',function($q)use($idSpv){
                    $q->where('spv_id',$idSpv);
                })
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->selectRaw('sum(total_price) as sum')
                ->pluck('sum');
        return $ach_p;             
    }

    public static function achUsrTgQtyPareto($idSpv,$month,$year,$pr,$period_par)
    {
        $ach_qtypareto = \App\Order::whereHas('store_target', function($q) use($period_par,$pr)
                {
                    return $q->where('version_pareto',$pr)
                    ->where('period',$period_par);
                })
                ->whereHas('spv_sales',function($q)use($idSpv){
                    $q->where('spv_id',$idSpv);
                })
                ->with('products')
                ->whereNotNull('customer_id')
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->get();
        $qty_ach = $ach_qtypareto->sum('TotalQuantity');
        return $qty_ach;           
    }

    public static function PeriodType($pr){
        
        $pr_type = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                ->where('period',$pr)
                ->first();

        return $pr_type;
    }

    public static function MaxYearQuantity(){
        $idSpv = \Auth::user()->id;
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
                                INNER JOIN spv_sales as spvs ON o.user_id = spvs.sls_id
                                JOIN order_product as op ON o.id = op.order_id 
                                WHERE 
                                spvs.spv_id = '$idSpv'  
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
                        INNER JOIN spv_sales as spvs ON o.user_id = spvs.sls_id
                        JOIN order_product as op ON o.id = op.order_id 
                        WHERE spvs.spv_id = '$idSpv'
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
}
