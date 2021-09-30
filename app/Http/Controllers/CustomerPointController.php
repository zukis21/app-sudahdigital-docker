<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerPointController extends Controller
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
                if(Gate::allows('point-customers')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index($vendor)
    {   
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;

        $period_list = \App\PointPeriod::where('client_id',$client_id)->get();

        $period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->whereDate('expires_at', '>=', $date)->first();
        
        $customers =\DB::select("SELECT o.id,  cs.store_name, cs.user_id , u.name as sales_name, pr.created_at,
            sum(case when o.finish_time between '$period->starts_at' and '$period->expires_at' 
             then 
            (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end) totalpoint
            FROM orders as o 
            JOIN order_product as op ON o.id = op.order_id 
            JOIN products on products.id = op.product_id 
            JOIN product_rewards as pr on pr.product_id = products.id
            JOIN customers as cs on cs.id = o.customer_id
            JOIN users as u on u.id = cs.user_id
            WHERE
            pr.created_at = (SELECT MAX(created_at) FROM 
                            product_rewards GROUP BY product_id HAVING 
                            product_id = pr.product_id) AND  
            o.client_id = '$client_id' AND
            cs.reg_point ='Y' AND
            o.created_at between '$period->starts_at' and '$period->expires_at' AND
            o.status != 'CANCEL' AND o.status != 'NO-ORDER'
            GROUP by o.customer_id;");
             
        //dd($customers);         
        
        return view ('customer_point.index',['customers'=>$customers,'vendor'=>$vendor,'period_list'=>$period_list]);
    }

    public function filter_period($vendor, $period_name, $period_id)
    {   
        //dd(\Crypt::decrypt($period_id));
        $client_id = \Auth::user()->client_id;

        $period_list = \App\PointPeriod::where('client_id',$client_id)->get();

        $period = \App\PointPeriod::findOrFail(\Crypt::decrypt($period_id));
        
        //dd($period);
        $customers =\DB::select("SELECT o.id,  cs.store_name, cs.user_id , u.name as sales_name, pr.created_at,
            sum(case when o.finish_time between '$period->starts_at' and '$period->expires_at' then 
            (pr.prod_point_val/pr.quantity_rule) * op.quantity else 0 end) totalpoint
            FROM orders as o 
            JOIN order_product as op ON o.id = op.order_id 
            JOIN products on products.id = op.product_id 
            JOIN product_rewards as pr on pr.product_id = products.id
            JOIN customers as cs on cs.id = o.customer_id
            JOIN users as u on u.id = cs.user_id
            WHERE 
            pr.created_at = (SELECT MAX(created_at) FROM 
                            product_rewards where created_at <= '$period->starts_at' GROUP BY 
                            product_id HAVING 
                            product_id = pr.product_id) AND
            o.client_id = '$client_id' AND
            cs.reg_point ='Y' AND
            o.created_at between '$period->starts_at' and '$period->expires_at' AND
            o.status != 'CANCEL' AND o.status != 'NO-ORDER'
            GROUP by o.customer_id;"); 
        //dd($customers);         
        
        return view ('customer_point.index',['customers'=>$customers,
                                            'vendor'=>$vendor,
                                            'period_list'=>$period_list,
                                            'period'=>$period->id]);
    }
}
