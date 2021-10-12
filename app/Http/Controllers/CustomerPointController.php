<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerPointController extends Controller
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
                if(Gate::allows('customers-point')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index(Request $request, $vendor){
        $period = \App\PointPeriod::with('point_customers')
                ->where('client_id',auth()->user()->client_id)
                ->orderBy('id','DESC')
                ->get();
        /*$pointlist = \App\PointReward::where('client_id',auth()->user()->client_id)
                ->orderBy('id','DESC')
                ->get();*/
        return view ('customer_points.index',['period'=>$period,'vendor'=>$vendor]);
    }

    public function create($vendor, $id)
    {   
        $get_date = \App\PointPeriod::findOrFail(\Crypt::decrypt($id));
        /*$get_date = \App\PointPeriod::whereDoesntHave('point_customers', function($q){
                        $q->where('client_id',auth()->user()->client_id);
                    })
                    ->where('client_id',auth()->user()->client_id)
                    ->get();*/
        $customers = \App\Customer::where('client_id',auth()->user()->client_id)
                    ->where('status','=','ACTIVE')
                    ->get();
        return view('customer_points.create',['vendor'=>$vendor,'get_date'=>$get_date,'customers'=>$customers]);
    }

    public function store(Request $request, $vendor){
        
        $choice_check = $request->get('sel_input');
        if($choice_check == 'customer_select'){
            if($request->has('customer_id')){
                if(count($request->customer_id) > 0) {
                    $sum = 0;
                    
                    foreach ($request->customer_id as $i => $v){
                        
                        $newCustomerPoint = new \App\CustomerPoint();
                        $newCustomerPoint->client_id = \Auth::user()->client_id;
                        $newCustomerPoint->customer_id = $request->customer_id[$i];
                        $newCustomerPoint->period_id = $request->period_id;
                        
                        if($request->hasFile('file_name')){
                            $file = $request->file('file_name')[$i] ?? '';
                            if($file != ''){
                                $file_path = $file->store('customer-file-reg-point', 'public');
                        
                                $newCustomerPoint->file = $file_path;
                            }
                            
                        }
                        
                        $newCustomerPoint->save();
    
                    }
                }
                return redirect()->route('CustomerPoints.details',[$vendor,\Crypt::encrypt($request->period_id)])->with('status','Points Customers Succsessfully Created');
            }
            else{
                return back()->withInput()->with('error','Failed to save, no customer added');
            } 
        }elseif($choice_check == 'all_customer'){
            $customer = \App\Customer::where('client_id',\Auth::user()->client_id)
                        ->where('status','ACTIVE')->get();
            foreach($customer as $cs){
                $newCustomerPoint = new \App\CustomerPoint();
                $newCustomerPoint->client_id = \Auth::user()->client_id;
                $newCustomerPoint->customer_id = $cs->id;
                $newCustomerPoint->period_id = $request->period_id;
                $newCustomerPoint->save();
            }
            return redirect()->route('CustomerPoints.details',[$vendor,\Crypt::encrypt($request->period_id)])->with('status','Points Customers Succsessfully Created');
        }
        elseif($choice_check == 'customer_pareto'){
                $customer = \App\Customer::where('client_id',\Auth::user()->client_id)
                        ->whereNotNull('pareto_id')
                        ->where('status','ACTIVE')->get();
                foreach($customer as $cs){
                    $newCustomerPoint = new \App\CustomerPoint();
                    $newCustomerPoint->client_id = \Auth::user()->client_id;
                    $newCustomerPoint->customer_id = $cs->id;
                    $newCustomerPoint->period_id = $request->period_id;
                    $newCustomerPoint->save();
                }
            return redirect()->route('CustomerPoints.details',[$vendor,\Crypt::encrypt($request->period_id)])->with('status','Points Customers Succsessfully Created');
        }
    }

    public function edit($vendor,$id)
    {
        
        $get_date = \App\PointPeriod::findOrFail(\Crypt::decrypt($id));
        
        /*
        $param_id = \Crypt::decrypt($id);
        $period = \App\PointPeriod::findorFail($param_id);
        $get_date = \App\PointPeriod::whereDoesntHave('point_customers', function($q) use ($param_id) {
                        $q->where('client_id',auth()->user()->client_id)
                        ->where('period_id','!=',$param_id);
                    })
                    ->where('client_id',auth()->user()->client_id)
                    ->get();
        */
        $customers = \App\Customer::where('client_id',auth()->user()->client_id)
                ->where('status','=','ACTIVE')
                ->get();
       
        //dd($end_date);
        return view('customer_points.edit',
                    [
                        'vendor'=>$vendor,
                        'get_date'=>$get_date,
                        'customers'=>$customers
                    ]);
    }

    public function update(Request $request, $vendor, $id){
        
        if($request->has('customer_id')){
            if(count($request->customer_id) > 0) {
                $sum = 0;
                
                foreach ($request->customer_id as $i => $v){
                    $cek = \App\CustomerPoint::where('id',$request->id[$i])->count();
                    if($cek > 0){
                        $Points = \App\CustomerPoint::findOrFail($request->id[$i]);
                        $Points->customer_id = $request->customer_id[$i];
                        $Points->period_id = $request->period_id;
                        
                        if($request->hasFile('file_name')){
                            $file = $request->file('file_name')[$i] ?? '';
                            if($file != ''){
                                $file_path = $file->store('customer-file-reg-point', 'public');
                        
                                $Points->file = $file_path;
                            }
                            
                        }
                        
                        $Points->save();
                    }else{
                        $newCustomerPoint = new \App\CustomerPoint();
                        $newCustomerPoint->client_id = \Auth::user()->client_id;
                        $newCustomerPoint->customer_id = $request->customer_id[$i];
                        $newCustomerPoint->period_id = $request->period_id;
                        if($request->hasFile('file_name')){
                            $file = $request->file('file_name')[$i] ?? '';
                            if($file != ''){
                                $file_path = $file->store('customer-file-reg-point', 'public');
                        
                                $newCustomerPoint->file = $file_path;
                            }
                            
                        }
                    
                        $newCustomerPoint->save();

                    }
                }
            }
            return redirect()->route('CustomerPoints.details',[$vendor,\Crypt::encrypt($id)])->with('status','Points Customers Succsessfully Updated');
        }
        else{
            return back()->withInput()->with('error','Failed to save, no customer added');
        }
    }

    public function deletePermanent($vendor, $id){

        $point = \App\CustomerPoint::findOrFail($id);
        $period = \App\PointPeriod::findOrFail($point->period_id);
            if($point->point_claim()->count()){
                return back()->with('error','Cannot delete, customer has claim records');
            }else{
                
                $point->forceDelete();
                return redirect()->route('CustomerPoints.details',[$vendor,\Crypt::encrypt($period->id)])
                ->with('status', 'Customer permanently deleted!');
            }
        

    }
}
