<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
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
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $targets = \App\Sales_Targets::where('client_id',auth()->user()->client_id)
                        ->orderBy('period','ASC')
                        ->get();
        }else{
            $user_id = \Auth::user()->id;
            $targets = \App\Sales_Targets::where('client_id',auth()->user()->client_id)
                ->whereHas('sls_exists_spv', function($q) use($user_id)
                {
                    return $q->where('spv_id','=',"$user_id");
                })
                //->whereIn('group_id', $user)
                ->orderBy('period','ASC')
                ->get();
        }
        
        //\DB::enableQueryLog();
        //dd(\DB::getQueryLog($targets));
        //$queries = \DB::getQueryLog();
        //dd($targets);
        
        return view ('target.index',['targets'=>$targets,'vendor'=>$vendor]);
    }

    public function cust_index(Request $request, $vendor){
        //\DB::connection()->enableQueryLog();
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            /*$targets = \App\Store_Targets::where('client_id',auth()->user()->client_id)
                        ->orderBy('period','ASC')
                        ->groupBy('period')
                        ->get();*/
            $targets = \DB::table('store_target')
                        ->where('client_id',auth()->user()->client_id)
                        ->select('period', 'target_type',DB::raw('count(*) as total, SUM(target_values) as total_value,
                            SUM(target_quantity) as total_qty '))
                        //->select(DB::raw("SUM(target_values) as total_target"))
                        ->groupBy('period')
                        ->get();
            //dd($targets);

            return view ('customer_store.index_target',['targets'=>$targets,'vendor'=>$vendor]);
        }else{
            abort(404, 'Tidak ditemukan');
        }
        
    }

    public function create_target($vendor)
    {
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $users = \App\User::where('client_id',auth()->user()->client_id)
                    ->where('roles','=','SALES')
                    ->where('status','=','ACTIVE')
                    ->get();
        }else{
            $user_id = \Auth::user()->id;
            //$id_user = \Crypt::decrypt($id);
            //$user = \App\User::findorFail($id_user);
            $users = \App\User::where('client_id',auth()->user()->client_id)
                    ->whereHas('sls_exists', function($q) use($user_id)
                    {
                        return $q->where('spv_id','=',"$user_id");
                    })
                    //->whereIn('group_id', $user)
                    ->where('roles','=','SALES')
                    ->where('status','=','ACTIVE')
                    ->get();
        }
            
            return view('target.create_target',['vendor'=>$vendor,'users'=>$users]);
    }

    public function cust_create_target($vendor)
    {
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $customers = \App\Customer::where('client_id',auth()->user()->client_id)
                    ->whereNotNull('pareto_id')
                    ->where('status','=','ACTIVE')
                    ->get();
            return view('customer_store.create_target',['vendor'=>$vendor,'customers'=>$customers]);
        }else{
            abort(404, 'Tidak ditemukan');
        }
    }

    public function store_target(Request $request, $vendor)
    {
        $user_id = $request->get('user_id');
        $date_period = $request->get('period');
        if($request->has('ppn')){
            $ppn=$request->get('ppn');
        }else{
            $ppn = 0;
        }
        $date_explode = explode('-',$date_period);
        $year = $date_explode[0];
        $month = $date_explode[1];
        //dd($year);
        $orders = \App\Order::where('user_id',$user_id)
                ->whereNotNull('customer_id')
                ->where('status','!=','CANCEL')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)->count();
        if($orders > 0){
                $targ_ach = \App\Order::where('user_id',$user_id)
                        ->whereNotNull('customer_id')
                        ->where('status','!=','CANCEL')
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->selectRaw('sum(total_price) as sum')
                        ->pluck('sum');
                //$ach = json_encode($targ_ach,JSON_NUMERIC_CHECK);
                $ach = json_decode($targ_ach,JSON_NUMERIC_CHECK);
                $ach_value_param = $ach[0];
                if($ppn > 0){
                    $ach_value = $ach_value_param / 1.1;
                }else{
                    $ach_value = $ach_value_param;
                }
                //dd($ach_value);
        }else{
            $ach_value = 0;
        }
        //dd($ach);      
        $new_t = new \App\Sales_Targets;
        $new_t->client_id = $request->get('client_id');
        $new_t->user_id = $user_id;

        $new_t->target_type = $request->get('target_type');
        $target_value = $request->get('target_value');
        if($target_value == ''){
            $new_t->target_values = 0;
        }else{
            $new_t->target_values = str_replace(',', '', $target_value);
        }
        
        $new_t->target_achievement = $ach_value;
        $period = $date_period.'-01';
        $new_t->period = $period;
        $new_t->created_by = \Auth::user()->id;
        $new_t->ppn =$ppn;

        $target_qty = $request->get('target_quantity');
        if($target_qty == ''){
            $new_t->target_quantity = 0;
        }else{
            $new_t->target_quantity = $target_qty;
        }
        
        $new_t->save();
        if ( $new_t->save()){
            return redirect()->route('sales.create_target',[$vendor])->with('status','Target Succsessfully Created');
        }else{
            return redirect()->route('sales.create_target',[$vendor])->with('error','Target Not Succsessfully Created');
        }
    }

    public function cust_store_target(Request $request, $vendor)
    {
        if(count($request->customer_id) > 0) {
            $sum = 0;
            
            
                foreach ($request->customer_id as $i => $v){
                    //dd($i);
                    if($request->target_type == 1){
                        $data_target=array(
                            'client_id'=>$request->client_id,
                            'customer_id'=>$request->customer_id[$i],
                            'target_quantity'=>$request->target_quantity[$v],
                            'period'=>$request->period.'-01',
                            'created_by'=>\Auth::user()->id,
                            'version_pareto'=>$request->version_pareto[$i],
                            'target_type'=>$request->target_type
                        );
                    }elseif($request->target_type == 2){
                        $data_target=array(
                            'client_id'=>$request->client_id,
                            'customer_id'=>$request->customer_id[$i],
                            'target_values'=>str_replace(',', '', $request->target_value[$v]) ?? '0',
                            'period'=>$request->period.'-01',
                            'created_by'=>\Auth::user()->id,
                            'version_pareto'=>$request->version_pareto[$i],
                            'target_type'=>$request->target_type
                        );
                    }else{
                        $data_target=array(
                            'client_id'=>$request->client_id,
                            'customer_id'=>$request->customer_id[$i],
                            'target_values'=>str_replace(',', '', $request->target_value[$v]) ?? '0',
                            'target_quantity'=>$request->target_value[$v],
                            'period'=>$request->period.'-01',
                            'created_by'=>\Auth::user()->id,
                            'version_pareto'=>$request->version_pareto[$i],
                            'target_type'=>$request->target_type
                        );
                    }
                    $new_t = new \App\Store_Targets;
                    $new_t->create($data_target);
                }
        
            
            /*foreach ($request->customer_id as $i => $v){
                $data_target=array(
                    'client_id'=>$request->client_id,
                    'customer_id'=>$request->customer_id[$i],
                    'target_values'=>str_replace(',', '', $request->target_value)[$i] ?? '0',
                    'period'=>$request->period.'-01',
                    'created_by'=>\Auth::user()->id,
                    'version_pareto'=>$request->version_pareto[$i],
                );
                $new_t = new \App\Store_Targets;
                $new_t->create($data_target);
            }*/
        }

        return redirect()->route('customers.index_target',[$vendor])->with('status','Target Succsessfully Created');
        /*

        $customer_id = $request->get('customer_id');
        $date_period = $request->get('period');
        $startdate = $date_period.'-01';

        $date_explode = explode('-',$date_period);
        $year = $date_explode[0];
        $month = $date_explode[1];

        $min_period = \App\Store_Targets::where('period','>',$startdate)
                     ->min('period');
        
        if($min_period != null){
            $enddate = date("Y-m", strtotime("$min_period-1 months"));

            if($enddate == $date_period){
                $orders = \App\Order::where('customer_id',$customer_id)
                        ->where('status','!=','CANCEL')
                        ->whereMonth('created_at','>=',$month)
                        ->whereYear('created_at','>=',$year)->count();
                if($orders > 0){
                        $targ_ach = \App\Order::where('customer_id',$customer_id)
                                ->where('status','!=','CANCEL')
                                ->whereMonth('created_at', $month)
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
            }else{
                $tgl_terakhir = date('Y-m-t', strtotime($enddate));
                $orders_count = \App\Order::where('customer_id',$customer_id)
                        ->where('status','!=','CANCEL')
                        ->whereBetween('created_at',[$startdate, $tgl_terakhir])
                        ->count();
                if($orders_count > 0){
                    $targ_ach = \App\Order::where('customer_id',$customer_id)
                        ->where('status','!=','CANCEL')
                        ->whereBetween('created_at',[$startdate, $tgl_terakhir])
                        ->selectRaw('sum(total_price) as sum')
                        ->pluck('sum');
                    //$ach = json_encode($targ_ach,JSON_NUMERIC_CHECK);
                    $ach = json_decode($targ_ach,JSON_NUMERIC_CHECK);
                    $ach_value = $ach[0];
                }else{
                    $ach_value = 0;
                }
            }
        }
        
        //dd($ach);      
        $new_t = new \App\Sales_Targets;
        $new_t->client_id = $request->get('client_id');
        $new_t->user_id = $user_id;
        $new_t->target_values = $request->get('target_value');
        $new_t->target_achievement = $ach_value;
        $period = $date_period.'-01';
        $new_t->period = $period;
        $new_t->created_by = \Auth::user()->id;
        $new_t->save();
        
        if ( $new_t->save()){
            return redirect()->route('sales.create_target',[$vendor])->with('status','Target Succsessfully Created');
        }else{
            return redirect()->route('sales.create_target',[$vendor])->with('error','Target Not Succsessfully Created');
        }
        */
    }

    public function addnew_target(Request $request, $vendor, $period)
    {
        if(count($request->customer_id) > 0) {
            $sum = 0;
            //dd(str_replace(',', '', $request->target_value));
            
            foreach ($request->customer_id as $i => $v){
                
                if($request->target_type == 1){
                    $data_target=array(
                        'client_id'=>$request->client_id,
                        'customer_id'=>$request->customer_id[$i],
                        'target_quantity'=>$request->target_quantity[$v],
                        'period'=>$request->period.'-01',
                        'created_by'=>\Auth::user()->id,
                        'version_pareto'=>$request->version_pareto[$i],
                        'target_type'=>$request->target_type
                    );
                }elseif($request->target_type == 2){
                    $data_target=array(
                        'client_id'=>$request->client_id,
                        'customer_id'=>$request->customer_id[$i],
                        'target_values'=>str_replace(',', '', $request->target_value[$v]) ?? '0',
                        'period'=>$request->period.'-01',
                        'created_by'=>\Auth::user()->id,
                        'version_pareto'=>$request->version_pareto[$i],
                        'target_type'=>$request->target_type
                    );
                }else{
                    $data_target=array(
                        'client_id'=>$request->client_id,
                        'customer_id'=>$request->customer_id[$i],
                        'target_values'=>str_replace(',', '', $request->target_value[$v]) ?? '0',
                        'target_quantity'=>$request->target_value[$v],
                        'period'=>$request->period.'-01',
                        'created_by'=>\Auth::user()->id,
                        'version_pareto'=>$request->version_pareto[$i],
                        'target_type'=>$request->target_type
                    );
                }
                $new_t = new \App\Store_Targets;
                $new_t->create($data_target);
            }
        }

        return redirect()->route('customers.edit_target',[$vendor, \Crypt::encrypt($period)])->with('status','Customers Target Succsessfully Add');
    }
    
    public function edit_target($vendor,$id)
    {
            $id = \Crypt::decrypt($id);
            $target = \App\Sales_Targets::findorFail($id);
            $user = \App\User::findorFail($target->user_id);
            return view('target.edit_target',['vendor'=>$vendor, 'user'=>$user, 'target'=>$target]);
        
    }

    public function cust_edit_target($vendor,$id)
    {
            $id = \Crypt::decrypt($id);
            //dd($id);
            $target = \App\Store_Targets::where('client_id',auth()->user()->client_id)
                    ->where('period',$id)->get();
            
            $type = $target->first();
            //dd($target->first());
                  
            $exist_store = \App\Customer::with('store_targets')
                         ->whereNotNull('pareto_id')
                         ->whereDoesnthave('store_targets',function($q) use ($id)
                         {
                             return $q->where('period',$id)
                                     ->where('client_id',auth()->user()->client_id);
                         })
                      ->where('client_id',auth()->user()->client_id)
                      ->get();
            //dd(count($exist_store));
            
            return view('customer_store.edit_target',['vendor'=>$vendor, 'type'=>$type, 'target'=>$target, 'period'=>$id, 'exist_store'=>$exist_store,]);
    }
    
    public function update_target(Request $request, $vendor)
    {
        $id_target = $request->get('target_id');
        $new_t = \App\Sales_Targets::findorFail($id_target);
        $date_period = $request->get('period');
        if($request->has('ppn')){
            $ppn=$request->get('ppn');
        }else{
            $ppn = 0;
        }
        $date_explode = explode('-',$date_period);
        $year = $date_explode[0];
        $month = $date_explode[1];

        $orders = \App\Order::where('user_id',$new_t->user_id)
                ->whereNotNull('customer_id')
                ->where('status','!=','CANCEL')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)->count();
        if($orders > 0){
                $targ_ach = \App\Order::where('user_id',$new_t->user_id)
                        ->whereNotNull('customer_id')
                        ->where('status','!=','CANCEL')
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->selectRaw('sum(total_price) as sum')
                        ->pluck('sum');
                //$ach = json_encode($targ_ach,JSON_NUMERIC_CHECK);
                $ach = json_decode($targ_ach,JSON_NUMERIC_CHECK);
                $ach_value_param = $ach[0];
                if($ppn > 0){
                    $ach_value = $ach_value_param / 1.1;
                }else{
                    $ach_value = $ach_value_param;
                }
        }else{
            $ach_value = 0;
        }

        $target_type = $request->get('target_type');
        $new_t->target_type = $target_type;
        if($target_type == '1'){
            $target_qty = $request->get('target_quantity');
            $new_t->target_quantity = $target_qty;
            $new_t->target_values = 0;
        }elseif($target_type == '2'){
            $new_t->target_quantity = 0;
            $target_value = $request->get('target_value');
            $new_t->target_values = str_replace(',', '', $target_value);
        }else{
            $target_qty = $request->get('target_quantity');
            $target_value = $request->get('target_value');
            $new_t->target_quantity = $target_qty;
            $new_t->target_values = str_replace(',', '', $target_value);
        }
        
        /*$target_value = $request->get('target_value');
        if($target_value == ''){
            $new_t->target_values = 0;
        }else{
            $new_t->target_values = str_replace(',', '', $target_value);
        }*/

        //$new_t->target_values = str_replace(',', '', $request->get('target_value'));
        $new_t->target_achievement = $ach_value;
        $period = $date_period.'-01';
        $new_t->period = $period;
        $new_t->updated_by = \Auth::user()->id;
        $new_t->ppn = $ppn;

        $new_t->save();
        if ( $new_t->save()){
            return redirect()->route('sales.edit_target',[$vendor, \Crypt::encrypt($id_target)])->with('status','Target Succsessfully Update');
        }else{
            return redirect()->route('sales.edit_target',[$vendor])->with('error','Target Not Succsessfully Update');
        }
    }

    public function cust_update_target(Request $request, $vendor, $period)
    {
        if(count($request->id) > 0) {
            $sum = 0;
            foreach ($request->id as $i => $v){
                if($request->target_type == 1){
                    $data_target=array(
                        'target_quantity'=>$request->target_quantity[$v],
                        'target_type'=>$request->target_type,
                        'updated_by'=>\Auth::user()->id,
                    ); 
                }elseif($request->target_type == 2){
                    $data_target=array(
                        'target_values'=>str_replace(',', '', $request->target_value[$v]) ?? '0',
                        'target_type'=>$request->target_type,
                        'updated_by'=>\Auth::user()->id,
                    );
                }else{
                    $data_target=array(
                        'target_values'=>str_replace(',', '', $request->target_value[$v]) ?? '0',
                        'target_quantity'=>$request->target_quantity[$v],
                        'target_type'=>$request->target_type,
                        'updated_by'=>\Auth::user()->id,
                    );
                }
                
                $new_t = \App\Store_Targets::where('id',$request->id[$i])->first();
                $new_t->update($data_target);
            }
        }

        return redirect()->route('customers.edit_target',[$vendor, \Crypt::encrypt($period)])->with('status','Target Succsessfully Update');
        
        /*$id_target = $request->get('target_id');
        $new_t = \App\Store_Targets::findorFail($id_target);
        

        $new_t->target_values = $request->get('target_value');
        
        $new_t->updated_by = \Auth::user()->id;
        $new_t->save();
        
        if ( $new_t->save()){
            return redirect()->route('customers.edit_target',[$vendor, \Crypt::encrypt($id_target)])->with('status','Target Succsessfully Update');
        }else{
            return redirect()->route('customers.edit_target',[$vendor])->with('error','Target Not Succsessfully Update');
        }*/
    }
}
