<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomersImport;
use App\Exports\CitiesExport;
use App\Exports\CustomerExport;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
                if(Gate::allows('manage-customers')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $vendor)
    {
        if(Gate::check('isSpv')){
            $client_id = \Auth::user()->client_id;
            $spv_id = \Auth::user()->id;
            $customers = \DB::select("SELECT c.*, ct.city_name, u.id as user_id, u.name as user_name  
                        FROM customers c, cities ct, users u WHERE c.status != 'NEW'
                        AND c.client_id = $client_id AND c.user_id = u.id AND c.city_id = ct.id AND EXISTS
                            (
                                SELECT * FROM  spv_sales
                                WHERE   spv_sales.sls_id = c.user_id
                                AND spv_sales.spv_id ='$spv_id'
                            )
                        ");
            
            
            $status = $request->get('status');
            
            if($status){
                $customers = \DB::select("SELECT c.*, ct.city_name, u.id as user_id, u.name as user_name  
                FROM customers c, cities ct, users u WHERE c.status != 'NEW'
                AND c.client_id = $client_id AND c.user_id = u.id AND c.city_id = ct.id 
                AND c.status LIKE '%$status%' AND EXISTS
                    (
                        SELECT * FROM  spv_sales
                        WHERE   spv_sales.sls_id = c.user_id
                        AND spv_sales.spv_id ='$spv_id'
                    )
                ");
            }
        }
        else{
            $customers = \App\Customer::with('users')->with('cities')
            ->where('client_id','=',auth()->user()->client_id)
            ->where('status','!=','NEW')->orderBy('id','DESC')->get();//paginate(10);
            //$filterkeyword = $request->get('keyword');
            $status = $request->get('status');
            
            if($status){
                $customers = \App\Customer::with('users')->with('cities')
                ->where('client_id','=',auth()->user()->client_id)
                ->where('status', 'Like', "%$status")->orderBy('id','DESC')->get();//paginate(10);
            }
        }
        
        return view ('customer_store.index',['customers'=>$customers,'vendor'=>$vendor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendor)
    {
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            return view('customer_store.create',['vendor'=>$vendor]);
        }
        else{
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vendor)
    {
        $new_cust = new \App\Customer;
        $new_cust->store_code = $request->get('store_code');
        $new_cust->name = $request->get('name');
        $new_cust->email = $request->get('email');
        $new_cust->phone = $request->get('phone');
        $new_cust->phone_owner = $request->get('phone_owner');
        $new_cust->phone_store = $request->get('phone_store');
        $new_cust->store_name = $request->get('store_name');
        $new_cust->city_id = $request->get('city_id');
        $new_cust->address = $request->get('address');
        $new_cust->payment_term = $request->get('payment_term');
        $new_cust->user_id = $request->get('user_id');
        $new_cust->client_id = $request->get('client_id');
        
        $new_cust->save();
        if ( $new_cust->save()){
            return redirect()->route('customers.create',[$vendor])->with('status','Customer Succsessfully Created');
        }else{
            return redirect()->route('customers.create',[$vendor])->with('error','Customer Not Succsessfully Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($vendor,$id)
    {
        $id = \Crypt::decrypt($id);
        $cust = \App\Customer::findOrFail($id);
        return view('customer_store.edit',['cust' => $cust,'vendor'=>$vendor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vendor,$id)
    {
        $cust =\App\Customer::findOrFail($id);
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $cust->store_code = $request->get('store_code');
            $cust->name = $request->get('name');
            $cust->email = $request->get('email');
            $cust->phone = $request->get('phone');
            $cust->phone_owner = $request->get('phone_owner');
            $cust->phone_store = $request->get('phone_store');
            $cust->store_name = $request->get('store_name');
            $cust->city_id = $request->get('city_id');
            $cust->address = $request->get('address');
            $cust->payment_term = $request->get('payment_term');
            $cust->user_id = $request->get('user_id');
        }
        else{
            $cust->cust_type = $request->get('cust_type');
        }   
        $cust->save();
        return redirect()->route('customers.edit',[$vendor,\Crypt::encrypt($id)])->with('status','Customer Succsessfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detail($vendor,$id)
    {
        $id = \Crypt::decrypt($id);
        $customer = \App\Customer::findOrFail($id);
        return view('customer_store.detail', ['customer' => $customer,'vendor'=>$vendor]);
    }

    public function deletePermanent($vendor,$id){

        $cust = \App\Customer::findOrFail($id);
        //dd($id);
        $order_cust = \App\Order::where('customer_id','=',"$id")->count();
        //dd($order_cust);
        if($order_cust > 0){
            return redirect()->route('customers.index',[$vendor])->with('error', 'Cannot be deleted, because this data already exists in orders');
        }
        else {
        $cust->forceDelete();
        return redirect()->route('customers.index',[$vendor])->with('status', 'Customer permanently deleted!');
        }

    }

    public function export($vendor) {
        return Excel::download( new CustomerExport(), 'Customers.xlsx') ;
    }

    public function exportCity($vendor) {
        return Excel::download( new CitiesExport(), 'City List.xlsx') ;
    }

    public function import($vendor){
        return view('customer_store.import_customers',['vendor'=>$vendor]);
    }

    public function import_data(Request $request, $vendor){
        \Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx"
        ])->validate();
            
        $data = Excel::import(new CustomersImport, request()->file('file'));
        return redirect()->route('customers.import',[$vendor])->with('status', 'File successfully upload');
    }
}
