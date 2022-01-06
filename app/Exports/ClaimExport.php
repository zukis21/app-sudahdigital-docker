<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClaimExport implements FromCollection, WithMapping, WithHeadings
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
        $client_id = \Auth::user()->client_id;
        $lastPeriod = \App\PointPeriod::where('client_id',$client_id)
                    ->where('starts_at','>',$period->expires_at)
                    ->orderBy('starts_at','ASC')
                    ->first();
            
        if($lastPeriod){
            $claim = \DB::select("SELECT pc.id, pc.custpoint_id, pc.reward_id, pc.type,
                                pc.created_at, pc.status,pr.point_rule, pr.bonus_amount, 
                                cs.store_name, cs.client_id
                                FROM point_claims as pc 
                                JOIN point_rewards as pr ON pc.reward_id = pr.id
                                JOIN customers as cs ON cs.id = pc.custpoint_id
                                WHERE cs.client_id = '$client_id'
                                AND pc.type = 1
                                AND (pc.created_at BETWEEN '$lastPeriod->starts_at' AND '$lastPeriod->expires_at')  
                                ORDER BY pc.created_at DESC;"
                            );
        }else{
            $claim = \DB::select("SELECT pc.id, pc.custpoint_id, pc.reward_id, pc.type,
                                pc.created_at, pc.status,pr.point_rule, pr.bonus_amount, 
                                cs.store_name, cs.client_id
                                FROM point_claims as pc 
                                JOIN point_rewards as pr ON pc.reward_id = pr.id
                                JOIN customers as cs ON cs.id = pc.custpoint_id
                                WHERE cs.client_id = '$client_id'
                                AND pc.type = 1
                                AND pc.created_at > '$period->expires_at'   
                                ORDER BY pc.created_at DESC;"
                            );
        }

        return collect($claim);
    }

    public function map($claim) : array {
       
        return[
            $claim->store_name,
            $claim->point_rule,
            number_format($claim->bonus_amount,2),
            $claim->created_at,
            $claim->status,
        ];
    }

    public function headings() : array {
        return [
           'Customer',
           'Points Claim',
           'Bonus Amount',
           'Claim Date',
           'Status',
        ] ;
    }
}
