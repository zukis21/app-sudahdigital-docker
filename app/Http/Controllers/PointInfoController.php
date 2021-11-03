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
        //$total_point = 0;
        
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;

        /*$curr_period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->whereDate('expires_at', '>=', $date)->first();*/
        $last_period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->orderBy('starts_at','DESC')->first();

        if($last_period){
            $cust_exists = \DB::select("SELECT * FROM customer_points 
                        WHERE period_id = $last_period->id AND
                        customer_points.customer_id = '$customer_id'");
            if($cust_exists){
                $customers =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
                FROM
                (SELECT o.id as oid, cs.id csid, pr.created_at,
                            sum(case when o.finish_time between '$last_period->starts_at' and '$last_period->expires_at' 
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
                            /*EXISTS ( SELECT * FROM customer_points WHERE period_id = $last_period->id AND
                                    customer_points.customer_id = o.customer_id) AND*/
                            pr.created_at = (SELECT MAX(created_at) FROM 
                                            product_rewards GROUP BY product_id HAVING 
                                            product_id = pr.product_id) AND  
                            o.created_at between '$last_period->starts_at' and '$last_period->expires_at' AND
                            o.status != 'CANCEL' AND o.status != 'NO-ORDER'AND
                            o.customer_id = '$customer_id'
                ) as points
                LEFT JOIN (SELECT pc.custpoint_id, prpc.period_id as ppid, sum(case when pc.Type = 1 then -(ifnull(pc.override_points, prpc.point_rule)) 
                                when pc.Type = 2 then ifnull(pc.override_points,prpc.point_rule)
                            else 0 end) Pointreward 
                        from point_claims as pc 
                        JOIN point_rewards as prpc on pc.reward_id = prpc.id
                        JOIN point_periods as pprd on prpc.period_id = pprd.id
                        WHERE prpc.period_id = '$last_period->id'
                        AND pc.custpoint_id = '$customer_id') pointsRewards
                on points.csid = pointsRewards.custpoint_id;");

                $c_point = $customers[0]->grand_total;
                if($c_point == null){
                    $total = 0;
                }else{
                    $total = $c_point;
                }

                $_this = new self;
                $total_point = $total + ($_this->starting_point($last_period->starts_at,$customer_id));
                $period = $last_period->starts_at;
            }else{
                $month = date('m', strtotime($last_period->starts_at));
                $year = date('Y', strtotime($last_period->starts_at));
                if($month == '1'){
                    $prev_month = '12';
                    $year = $year - 1; 
                }else{
                    $prev_month = $month - 1;
                }
                
                $prev_period = \App\PointPeriod::where('client_id',$client_id)
                            ->whereMonth('expires_at',$prev_month)
                            ->whereYear('expires_at', $year)->first();

                if($prev_period){
                    $cust_exists = \DB::select("SELECT * FROM customer_points 
                                WHERE period_id = $prev_period->id AND
                                customer_points.customer_id = '$customer_id'");
                    if($cust_exists){
                        $customers =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
                        FROM
                        (SELECT o.id as oid, cs.id csid, pr.created_at,
                            sum(case when o.finish_time between '$prev_period->starts_at' and '$prev_period->expires_at' 
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
                            /*EXISTS ( SELECT * FROM customer_points WHERE period_id = $prev_period->id AND
                                    customer_points.customer_id = o.customer_id) AND*/
                            pr.created_at = (SELECT MAX(created_at) FROM 
                                            product_rewards GROUP BY product_id HAVING 
                                            product_id = pr.product_id) AND  
                            o.created_at between '$prev_period->starts_at' and '$prev_period->expires_at' AND
                            o.status != 'CANCEL' AND o.status != 'NO-ORDER'AND
                            o.customer_id = '$customer_id'
                        ) as points
                        LEFT JOIN (SELECT pc.custpoint_id, prpc.period_id as ppid, sum(case when pc.Type = 1 then -(ifnull(pc.override_points, prpc.point_rule)) 
                                        when pc.Type = 2 then ifnull(pc.override_points,prpc.point_rule)
                                    else 0 end) Pointreward 
                                from point_claims as pc 
                                JOIN point_rewards as prpc on pc.reward_id = prpc.id
                                JOIN point_periods as pprd on prpc.period_id = pprd.id
                                WHERE prpc.period_id = '$prev_period->id'
                                AND pc.custpoint_id = '$customer_id') pointsRewards
                        on points.csid = pointsRewards.custpoint_id;");

                        $c_point = $customers[0]->grand_total;
                        if($c_point == null){
                            $total = 0;
                        }else{
                            $total = $c_point;
                        }

                        $_this = new self;
                        $total_point = $total + ($_this->starting_point($prev_period->starts_at,$customer_id));
                        
                    }
                    else{
                        $total_point = 0;
                    }
                }else{
                    $total_point = 0;
                }
                    
            }
        }
        else{
            $total_point = 0;
        }

        return $total_point;
        
    }

    public static function starting_point($period, $customer){
        
        $date =date('Y-m-d', strtotime($period));
        $PrevPeriodCheck = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                            ->whereDate('expires_at', '<', $date)
                            ->orderBy('expires_at','DESC')
                            ->first();
        if($PrevPeriodCheck){
            $Year =date('Y', strtotime($PrevPeriodCheck->starts_at));
            $prd_cek = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->whereDate('expires_at', '<', $date)
                    ->whereYear('expires_at',$Year)
                    ->orderBy('expires_at','DESC')
                    ->get();
            if($prd_cek){
                $total_start_point = 0;
                foreach($prd_cek as $period_cek){
                    /*
                    $cust_exists = \DB::select("SELECT * FROM customer_points 
                                    WHERE period_id = $period_cek->id AND
                                    customer_points.customer_id = '$customer'");
                    if(!$cust_exists){
                        break;
                    }*/
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

        }
        else{
            $total_start_point = 0; 
        }
        return $total_start_point;
    }

    public static function amountClaim($customer){
        $date = date('Y-m-d');
        $checkPeriod = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                                ->whereDate('expires_at', '<', $date)
                                ->orderBy('expires_at','DESC')
                                ->first();
        $paramPeriod = null;                       
        if($checkPeriod){
            $paramPeriod = $checkPeriod->id;
            $Year =date('Y', strtotime($checkPeriod->starts_at));
            $prd_cek = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->whereDate('expires_at', '<', $date)
                    ->whereYear('expires_at',$Year)
                    ->orderBy('expires_at','DESC')
                    ->get();
            if($prd_cek){
                $total_start_point = 0;
                foreach($prd_cek as $period_cek){
                    /*
                    $cust_exists = \DB::select("SELECT * FROM customer_points 
                                    WHERE period_id = $period_cek->id AND
                                    customer_points.customer_id = '$customer'");
                    if(!$cust_exists){
                        break;
                    }*/
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

        }
        else{
            $total_start_point = 0; 
        }

        return [$paramPeriod,$total_start_point];
    }

}
