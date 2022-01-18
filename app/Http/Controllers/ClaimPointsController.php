<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClaimPointsController extends Controller
{
    public function ClaimRequest(Request $request){
        $customer_id = $request->get('customer_id');
        $reward_id =$request->get('reward_id');
        $new_claim = new \App\PointClaim();
        $new_claim->custpoint_id = $customer_id;
        $new_claim->reward_id = $reward_id;
        $new_claim->type = 1;
        $new_claim->save();
    }
    
    /*public function checkperiod(){
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;

        $current_period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('expires_at', '<', $date)
                    ->orderBy('expires_at','DESC')->first();
        if ($current_period != null) {
            echo "period_ready";	
        }else{
            echo 'not_period';
        }
    }

    public function checkpoints(Request $request){
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;

        $current_period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('expires_at', '<', $date)
                    ->orderBy('expires_at','DESC')->first();

        $customer_id= $request->get('cs_id');
        $cek_claim = \DB::select("SELECT pc.custpoint_id, pc.type,
                        pr.id, pp.id, pp.starts_at, pp.expires_at 
                        FROM point_claims  AS pc
                        JOIN point_rewards as pr ON pr.id = pc.reward_id
                        JOIN point_periods as pp ON pp.id = pr.period_id
                        WHERE pc.custpoint_id = '$customer_id'
                        AND pc.type = 1 
                        AND pp.id = '$current_period->id'");
        if($cek_claim->count() > 0){
            echo "exists_claim";
        }else{
            echo "not_exists_claim";
        }

    }

    public function points_lists(Request $request){
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;

        $current_period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('expires_at', '<', $date)
                    ->orderBy('expires_at','DESC')->first();

        $customer_id= $request->get('cs_id');
        $cek_claim = \DB::select("SELECT pc.custpoint_id, pc.type,
                        pr.id, pp.id, pp.starts_at, pp.expires_at 
                        FROM point_claims  AS pc
                        JOIN point_rewards as pr ON pr.id = pc.reward_id
                        JOIN point_periods as pp ON pp.id = pr.period_id
                        WHERE pc.custpoint_id = '$customer_id'
                        AND pc.type = 1 
                        AND pp.id = '$current_period->id'");
        if($cek_claim->count() > 0){
            echo "exists_claim";
        }else{
            echo "not_exists_claim";
        }

    }*/

   
}
