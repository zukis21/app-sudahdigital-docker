<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PointInfoController extends Controller
{
    public static function StoreInfo($id){
        $customer = \App\Customer::findOrfail($id);
        return $customer->store_name;
        //return $ses_order->store_name
    }

    public static function PointInfo($customer_id)
    {   
        
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;

        //$period_list = \App\PointPeriod::where('client_id',$client_id)->get();

        $period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->whereDate('expires_at', '>=', $date)->first();
        
        
        //dd($period->starts_at);
        /*$cust_exists = \DB::select("SELECT * FROM customer_points WHERE period_id = $period->id AND
                        customer_points.customer_id = '$customer_id'");*/

        if($period){
            $customers =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
            FROM
            (SELECT o.id as oid, cs.id csid, pr.created_at,
                        sum(case when o.finish_time between '$period->starts_at' and '$period->expires_at' 
                        then 
                        (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end) totalpoint
                        FROM orders as o 
                        JOIN order_product as op ON o.id = op.order_id 
                        JOIN products on products.id = op.product_id 
                        JOIN product_rewards as pr on pr.product_id = products.id
                        JOIN customers as cs on cs.id = o.customer_id
                        JOIN users as u on u.id = cs.user_id
                        /*JOIN customer_points as cp on cp.customer_id = cs.id*/
                        WHERE
                        /*EXISTS ( SELECT * FROM customer_points WHERE period_id = $period->id AND
                                customer_points.customer_id = o.customer_id) AND*/
                        pr.created_at = (SELECT MAX(created_at) FROM 
                                        product_rewards GROUP BY product_id HAVING 
                                        product_id = pr.product_id) AND  
                        o.created_at between '$period->starts_at' and '$period->expires_at' AND
                        o.status != 'CANCEL' AND o.status != 'NO-ORDER'AND
                        o.customer_id = '$customer_id'
            ) as points
            LEFT JOIN (SELECT pc.custpoint_id, prpc.period_id as ppid, sum(case when pc.Type = 1 then -(ifnull(pc.override_points, prpc.point_rule)) 
                            when pc.Type = 2 then ifnull(pc.override_points,prpc.point_rule)
                        else 0 end) Pointreward 
                    from point_claims as pc 
                    JOIN point_rewards as prpc on pc.reward_id = prpc.id
                    JOIN point_periods as pprd on prpc.period_id = pprd.id
                    WHERE prpc.period_id = '$period->id'
                    AND pc.custpoint_id = '$customer_id') pointsRewards
            on points.csid = pointsRewards.custpoint_id;");

            $c_point = $customers[0]->grand_total;
            if($c_point == null){
                $total = 0;
            }else{
                $total = $c_point;
            }

            $_this = new self;
            $total_point = $total + ($_this->starting_point($period->starts_at,$customer_id));
        
        }else{
            $_this = new self;
            $total_point = $_this->starting_point($period->starts_at,$customer_id);
        }

        return $total_point;
    }

    public function starting_point($period, $customer){
        $date =date('Y-m-d', strtotime($period));
        $Year =date('Y');
        $prd_cek = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->whereDate('expires_at', '<', $date)
                    ->whereYear('expires_at',$Year)
                    ->orderBy('expires_at','DESC')
                    ->get();
        //dd($prd_cek);
        
        if($prd_cek){
            $total_start_point = 0;
            foreach($prd_cek as $period_cek){
            
                $customers_cek =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
                            FROM
                            (SELECT o.id as oid, cs.id csid,  cs.store_name, cs.user_id , u.name as sales_name, pr.created_at,
                                        /*cp.id,*/ 
                                        sum(case when o.finish_time between '$period_cek->starts_at' and '$period_cek->expires_at' 
                                        then 
                                        (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end) totalpoint
                                        FROM orders as o 
                                        JOIN order_product as op ON o.id = op.order_id 
                                        JOIN products on products.id = op.product_id 
                                        JOIN product_rewards as pr on pr.product_id = products.id
                                        JOIN customers as cs on cs.id = o.customer_id
                                        JOIN users as u on u.id = cs.user_id
                                        /*JOIN customer_points as cp on cp.customer_id = cs.id*/
                                        WHERE
                                       
                                        
                                        pr.created_at = (SELECT MAX(created_at) FROM 
                                                        product_rewards GROUP BY product_id HAVING 
                                                        product_id = pr.product_id) AND  
                                        o.created_at between '$period_cek->starts_at' and '$period_cek->expires_at' AND
                                        o.status != 'CANCEL' AND o.status != 'NO-ORDER' AND
                                        o.customer_id = '$customer'
                            ) as points
                            LEFT JOIN (SELECT pc.custpoint_id, prpc.period_id as ppid, sum(case when pc.Type = 1 then -(ifnull(pc.override_points, prpc.point_rule)) 
                                            when pc.Type = 2 then ifnull(pc.override_points,prpc.point_rule)
                                        else 0 end) Pointreward 
                                    from point_claims as pc 
                                    JOIN point_rewards as prpc on pc.reward_id = prpc.id
                                    JOIN point_periods as pprd on prpc.period_id = pprd.id
                                    WHERE prpc.period_id = '$period_cek->id'
                                    AND pc.custpoint_id = '$customer') pointsRewards
                            on points.csid = pointsRewards.custpoint_id;");
                $restpoints = $customers_cek[0]->grand_total;
                if($restpoints == null){
                    $pointstart = 0;
                }else{
                    $pointstart = $restpoints;
                }
            
                $total_start_point += $pointstart; 
            }
        }else{
            $total_start_point = 0;
        }
        
        return $total_start_point;
    }
}
