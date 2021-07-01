<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\product;
use RealRashid\SweetAlert\Facades\Alert;


class TransaksiSalesController extends Controller
{   
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $param = \Route::current()->parameter('vendor');
            //dd($param);
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            //dd($client->client_slug);
            if($client->client_slug == $param){
                
                //dd(\Request::session()->get('client_sess'));
                return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }
    
    public function index(Request $request, $vendor, $status = null){
        $user_id = \Auth::user()->id;
        //$categories = \App\Category::all();//paginate(10);
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        $paket = \App\Paket::where('client_id',\Auth::user()->client_id)->first();
        if($status){
            $orders = \App\Order::with('products')->whereNotNull('customer_id')
                    ->where('user_id','=',"$user_id")
                    ->where('client_id',\Auth::user()->client_id)
                    ->where('status',strtoupper($status))
                    ->orderBy('created_at', 'DESC')->get();//paginate(10);
        }else{
            $orders = \App\Order::with('products')->whereNotNull('customer_id')
                    ->where('user_id','=',"$user_id")
                    ->where('client_id',\Auth::user()->client_id)
                    ->orderBy('created_at', 'DESC')->get();//->paginate(20);
        }
        
        $order_count = $orders->count();
        
        $data=['vendor'=>$vendor, 'order_count'=>$order_count, 'orders'=>$orders,'paket'=>$paket, 'client'=>$client];//'categories'=>$categories,];
       
        return view('customer.pesanan',$data);

    }

    public function change_status(Request $request, $vendor){
        $order = \App\Order::findOrFail($request->get('order_id'));
        $dateNow = date('Y-m-d H:i:s');
        $user_id = \Auth::user()->id;
        $order->status = 'CANCEL';
        $order->cancel_time = $dateNow;
        $order->notes_cancel = $request->get('notes_cancel');
        $order->canceled_by = $user_id;
        $order->save();
        
        return redirect()->route('pesanan', [$vendor])->with('toast_success','Pesanan berhasil dibatalkan');
    }
}