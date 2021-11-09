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
        $datefrom = date('2021-06-01');
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        $paket = \App\Paket::where('client_id',\Auth::user()->client_id)->first();
        if($status){
            $orders = \App\Order::with('products')
                    ->whereNotNull('customer_id')
                    ->where('user_id','=',"$user_id")
                    //->where('client_id',\Auth::user()->client_id)
                    ->where('created_at','>=',$datefrom)
                    ->where('status',strtoupper($status))
                    ->orderBy('created_at', 'DESC')->get();//paginate(10);
        }else{
            $orders = \App\Order::with('products')
                    ->whereNotNull('customer_id')
                    ->where('user_id','=',"$user_id")
                    ->where('created_at','>=',$datefrom)
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
        $client_id =\Auth::user()->client_id;
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

$message = \App\Message::where('client_id',$client_id)->first();

$txt_descwa='*PEMBATALAN PESANAN*,

*'.$message->s_tittle.'*
Nama           : '.$user->name.',
Email            : '.$user->email.',
No. Hp         : '.$user->phone.',
Sales Area    : '.$user->sales_area.',

*'.$message->c_tittle.'*
Nama Toko  : '.$customer->store_name.',
Alamat         : '.$customer->address.',
Nama           : '.$customer->name.',
No. WA        : '.$customer->phone.',
No. Owner   : '.$customer->phone_owner.',
No. Toko      : '.$customer->phone_store.',
Email            : '.$customer->email.',
';

                //$href=urlencode($txt_wa);
                

                //detil non paket
                $pesan = DB::table('order_product')
                        ->join('orders','order_product.order_id','=','orders.id')
                        ->join('products','order_product.product_id','=','products.id')
                        ->where('orders.id','=',"$order_wa->id")
                        ->where('group_id','=',NULL)
                        ->where('paket_id','=',NULL)
                        ->get();
                
$ttle_nonpkt='*'.$message->o_tittle.'*
';              
                $ttle_mail_nonpkt = '';
                if(count($pesan) > 0){    
                    $no_urt=0;
                    foreach($pesan as $key=>$tele){
                        $no_urt++;
                        $ttle_nonpkt.= $no_urt.'. '.$tele->Product_name.' = (Qty :'.$tele->quantity.')
';
                        $ttle_mail_nonpkt .='<tr><td height="1" colspan="3">'. $no_urt.'. '.$tele->Product_name.' = (Qty :'.$tele->quantity.')</td></tr>';
                    }
                }
                
                $groupby_paket = DB::table('order_product')
                                ->where('order_id',$order_wa->id)
                                ->whereNotNull('paket_id')
                                ->whereNotNull('group_id')
                                ->whereNull('bonus_cat')
                                ->distinct()
                                ->get(['paket_id','group_id']);
                $krj_paket=count($groupby_paket);
                if($krj_paket > 0){
$ttle_pesan_pkt='';
$ttl_email_pkt='';
$ttle_bns='*Bonus*
';
$count_nt_paket = $pesan->count();
$no=$count_nt_paket;
                    foreach($groupby_paket as $key=>$dtl_pkt){
                        $no++;
                        $paket_name =\App\Paket::where('id',$dtl_pkt->paket_id)
                                    ->first();
                        $group_name =\App\Group::where('id',$dtl_pkt->group_id)
                                    ->first();
                        $ttle_pesan_pkt.= $no.'. '.$paket_name->display_name.' - '.$group_name->display_name.' :
';
                        
                        $ttl_email_pkt .='<tr><td height="1" colspan="3">'. $no.'. '.$paket_name->display_name.' - '.$group_name->display_name.' :</td></tr>';
                       
                        $data_paket = DB::table('order_product')
                                    ->join('products','order_product.product_id','=','products.id')
                                    ->where('order_id','=',$order_wa->id)
                                    ->where('group_id','=',$dtl_pkt->group_id)
                                    ->where('paket_id','=',$dtl_pkt->paket_id)
                                    ->whereNull('bonus_cat')
                                    ->get();

                        $no_pkt = 0;
                        
                        foreach($data_paket as $key=>$dp){
                            $no_pkt++;
                            $ttle_pesan_pkt.=strtolower($this->number_to_alphabet($no_pkt)).'. '.$dp->Product_name.' = ( Qty :'.$dp->quantity.')
';

                            $ttl_email_pkt .='<tr><td height="1" colspan="3">'. strtolower($this->number_to_alphabet($no_pkt)).'. '.$dp->Product_name.' = ( Qty :'.$dp->quantity.')</td></tr>';
                        }

                        $data_bonus = DB::table('order_product')
                                    ->join('orders','order_product.order_id','=','orders.id')
                                    ->join('products','order_product.product_id','=','products.id')
                                    ->where('orders.id','=',$order_wa->id)
                                    ->where('group_id','=',$dtl_pkt->group_id)
                                    ->where('paket_id','=',$dtl_pkt->paket_id)
                                    ->whereNotNull('bonus_cat')
                                    ->get();

                        $no_bns = $data_paket->count();
                        
                        foreach($data_bonus as $key => $db){
                            $no_bns++;
                            $ttle_pesan_pkt.= strtolower($this->number_to_alphabet($no_bns)).'. '.$db->Product_name.' = (Qty :'.$db->quantity.'~ Bonus)
';
                            $ttl_email_pkt .='<tr><td height="1" colspan="3">'. strtolower($this->number_to_alphabet($no_bns)).'. '.$db->Product_name.' = (Qty :'.$db->quantity.'~ Bonus)</td></tr>';
                        }
                    }
                }else{
                    $ttl_email_pkt=''; 
                }
                
                
                $info_harga = 'Pembayaran : '.$order_wa->payment_method;
                
                if($request->get('notes') != ""){
                    $notes_wa=urlencode($request->get('notes'));
                }
                else{
                    $notes_wa = '-';
                } 

                if(($krj_paket > 0) && (count($pesan) > 0)){
                    $list_text = urlencode($txt_descwa).'%0A'.urlencode($ttle_nonpkt).'%0A'.urlencode($ttle_pesan_pkt);
                }
                elseif(($krj_paket > 0) && (count($pesan) <= 0)){
                    $list_text = urlencode($txt_descwa).'%0A'.urlencode($ttle_nonpkt).urlencode($ttle_pesan_pkt);
                }
                else{
                    $list_text = urlencode($txt_descwa).'%0A'.urlencode($ttle_nonpkt);
                }

        $note_sales = 'Notes                   : '.$notes_wa;
        $note_cancel = 'Alasan Pembatalan Order : '.$text_cancel;
        $text_wa=$list_text.'%0A'.$info_harga.'%0A'.$note_sales.'%0A'.$note_cancel;

        //=============send mail =================//
        $mail_cncl= '<table width="836" border="0">
                    <tbody>
                        <tr>
                            <td height="53" colspan="3"><h3><strong>PEMBATALAN PESANAN #'.$order_wa->invoice_number.'</strong></h3></td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong>'.$message->s_tittle.'</strong></td>
                        </tr>
                        <tr>
                            <td width="230">Nama</td>
                            <td width="4">:</td>
                            <td width="680">'.$user->name.'</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td width="4">:</td>
                            <td width="680">'.$user->email.'</td>
                        </tr>
                        <tr>
                            <td>No. Hp</td>
                            <td width="4">:</td>
                            <td width="680">'.$user->phone.'</td>
                        </tr>
                        <tr>
                            <td>Sales Area</td>
                            <td width="4">:</td>
                            <td width="680">'.$user->sales_area.'</td>
                        </tr>
                        <tr>
                            <td height="22">&nbsp;</td>
                            <td width="4">&nbsp;</td>
                            <td width="680">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="22"><strong>'.$message->c_tittle.'</strong></td>
                            <td width="4">&nbsp;</td>
                            <td width="680">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="22">Nama Toko</td>
                            <td width="4">:</td>
                            <td width="680">'.$customer->store_name.'</td>
                        </tr>
                        <tr>
                            <td height="22">Alamat</td>
                            <td width="4">:</td>
                            <td width="680">'.$customer->address.'</td>
                        </tr>
                        <tr>
                            <td height="22">Nama</td>
                            <td width="4">:</td>
                            <td width="680">'.$customer->name.'</td>
                        </tr>
                        <tr>
                            <td height="22">No. Wa</td>
                            <td width="4">:</td>
                            <td width="680">'.$customer->phone.'</td>
                        </tr>
                        <tr>
                            <td height="22">No. Owner</td>
                            <td width="4">:</td>
                            <td width="680">'.$customer->phone_owner.'</td>
                        </tr>
                        <tr>
                            <td height="22">No. Toko</td>
                            <td width="4">:</td>
                            <td width="680">'.$customer->phone_store.'</td>
                        </tr>
                        <tr>
                            <td height="22">Email</td>
                            <td width="4">:</td>
                            <td width="680">'.$customer->email.'</td>
                        </tr>
                        <tr>
                            <td height="10">&nbsp;</td>
                            <td width="4">&nbsp;</td>
                            <td width="680">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="4"><strong>'.$message->o_tittle.'</strong></td>
                            <td width="4">&nbsp;</td>
                            <td width="680">&nbsp;</td>
                        </tr>'.$ttle_mail_nonpkt. $ttl_email_pkt.'
                        
                        <tr>
                            <td height="8" colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="1">Pembayaran</td>
                            <td height="1">:</td>
                            <td height="1">'.$order_wa->payment_method.'</td>
                        </tr>
                        <tr>
                            <td height="1">Notes</td>
                            <td height="1">:</td>
                            <td height="1">'.$notes_wa.'</td>
                        </tr>
                        <tr>
                            <td height="1">Alasan Pembatalan Order</td>
                            <td height="1">:</td>
                            <td height="1">'.$text_cancel.'</td>
                        </tr>
                    </tbody>
                </table>';
            $spv = \App\Spv_sales::where('sls_id',$user_id)
                ->where('status','ACTIVE')->first();
            if($spv){
                $email = \App\User::findOrFail($spv->spv_id);
                $email_spv = $email->email;
            }else{
                $email_spv = 'admin@sudahonline.com';
            }

        \Mail::send([], [], function ($message) use ( $mail_cncl,$email_spv) {
            $message->to($email_spv)
            ->subject('Cancel Order')
            ->setBody($mail_cncl, 'text/html');
        }); 
    
        $url = "https://api.whatsapp.com/send?phone=62$wa_numb&text=$text_wa";
        return Redirect::to($url);
        }
        
        //return redirect()->route('pesanan', [$vendor])->with('toast_success','Pesanan berhasil dibatalkan');
    }

    public function number_to_alphabet($number) {
        $number = intval($number);
        if ($number <= 0) {
            return '';
        }
        $alphabet = '';
        while($number != 0) {
            $p = ($number - 1) % 26;
            $number = intval(($number - $p) / 26);
            $alphabet = chr(65 + $p) . $alphabet;
        }
        return $alphabet;
    }

}