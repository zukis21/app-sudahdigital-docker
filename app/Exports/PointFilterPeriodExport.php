<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PointFilterPeriodExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $period_id)
    {
        $this->period_id = $period_id;
    }
    
    public function collection()
    {
        $period = \App\PointPeriod::where('id',$this->period_id)->first();
        
        $pn =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
                    FROM
                    (SELECT o.id as oid, cs.id csid,  cs.store_name, cs.user_id , u.name as sales_name, pr.created_at,
                                /*cp.id,*/ 
                                sum(case when (date(o.created_at) between '$period->starts_at' and '$period->expires_at')
                                         AND  (date(o.finish_time) between o.created_at AND DATE_ADD(date(o.created_at), INTERVAL 14 DAY)
                                                OR
                                               date(o.finish_time) between '$period->starts_at' AND '$period->expires_at') 
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
                                EXISTS ( SELECT * FROM customer_points WHERE period_id = $period->id AND
                                            customer_points.customer_id = o.customer_id) AND
                                pr.created_at = (SELECT MAX(created_at) FROM 
                                                product_rewards GROUP BY product_id HAVING 
                                                product_id = pr.product_id) AND  
                                date(o.created_at) between '$period->starts_at' and '$period->expires_at' AND
                                o.status != 'CANCEL' AND o.status != 'NO-ORDER'
                                GROUP by o.customer_id 
                    ) as points
                    LEFT JOIN (SELECT pc.custpoint_id, prpc.period_id as ppid, sum(case when pc.Type = 1 then -(ifnull(pc.override_points, prpc.point_rule)) 
                        when pc.Type = 2 then ifnull(pc.override_points,prpc.point_rule)
                       else 0 end) Pointreward 
                   from point_claims as pc 
                   JOIN point_rewards as prpc on pc.reward_id = prpc.id
                   JOIN point_periods as pprd on prpc.period_id = pprd.id
                   WHERE prpc.period_id = '$period->id'
                   Group by pc.custpoint_id) pointsRewards
                   on points.csid = pointsRewards.custpoint_id;");

        return collect($pn); 
    }

    public function map($pn) : array {
       
        $period = \App\PointPeriod::where('id',$this->period_id)->first();
        $claim = \App\Http\Controllers\CustomerPointOrderController::pointsClaim($period->starts_at,$pn->csid);
        $rest = \App\Http\Controllers\CustomerPointOrderController::starting_point($period->starts_at,$pn->csid);
        $start_point = number_format($rest,2);
        $pointInPeriod = number_format($pn->grand_total + $claim,2);
        $pointClaim = number_format($claim,2);
        $pointTotal = number_format($pn->grand_total + $rest ,2);
        return[
            $pn->store_name,
            $pn->sales_name,
            $start_point,
            $pointInPeriod,
            $pointClaim,
            $pointTotal,
        ];
    }

    public function headings() : array {
        return [
           'Customer',
           'Sales',
           'Starting Points',
           'Points In Periods',
           'Points Claim',
           'Total Points',
        ] ;
    }
}
