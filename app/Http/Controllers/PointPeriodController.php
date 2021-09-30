<?php

namespace App\Http\Controllers;

use App\PointReward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PointPeriodController extends Controller
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
                if(Gate::allows('point-periods')) return $next($request);
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
        //dd($PointsProducts);
        return view ('points_periods.index',['PointsPeriods'=>$PointsPeriods,'vendor'=>$vendor]);
    }

    public function create($vendor)
    {
        
        $get_date = \App\PointPeriod::where('client_id',auth()->user()->client_id)
                       ->orderBy('expires_at','DESC')->first();
        if($get_date){
            $start_date =  date('Y-m-d', strtotime($get_date->expires_at. ' + 1 days'));
        }else{
            $start_date = '';
        }
        //dd($start_date);
        return view('points_periods.create',['vendor'=>$vendor,'start_date'=>$start_date]);
    }
    
    public function store(Request $request, $vendor){
        
        $PointPeriod = new \App\PointPeriod();
        $PointPeriod->client_id = \Auth::user()->client_id;
        $PointPeriod->name = $request->get('name');
        $originalDateStart = $request->get('starts_at');
        $originalDateExpires = $request->get('expires_at');
        $newDateStart = date("Y-m-d", strtotime($originalDateStart));
        $newDateExpires = date("Y-m-d", strtotime($originalDateExpires));
        $PointPeriod->starts_at = $newDateStart;
        $PointPeriod->expires_at = $newDateExpires;
        $PointPeriod->save();
        
        return redirect()->route('points_periods.create',[$vendor])->with('status','Point Periods Succsessfully Created');
    }

    public function edit($vendor, $id)
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
        return view('points_periods.edit',
                    [
                        'vendor'=>$vendor,
                        'PointPeriod'=>$PointPeriod,
                        'start_date'=>$start_date,
                        'end_date'=>$end_date,
                    ]);
    }

    public function update(Request $request, $vendor, $id){
        
        $PointPeriod = \App\PointPeriod::findOrFail($id);
        $PointPeriod->name = $request->get('name');
        $originalDateStart = $request->get('starts_at');
        $originalDateExpires = $request->get('expires_at');
        $newDateStart = date("Y-m-d", strtotime($originalDateStart));
        $newDateExpires = date("Y-m-d", strtotime($originalDateExpires));
        $PointPeriod->starts_at = $newDateStart;
        $PointPeriod->expires_at = $newDateExpires;
        $PointPeriod->save();

        return redirect()->route('points_periods.edit',[$vendor,\Crypt::encrypt($id)])->with('status','Points Periods Succsessfully Update');
        
    }
}
