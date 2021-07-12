<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;

class TargetController extends Controller
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
                if(Gate::allows('manage-target')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });

    }

    public function index(Request $request, $vendor){
        //\DB::connection()->enableQueryLog();
        $user_id = \Auth::user()->id;
        $targets = \App\Sales_Targets::whereHas('sls_exists_spv', function($q) use($user_id)
                {
                    return $q->where('spv_id','=',"$user_id");
                })
                //->whereIn('group_id', $user)
                ->orderBy('period','ASC')
                ->get();
                //\DB::enableQueryLog();
                //dd(\DB::getQueryLog($targets));
        //$queries = \DB::getQueryLog();
        //dd($targets);
        
        return view ('target.index',['targets'=>$targets,'vendor'=>$vendor]);
    }

    public function create_target($vendor)
    {
            $user_id = \Auth::user()->id;
            //$id_user = \Crypt::decrypt($id);
            //$user = \App\User::findorFail($id_user);
            $users = \App\User::whereHas('sls_exists', function($q) use($user_id)
                    {
                        return $q->where('spv_id','=',"$user_id");
                    })
                    //->whereIn('group_id', $user)
                    ->where('roles','=','SALES')
                    ->get();
            return view('target.create_target',['vendor'=>$vendor,'users'=>$users]);
    }

    public function store_target(Request $request, $vendor)
    {
        $user_id = $request->get('user_id');
        $date_period = $request->get('period');
        $date_explode = explode('-',$date_period);
        $year = $date_explode[0];
        $month = $date_explode[1];
        //dd($month);
        $orders = \App\Order::where('user_id',$user_id)
                ->whereNotNull('customer_id')
                ->where('status','!=','CANCEL')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)->count();
        if($orders > 0){
                $targ_ach = \App\Order::where('user_id',$user_id)
                        ->whereNotNull('customer_id')
                        ->where('status','!=','CANCEL')
                        ->whereMonth('created_at', '=', $month)
                        ->whereYear('created_at', $year)
                        ->selectRaw('sum(total_price) as sum')
                        ->pluck('sum');
                //$ach = json_encode($targ_ach,JSON_NUMERIC_CHECK);
                $ach = json_decode($targ_ach,JSON_NUMERIC_CHECK);
                $ach_value = $ach[0];
                //dd($ach_value);
        }else{
            $ach_value = 0;
        }
        //dd($ach);      
        $new_t = new \App\Sales_Targets;
        $new_t->client_id = $request->get('client_id');
        $new_t->user_id = $user_id;
        $new_t->target_values = $request->get('target_value');
        $new_t->target_achievement = $ach_value;
        $period = $date_period.'-01';
        $new_t->period = $period;
        $new_t->save();
        if ( $new_t->save()){
            return redirect()->route('sales.create_target',[$vendor])->with('status','Target Succsessfully Created');
        }else{
            return redirect()->route('sales.create_target',[$vendor])->with('error','Target Not Succsessfully Created');
        }
    }

    public function edit_target($vendor,$id)
    {
            $id = \Crypt::decrypt($id);
            $target = \App\Sales_Targets::findorFail($id);
            $user = \App\User::findorFail($target->user_id);
            return view('target.edit_target',['vendor'=>$vendor, 'user'=>$user, 'target'=>$target]);
        
    }
    
    public function update_target(Request $request, $vendor)
    {
        $id_target = $request->get('target_id');
        $new_t = \App\Sales_Targets::findorFail($id_target);
        $new_t->target_values = $request->get('target_value');
        $new_t->period = $request->get('period').'-01';
        $new_t->save();
        if ( $new_t->save()){
            return redirect()->route('sales.edit_target',[$vendor, \Crypt::encrypt($id_target)])->with('status','Target Succsessfully Update');
        }else{
            return redirect()->route('sales.edit_target',[$vendor])->with('error','Target Not Succsessfully Update');
        }
    }
}
