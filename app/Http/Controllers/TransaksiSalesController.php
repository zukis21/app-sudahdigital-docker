<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
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
            $orders = \App\Order::with('products')
                    ->whereNotNull('customer_id')
                    ->where('user_id','=',"$user_id")
                    //->where('client_id',\Auth::user()->client_id)
                    ->where('status',strtoupper($status))
                    ->orderBy('created_at', 'DESC')->get();//paginate(10);
        }else{
            $orders = \App\Order::with('products')
                    ->whereNotNull('customer_id')
                    ->where('user_id','=',"$user_id")
                    //->where('client_id',\Auth::user()->client_id)
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
        if($order->save()){
            $order_wa = \App\Order::findOrFail($request->get('order_id'));
            $client_name = \App\B2b_client::findOrfail($order_wa->client_id);
            $wa_numb=$client_name->phone_whatsapp;
            $customer = \App\Customer::findOrfail($order_wa->customer_id);
            $user = \App\User::findOrfail($user_id);
            $text_cancel = $request->get('notes_cancel');

            //minus ach
            $month = date('m',strtotime($order_wa->created_at));
            $year = date('Y',strtotime($order_wa->created_at));
                $target_ach = \App\Sales_Targets::where('user_id',$user_id)
                            //->where('client_id',$client_id)
                            ->whereMonth('period', $month)
                            ->whereYear('period', $year)->first();
                //dd($target_ach);
                if($target_ach){
                    $target_ach->target_achievement -=  $order_wa->total_price;
                    $target_ach->save();
                }

$txt_descwa='*PEMBATALAN PESANAN*,

*Detail Sales*
Nama : '.$user->name.',
Email : '.$user->email.',
No. Hp : ' .$user->phone.',
Sales Area : ' .$user->sales_area.',

*Detail Pelanggan*
Nama  : '.$customer->name.',
Email : '.$customer->email.',
No. WA : '.$customer->phone.',
No. Owner : '.$customer->phone_owner.',
No. Toko : '.$customer->phone_store.',
Nama Toko : '.$customer->store_name.',
Alamat : '.$customer->address.',
';

        //$href=urlencode($txt_wa);
        
        $groupby_paket = DB::table('order_product')
                        ->where('order_id',$order_wa->id)
                        ->whereNotNull('paket_id')
                        ->whereNotNull('group_id')
                        ->whereNull('bonus_cat')
                        ->distinct()
                        ->get(['paket_id','group_id']);
        $krj_paket=count($groupby_paket);
        if($krj_paket > 0){
$ttle_pesan_pkt='*Detail Pesanan Paket*
';
$ttle_bns='*Bonus*
';
$no=0;
            foreach($groupby_paket as $key=>$dtl_pkt){
                $no++;
                $paket_name =\App\Paket::where('id',$dtl_pkt->paket_id)
                            ->first();
                $group_name =\App\Group::where('id',$dtl_pkt->group_id)
                            ->first();
                $ttle_pesan_pkt.= '*_'.$no.'. '.$paket_name->display_name.' - '.$group_name->display_name.':_*
';
                $data_paket = DB::table('order_product')
                            ->join('products','order_product.product_id','=','products.id')
                            ->where('order_id','=',$order_wa->id)
                            ->where('group_id','=',$dtl_pkt->group_id)
                            ->where('paket_id','=',$dtl_pkt->paket_id)
                            ->whereNull('bonus_cat')
                            ->get();
                foreach($data_paket as $key=>$dp){
                    $ttle_pesan_pkt.='* '.$dp->Product_name.' (Qty :'.$dp->quantity.')
';
                }

                $data_bonus = DB::table('order_product')
                            ->join('orders','order_product.order_id','=','orders.id')
                            ->join('products','order_product.product_id','=','products.id')
                            ->where('orders.id','=',$order_wa->id)
                            ->where('group_id','=',$dtl_pkt->group_id)
                            ->where('paket_id','=',$dtl_pkt->paket_id)
                            ->whereNotNull('bonus_cat')
                            ->get();
                foreach($data_bonus as $db){
                    $ttle_pesan_pkt.= '* '.$db->Product_name.' (Qty :'.$db->quantity.'~ *Bonus*)
';
                }
            }
        }
        
        //detil non paket
        $pesan = DB::table('order_product')
                ->join('orders','order_product.order_id','=','orders.id')
                ->join('products','order_product.product_id','=','products.id')
                ->where('orders.id','=',$order_wa->id)
                ->where('group_id','=',NULL)
                ->where('paket_id','=',NULL)
                ->get();
        if(count($pesan) > 0){
$ttle_nonpkt='*Detail Pesanan Non Paket*
';
            foreach($pesan as $key=>$tele){
                $ttle_nonpkt.='* '.$tele->Product_name.' (Qty :'.$tele->quantity.')
';
            }
        }
        
        $info_harga = '*Total Pesanan* : Rp.'.number_format(($order_wa->total_price), 0, ',', '.').'%0A*Pembayaran* : '.$order_wa->payment_method;
        
        if($order_wa->notes != NULL){
            $notes_wa = $order_wa->notes;
        }
        else{
            $notes_wa = '-';
        } 

        if(($krj_paket > 0) && (count($pesan) > 0)){
            $list_text = urlencode($txt_descwa).'%0A'.urlencode($ttle_pesan_pkt).'%0A'.urlencode($ttle_nonpkt);
        }
        elseif(($krj_paket > 0) && (count($pesan) <= 0)){
            $list_text = urlencode($txt_descwa).'%0A'.urlencode($ttle_pesan_pkt);
        }
        else{
            $list_text = urlencode($txt_descwa).'%0A'.urlencode($ttle_nonpkt);
        }

        $note_sales = '*Catatan Pesanan* : '.$notes_wa;
        $note_cancel = '*Alasan Pembatalan Order* : '.$text_cancel;
        $text_wa=$list_text.'%0A'.$info_harga.'%0A'.$note_sales.'%0A'.$note_cancel;
    
        $url = "https://api.whatsapp.com/send?phone=62$wa_numb&text=$text_wa";
        return Redirect::to($url);
        }
        
        //return redirect()->route('pesanan', [$vendor])->with('toast_success','Pesanan berhasil dibatalkan');
    }

}