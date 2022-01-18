<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class PointVouchersController extends Controller
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
                if(Gate::allows('point-vouchers')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index(Request $request, $vendor){
        $PointsPeriods = \App\PointPeriod::where('client_id',auth()->user()->client_id)
                ->orderBy('id','DESC')
                ->get();
        /*$pointlist = \App\PointReward::where('client_id',auth()->user()->client_id)
                ->orderBy('id','DESC')
                ->get();*/
        return view ('voucher_points.index',['PointsPeriods'=>$PointsPeriods,'vendor'=>$vendor]);
    }

    public function create($vendor, $id)
    {   
        
        $get_date = \App\PointPeriod::findOrFail(\Crypt::decrypt($id));
        
        /* $get_date = \App\PointPeriod::where('client_id',auth()->user()->client_id)
                       ->orderBy('expires_at','DESC')->first();
        if($get_date){
            $start_date =  date('Y-m-d', strtotime($get_date->expires_at. ' + 1 days'));
        }else{
            $start_date = '';
        }

        /*
        $client_id = \Auth::user()->client_id;
        $PointPeriod = \App\PointPeriod::whereDoesntHave('point_reward', function ($query) use ($client_id) {
            $query->where('client_id', $client_id);
        })
        ->where('client_id',$client_id)
        ->orderBy('id','DESC')
        ->get();
        */
        return view('voucher_points.create',['vendor'=>$vendor,'get_date'=>$get_date]);
    }

    public function store(Request $request, $vendor)
    {
        if($request->has('point_rule')){
            /*$PointPeriod = new \App\PointPeriod();
            $PointPeriod->client_id = \Auth::user()->client_id;
            $PointPeriod->name = $request->get('name');
            $originalDateStart = $request->get('starts_at');
            $originalDateExpires = $request->get('expires_at');
            $newDateStart = date("Y-m-d", strtotime($originalDateStart));
            $newDateExpires = date("Y-m-d", strtotime($originalDateExpires));
            $PointPeriod->starts_at = $newDateStart;
            $PointPeriod->expires_at = $newDateExpires;
            $PointPeriod->save();
            */
            if(count($request->point_rule) > 0) {
                $sum = 0;
                
                foreach ($request->point_rule as $i => $v){
                    /*$data_VrPoints=array(
                        'client_id'=>\Auth::user()->client_id,
                        //'period_id'=>$role->users()->associate($user),
                        'point_rule'=>$request->point_rule[$i] ?? '0',
                        'bonus_amount'=>str_replace(',', '',$request->bonus_amount[$i]) ?? '0',
                    );*/
                    $new_voucher = new \App\PointReward();
                    $new_voucher->client_id = \Auth::user()->client_id;
                    /*$new_voucher->point_period()->associate($PointPeriod);*/
                    $new_voucher->period_id = $request->period_id;   
                    $new_voucher->point_rule = $request->point_rule[$i] ?? '0';
                    $new_voucher->bonus_amount = str_replace(',', '',$request->bonus_amount[$i]) ?? '0';
                    
                    $new_voucher->save();
                    //$new_voucher->create($data_VrPoints);
                }
            }

            return redirect()->route('points.details',[$vendor,\Crypt::encrypt($request->period_id)])->with('status','Point Cash Back successfully saved');
        }
        else{
            return back()->withInput()->with('error','Failed to save, no point added');
        }

    }
    
    public function edit($vendor,$id)
    {
        $PointPeriod = \App\PointPeriod::findorFail(\Crypt::decrypt($id));
        
        $get_date_start = \App\PointPeriod::where('client_id',auth()->user()->client_id)
                        ->whereDate('expires_at','<',$PointPeriod->starts_at)
                        ->orderBy('expires_at','DESC')->first();

        $get_date_end = \App\PointPeriod::where('client_id',auth()->user()->client_id)
                        ->whereDate('starts_at','>',$PointPeriod->expires_at)
                        ->orderBy('starts_at','ASC')->first();
                        

        //dd($get_date_end);
        if($get_date_start){
            $start_date =  date('Y-m-d', strtotime($get_date_start->expires_at. ' + 1 days'));
        }else{
            $start_date = '';
        }

        if($get_date_end){
            $end_date =  date('Y-m-d', strtotime($get_date_end->starts_at. ' - 1 days'));
        }else{
            $end_date = '';
        }
        //dd($end_date);
        return view('voucher_points.edit',
                    [
                        'vendor'=>$vendor,
                        'PointPeriod'=>$PointPeriod,
                        'start_date'=>$start_date,
                        'end_date'=>$end_date,
                    ]);
    }

    public function update(Request $request, $vendor, $id)
    {
        if($request->has('point_rule')){
            /*
            $PointPeriod = \App\PointPeriod::findOrFail($id);
            $PointPeriod->name = $request->get('name');
            $originalDateStart = $request->get('starts_at');
            $originalDateExpires = $request->get('expires_at');
            $newDateStart = date("Y-m-d", strtotime($originalDateStart));
            $newDateExpires = date("Y-m-d", strtotime($originalDateExpires));
            $PointPeriod->starts_at = $newDateStart;
            $PointPeriod->expires_at = $newDateExpires;
            $PointPeriod->save();
            */
            if(count($request->point_rule) > 0) {
                $sum = 0;
                
                foreach ($request->point_rule as $i => $v){
                    $cek = \App\PointReward::where('id',$request->id[$i])->count();
                    if($cek > 0){
                        $Points = \App\PointReward::findOrFail($request->id[$i]);
                        $Points->point_rule = $request->point_rule[$i] ?? '0';
                        $Points->bonus_amount = str_replace(',', '',$request->bonus_amount[$i]) ?? '0';
                        $Points->save();
                    }else{
                        $new_voucher = new \App\PointReward();
                        $new_voucher->client_id = \Auth::user()->client_id;
                        $new_voucher->period_id = $id;
                        $new_voucher->point_rule = $request->point_rule[$i] ?? '0';
                        $new_voucher->bonus_amount = str_replace(',', '',$request->bonus_amount[$i]) ?? '0';
                    
                        $new_voucher->save();
                    }
                }
            }

            return redirect()->route('points.details',[$vendor,\Crypt::encrypt($id)])->with('status','Point successfully updated');
        }
        else{
            return back()->withInput()->with('error','Failed to update, no point added');
        }

    }

    public function destroy(Request $request,$vendor, $id)
    {
        $points = \App\PointReward::findOrFail($id);
        $points->delete();
        
        return redirect()->route('points.index', [$vendor])
                        ->with('status', 'Point moved to trash');
    }

    public function trash($vendor){
        $pointlist = \App\PointReward::where('client_id','=',auth()->user()->client_id)
        ->onlyTrashed()
        ->get();//->paginate(10);
        
        return view('voucher_points.trash', ['pointlist' => $pointlist,'vendor'=>$vendor]);
    }

    public function restore($vendor,$id){

        $points = \App\PointReward::withTrashed()->findOrFail($id);
        if($points->trashed()){
        $points->restore();
            return redirect()->route('points.trash',[$vendor])->with('status', 'Point successfully restored');
        } else {
            return redirect()->route('points.trash',[$vendor])->with('status', 'Point is not in trash');
        }
    }

    /*public function deletePermanent($vendor, $id){

        $points = \App\PointReward::withTrashed()->findOrFail($id);
        if(!$points->trashed()){
        return redirect()->route('points.trash',[$vendor])->with('status', 'Point is not in trash!')->with('status_type', 'alert');
        } else {
            if($points->point_claim()->count()){
                return back()->with('error','Cannot delete, point has claim records');
            }else{
                
                $points->forceDelete();
                return redirect()->route('points.trash',[$vendor])->with('status', 'Point permanently deleted!');
            }
        }

    }*/

    public function deletePermanent($vendor, $id){

        $points = \App\PointReward::findOrFail($id);
        $period = \App\PointPeriod::findOrFail($points->period_id);
            if($points->point_claim()->count()){
                return back()->with('error','Cannot delete, point has claim records');
            }else{
                
                $points->forceDelete();
                return redirect()->route('points.details',[$vendor,\Crypt::encrypt($period->id)])->with('status', 'Point permanently deleted!');
            }
        

    }
}
