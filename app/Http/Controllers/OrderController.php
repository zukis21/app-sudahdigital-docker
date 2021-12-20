<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExportMapping;
use App\Exports\OrdersThisPeriod;
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
        $datefrom = date('2021-06-01');
        //dd($client_id);
        if($user == 'SUPERVISOR'){
            $status = $request->get('status');
            if($status){
            $stts = strtoupper($status);
            $orders = \DB::select("SELECT * FROM orders WHERE 
                        client_id = $client_id AND customer_id IS NOT NULL AND 
                        status='$stts' AND created_at >= $datefrom AND EXISTS 
                    (SELECT spv_id,sls_id FROM spv_sales WHERE 
                    spv_sales.sls_id = orders.user_id AND spv_id='$id_user') ORDER BY created_at DESC");
            }
            else{
                $orders = \DB::select("SELECT * FROM orders WHERE client_id = $client_id AND 
                customer_id IS NOT NULL AND created_at >= $datefrom AND EXISTS 
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
            ->where('created_at','>=',$datefrom)
            ->orderBy('created_at', 'desc')
            ->get();//paginate(10);
            }
            else{
                $orders = \App\Order::with('products')
                ->with('customers')
                ->where('client_id','=',$client_id)
                ->whereNotNull('customer_id')
                ->where('created_at','>=',$datefrom)
                ->orderBy('created_at', 'desc')
                ->get();
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
        $prevStatus = $request->get('prevStatus');
        if($status == 'PROCESS'){
            $order->status = $status;
            $order->process_time = $dateNow;
            //$order->save();
        }else if($status == 'FINISH'){
            $order->status = $status;
            $order->finish_time = $dateNow;
            if($prevStatus !== 'PARTIAL-SHIPMENT'){
                $stock_status= \DB::table('product_stock_status')
                        ->where('client_id',\Auth::user()->client_id)->first();
                if($stock_status->stock_status == 'ON'){
                        $cek_quantity = \App\Order::with('products')->where('id',$id)->get();
                        foreach($cek_quantity as $q){
                            foreach($q->products as $p){
                                $up_product = \App\product::findOrfail($p->pivot->product_id);
                                $up_product->stock -= $p->pivot->quantity;
                                $up_product->save();
                            }
                        }
                }
            }
            //$order->save();
        }else if($status == 'CANCEL'){
            $order->status = $status;
            $order->cancel_time = $dateNow;
            $order->notes_cancel = $request->get('notes_cancel');
            $order->canceled_by = \Auth::user()->id;
        }else if($status == 'PARTIAL-SHIPMENT'){
            $order->status = $status;
            $order->NotesPartialShip = $request->get('partialDeliveryNotes');
            foreach ($request->order_productId as $i => $v){
                /*$detail_order=array(
                    'deliveryQty'=>$request->deliveryQty[$v],
                );*/
                $new_dtl = \App\order_product::where('id',$request->order_productId[$i])->first();
                $new_dtl->deliveryQty += $request->deliveryQty[$v];
                $new_dtl->save();
                if($new_dtl->save()){
                    $prd = \App\product::findOrfail($request->productId[$i]);
                    $prd->stock -= $request->deliveryQty[$v];
                    $prd->save();
                }
            }
        }
        else{
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
        if($order->canceled_by != null){
            $order_cancel = \App\User::findOrFail($order->canceled_by);
        }else{
            $order_cancel = null;        
        }
        
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
        return view('orders.detail', ['order' => $order, 'paket_list'=>$paket_list, 'vendor'=>$vendor,'order_cancel'=>$order_cancel]);
    }

    /*public function export_mapping($vendor) {
        return Excel::download( new OrdersExportMapping(), 'Orders.xlsx') ;
    }*/

    public function export_mapping(Request $request, $vendor){
        $period = $request->get('period');
        $date_explode = explode('-',$period);
        $year = $date_explode[0];
        $month = $date_explode[1];
        //$type = $request->get('target_type');
        
        return Excel::download(new OrdersExportMapping($year,$month), 'Orders.xlsx');
    } 
    
    public function exportThisPeriod($vendor){
        $year = date('Y');
        $month = date('m');
        return Excel::download(new OrdersThisPeriod($year,$month), 'Orders.xlsx');
    }
      

    public function new_customer($vendor, $id, $payment = null){
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
