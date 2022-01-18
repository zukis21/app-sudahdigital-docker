<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class WorkPlanController extends Controller
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
                if(Gate::allows('work-plan')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index(Request $request, $vendor){
        $workplan = \App\WorkPlan::where('client_id',auth()->user()->client_id)
                ->orderBy('work_period','DESC')
                ->get();
        return view ('workplan.index',['workplan'=>$workplan,'vendor'=>$vendor]);
    }

    public function create($vendor)
    {
        return view('workplan.create',['vendor'=>$vendor]);
    }

    public function store(Request $request, $vendor){
        $client_id = $request->get('client_id');
        $param_date = $request->get('param_date');
        $holidays = $request->get('holidays');
        $newperiod = $param_date.'-01';
        //dd($holidays);
        
        $array = explode(",",$holidays);
        $array_0 =$array[0];
        $month=substr($array_0,5,-3);
        $year=substr($array_0,0,-6);
        $amount_holidays=count($array);
        $day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $workdays = $day - $amount_holidays;

        $new_plan = new \App\WorkPlan;
        $new_plan->client_id = $client_id;
        $new_plan->work_period = $newperiod;
        $new_plan->working_days = $workdays;
        $new_plan->save();
        if($new_plan->save()){
            $check_plan = \App\WorkPlan::where('client_id',$client_id)
                        ->where('work_period',$newperiod)->first();
            
            for($i = 0; $i< $amount_holidays; $i++){
                $create_holidays = new \App\Holiday();
                $create_holidays->wp_id = $check_plan->id;
                $create_holidays->date_holiday = $array[$i];
                $create_holidays->save();
            }
        }
        return redirect()->route('workplan.create',[$vendor])->with('status','Plans Succsessfully Created');
    }

    public function edit($vendor,$id)
    {
            $id = \Crypt::decrypt($id);
            $plan = \App\WorkPlan::findorFail($id);
            $year = date('Y', strtotime($plan->work_period));
            $month = date('m', strtotime($plan->work_period));
            $holidays = \App\Holiday::where('wp_id',$id)->pluck('date_holiday');
            $day_off = json_decode($holidays);
            
            //dd($month);
            return view('workplan.edit',['vendor'=>$vendor, 'plan'=>$plan , 'day_off'=>$day_off, 'year'=>$year, 'month'=>$month]);
        
    }

    public function update(Request $request, $vendor, $id)
    {
        
        $holidays = $request->get('holidays');
        
        $array = explode(",",$holidays);
        $array_0 =$array[0];
        $month=substr($array_0,5,-3);
        $year=substr($array_0,0,-6);
        $amount_holidays=count($array);
        $day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $workdays = $day - $amount_holidays;

        $new_plan = \App\WorkPlan::findorFail($id);
        $new_plan->working_days = $workdays;
        $new_plan->save();
        
        if($new_plan->save()){
            $del_child = \App\Holiday::where('wp_id',$id)->delete();
            if($del_child){
                for($i = 0; $i< $amount_holidays; $i++){
                    $create_holidays = new \App\Holiday();
                    $create_holidays->wp_id = $id;
                    $create_holidays->date_holiday = $array[$i];
                    $create_holidays->save();
                }
            }
        }
        return redirect()->route('workplan.edit', [$vendor, \Crypt::encrypt($id)])->with('status',
        'Holidays successfully updated');
    }
}
