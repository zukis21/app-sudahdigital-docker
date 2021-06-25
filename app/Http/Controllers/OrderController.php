<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExportMapping;
use Illuminate\Http\Request;

class OrderController extends Controller
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
                if(Gate::allows('manage-orders')) return $next($request);
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
        $user =\Auth::user()->roles;
        $id_user =\Auth::user()->id;
        $client_id = \Auth::user()->client_id;
        //dd($client_id);
        if($user == 'SUPERVISOR'){
            $status = $request->get('status');
            if($status){
            $stts = strtoupper($status);
            $orders = \DB::select("SELECT * FROM orders WHERE client_id = $client_id AND customer_id IS NOT NULL AND status='$stts' AND EXISTS 
                    (SELECT spv_id,sls_id FROM spv_sales WHERE 
                    spv_sales.sls_id = orders.user_id AND spv_id='$id_user') ORDER BY created_at DESC");
            }
            else{
                $orders = \DB::select("SELECT * FROM orders WHERE client_id = $client_id AND customer_id IS NOT NULL AND EXISTS 
                (SELECT spv_id,sls_id FROM spv_sales WHERE 
                spv_sales.sls_id = orders.user_id AND spv_id='$id_user') ORDER BY created_at DESC");
                //dd($orders);
            }
        }
        else{
            $status = $request->get('status');
            if($status){
            $orders = \App\Order::with('products')
            ->where('client_id','=',$client_id)
            ->whereNotNull('customer_id')
            ->where('status',strtoupper($status))
            ->orderBy('created_at', 'DESC')->get();//paginate(10);
            }
            else{
                $orders = \App\Order::with('products')
                ->with('customers')
                ->where('client_id','=',$client_id)
                ->whereNotNull('customer_id')
                ->orderBy('created_at', 'DESC')->get();
            //dd($orders);
            }
        }
        
        return view('orders.index', ['orders' => $orders,'vendor'=>$vendor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vendor, $id)
    {
        $order = \App\Order::findOrFail($id);
        $dateNow = date('Y-m-d H:i:s');
        $status = $request->get('status');
        if($status == 'PROCESS'){
            $order->status = $status;
            $order->process_time = $dateNow;
            //$order->save();
        }else if($status == 'FINISH'){
            $order->status = $status;
            $order->finish_time = $dateNow;
            //$order->save();
        }else if($status == 'CANCEL'){
            $order->status = $status;
            $order->cancel_time = $dateNow;
        }else{
            $order->status = $status;
        }
        $order->save();
        
        return redirect()->route('orders.detail', [$vendor,\Crypt::encrypt($order->id)])->with('status', 'Order status succesfully updated');
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
        $order = \App\Order::findOrFail($id);
        $paket_list = \DB::table('order_product')
                ->join('pakets','pakets.id','=','order_product.paket_id')
                ->join('groups','groups.id','=','order_product.group_id')
                ->where('order_id',$id)
                ->whereNotNull('paket_id')
                ->whereNotNull('group_id')
                ->whereNull('bonus_cat')
                ->distinct()
                ->get(['paket_id','group_id']);
                //dd($paket_list);
        return view('orders.detail', ['order' => $order, 'paket_list'=>$paket_list, 'vendor'=>$vendor]);
    }

    public function export_mapping($vendor) {
        return Excel::download( new OrdersExportMapping(), 'Orders.xlsx') ;
    }

    public function new_customer($vendor, $id, $payment){
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $id = \Crypt::decrypt($id);
            $cust = \App\Customer::findOrFail($id);
            $sls = \App\User::findOrFail($cust->user_id);
            return view('orders.edit_cust',['cust' => $cust,'vendor'=>$vendor, 'sls'=>$sls, 'payment'=>$payment]);
        }
        else{
            abort(403, 'Anda tidak memiliki cukup hak akses');
        } 
    }

    public function save_new_customer(Request $request, $vendor,$id)
    {
        \Validator::make($request->all(),[
            "city" => "required"
        ])->validate();

        $cust =\App\Customer::findOrFail($id);
        $cust->store_code = $request->get('store_code');
        $cust->name = $request->get('name');
        $cust->email = $request->get('email');
        $cust->phone = $request->get('phone');
        $cust->phone_owner = $request->get('phone_owner');
        $cust->phone_store = $request->get('phone_store');
        $cust->store_name = $request->get('store_name');
        $cust->city_id = $request->get('city');
        $cust->address = $request->get('address');
        $cust->client_id = $request->get('client_id');
        $pay_term = $request->get('payment_term');
        if($pay_term == 'TOP'){
            $cust->payment_term = $request->get('pay_cust').' Days';
        }else{
            $cust->payment_term = $pay_term;
        }
        $cust->status = 'ACTIVE';
        
        $cust->save();
        return redirect()->route('orders.addnew_customer',[$vendor,\Crypt::encrypt($id),$pay_term])->with('status','Customer Succsessfully Update');
    }
}
