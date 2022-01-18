<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClaimExport;

class ClaimPointsOrderController extends Controller
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
                if(Gate::allows('claim-point-order')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index(Request $request, $vendor){
        $period_list = \App\PointPeriod::where('client_id',\Auth::user()->client_id)->get();
        $status = $request->get('status');
        $client_id = \Auth::user()->client_id;
        if($status){
            $claim = \DB::select("SELECT pc.id, pc.custpoint_id, pc.reward_id, pc.type,
                                pc.created_at, pc.status,pr.point_rule, pr.bonus_amount, 
                                cs.store_name, cs.client_id
                                FROM point_claims as pc 
                                JOIN point_rewards as pr ON pc.reward_id = pr.id
                                JOIN customers as cs ON cs.id = pc.custpoint_id
                                WHERE cs.client_id = '$client_id'
                                AND pc.type = 1
                                AND pc.status = '$status'
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
                                ORDER BY pc.created_at DESC;"
                            );
        }
        

        return view('points_claim.index',['claim'=>$claim,'vendor'=>$vendor, 'period_list'=>$period_list]);
    }

    public function finishClaim($vendor, $id, $status = null)
    {
        $claim = \App\PointClaim::findOrFail($id);
        $claim->status = 'FINISH';
        $claim->save();
        
        if($status == null){
            return redirect()->route('ClaimPoints.index', [$vendor])->with('status',
            'Claim status is finish');
        }else{
            return redirect()->route('ClaimPoints.index', [$vendor, 'status' =>$status])
            ->with('status','Claim status is finish ');
        }
    }

    public function exportClaim(Request $request, $vendor){
        $period_id = $request->get('period');
        $period = \App\PointPeriod::findOrFail($period_id);

        return Excel::download(new ClaimExport($period_id), 'Claim - '.$period->name.'.xlsx');
    }
}
