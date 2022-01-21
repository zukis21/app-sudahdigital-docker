<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\product;
use App\order_product;
use App\Order;
use App\User;
use App\Customer;
use App\City;
use Telegram\Bot\Laravel\Facades\Telegram;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerKeranjangController extends Controller
{
    public function simpan(Request $request){ 
        /*$ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $id = $ses_id.$clientIP;*/
        $id_user = \Auth::user()->id;
        $client_id =  \Auth::user()->client_id;
        //$id = $request->header('User-Agent'); 
        $id_product = $request->get('Product_id');
        $quantity=$request->get('quantity');
        $price=$request->get('price');
        $stock_status= \DB::table('product_stock_status')
                            ->where('client_id','=',$client_id)
                            ->first();
        $cek_promo = product::findOrFail($id_product);
        $cek_order = Order::where('user_id','=',"$id_user")
        ->where('status','=','SUBMIT')->whereNull('customer_id')->first();
        //dd($cek_order->id);
        if($cek_order !== null){
            $order_product = order_product::where('order_id','=',$cek_order->id)
            ->where('product_id','=',$id_product)
            ->whereNull('paket_id')
            ->first();
            
            if($order_product!== null){
                $_this = new self;
                
                $qtyOrder = $order_product->quantity + $quantity;
                $readyStock = $cek_promo->stock - ($_this->stockInfo( $id_product)-$_this->TotalQtyFinish($id_product));
                $prevstock = $readyStock + $order_product->quantity;
                if($prevstock <= 0){
                    $preOrder = $qtyOrder;
                    $avail = 0;
                }else{
                    $avail = $prevstock;
                    $preOrder = $qtyOrder - $prevstock;
                }
                
                
                /*$left = $readyStock - $qtyOrder;
                if($left < 0){
                    $preOrder = abs($left);
                    $avail = $qtyOrder + $left;
                }else{
                    $preOrder = 0;
                    $avail = $qtyOrder;
                }*/
                

                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->quantity += $quantity;
                
                if($stock_status->stock_status == 'ON'){
                    $order_product->available = $avail;
                    $order_product->preorder = $preOrder;
                }else{
                    $order_product->available = 0;
                    $order_product->preorder = 0;
                }
                
                $order_product->save();
                $cek_order->total_price += $price * $quantity;
                $cek_order->save();
                }else{
                        
                        $_this = new self;
                        
                        $qtyOrder = $quantity;
                        $readyStock = $cek_promo->stock - ($_this->stockInfo( $id_product)-$_this->TotalQtyFinish($id_product));
                        if($readyStock < 0){
                            $readyStock = 0 ;
                        }else{
                            $readyStock = $readyStock;
                        }
                        $left = $readyStock - $qtyOrder;
                        if($left < 0){
                            $preOrder = abs($left);
                            $avail = $qtyOrder + $left;
                        }else{
                            $preOrder = 0;
                            $avail = $qtyOrder;
                        }

                        $new_order_product = new order_product;
                        $new_order_product->order_id =  $cek_order->id;
                        $new_order_product->product_id = $id_product;
                        $new_order_product->price_item = $cek_promo->price;
                        $new_order_product->price_item_promo = $cek_promo->price_promo;
                        $new_order_product->discount_item = $cek_promo->discount;
                        $new_order_product->quantity = $quantity;
                        if($stock_status->stock_status == 'ON'){
                            $new_order_product->available = $avail;
                            $new_order_product->preorder = $preOrder;
                        }else{
                            $new_order_product->available = 0;
                            $new_order_product->preorder = 0;
                        }
                        $new_order_product->save();
                        $cek_order->total_price += $price * $quantity;
                        $cek_order->save();
                }
        }
        else{

            $order = new \App\Order;
            $order->user_id = $id_user;
            $order->client_id = $client_id;
            //$order->quantity = $quantity;
            $order->invoice_number = date('YmdHis');
            $order->total_price = $price * $quantity;
            $order->status = 'SUBMIT';
            $order->save();
            if($order->save()){
                $_this = new self;
                $qtyOrder = $quantity;
                $readyStock = $cek_promo->stock - ($_this->stockInfo( $id_product)-$_this->TotalQtyFinish($id_product));
                if($readyStock < 0){
                    $readyStock = 0 ;
                }else{
                    $readyStock = $readyStock;
                }
                $left = $readyStock - $qtyOrder;
                if($left < 0){
                    $preOrder = abs($left);
                    $avail = $qtyOrder + $left;
                }else{
                    $preOrder = 0;
                    $avail = $qtyOrder;
                }

                $order_product = new \App\order_product;
                $order_product->order_id = $order->id;
                $order_product->product_id = $request->get('Product_id');
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->quantity = $request->get('quantity');
                if($stock_status->stock_status == 'ON'){
                    $order_product->available = $avail;
                    $order_product->preorder = $preOrder;
                }else{
                    $order_product->available = 0;
                    $order_product->preorder = 0;
                }
                $order_product->save();
            }

        }
        //return response()->json(['return' => 'some data']);    
        //$order->products()->attach($request->get('Product_id'));
        
        //return redirect()->back()->with('status','Product berhasil dimasukan kekeranjang');
    }

    /*public function min_order(Request $request){ 
        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $id = $ses_id.$clientIP; 
        //$id = $request->header('User-Agent'); 
        $id_product = $request->get('Product_id');
        $quantity=$request->get('quantity');
        $price=$request->get('price');
        $cek_promo = product::findOrFail($id_product);
        $cek_order = Order::where('session_id','=',"$id")
        ->where('status','=','SUBMIT')->whereNull('username')->first();
        if($cek_order !== null){
            $order_product = order_product::where('order_id','=',$cek_order->id)
            ->where('product_id','=',$id_product)->first();
            if(($order_product!== null) AND ($order_product->quantity > 1)){
                $order_product->quantity -= $quantity;
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->save();
                $cek_order->total_price -= $price * $quantity;
                $cek_order->save();
                return redirect()->back()->with('status','Product berhasil dikurang dari keranjang');
                }else if(($order_product !== null) and ($order_product->quantity <= 1)){
                        $delete = DB::table('order_product')->where('id', $order_product->id)->delete();
                        if($delete){
                            $cek_order_product = order_product::where('order_id','=',$cek_order->id)->count();
                            if($cek_order_product < 1){
                                $delete_order = DB::table('orders')->where('id', $cek_order->id)->delete();
                            }
                            else{
                                $cek_order->total_price -= $price * $quantity;
                                $cek_order->save();
                            }
                            return redirect()->back()->with('status','Product berhasil dihapus dari keranjang');
                        }
                        
                    }
        }
        return redirect()->back();
       
    }*/

    public function tambah(Request $request){
        $client_id =  \Auth::user()->client_id;  
        $id = $request->get('id_detil');
        $order_id = $request->get('order_id');
        $order_product = order_product::findOrFail($id);
        $cek_promo = product::findOrFail($order_product->product_id);
        $stock_status= \DB::table('product_stock_status')
                            ->where('client_id','=',$client_id)
                            ->first();
        $_this = new self;
        
        $qtyOrder = $order_product->quantity + 1;
        $readyStock = $cek_promo->stock - ($_this->stockInfo($order_product->product_id)-$_this->TotalQtyFinish( $order_product->product_id));
        $prevstock = $readyStock + $order_product->quantity;
        if($prevstock <= 0){
            $preOrder = $qtyOrder;
            $avail = 0;
        }else{
            $avail = $prevstock;
            $preOrder = $qtyOrder - $prevstock;
        }

        $order_product->quantity += 1;
        if($stock_status->stock_status == 'ON'){
            $order_product->available = $avail;
            $order_product->preorder = $preOrder;
        }else{
            $order_product->available = 0;
            $order_product->preorder = 0;
        }
        $order_product->price_item = $cek_promo->price;
        $order_product->price_item_promo = $cek_promo->price_promo;
        $order_product->discount_item = $cek_promo->discount;
        $order_product->save();
        if($order_product->save()){
                $order = Order::findOrFail($order_id);
                $order->total_price += $request->get('price');
                $order->save();
        }
           
            
        //$order->products()->attach($request->get('Product_id'));
        
       // return redirect()->back()->with('status','Berhasil menambah produk');
    }

    public function kurang(Request $request){
        $client_id =  \Auth::user()->client_id;
        $id = $request->get('id_detil');
        $order_id = $request->get('order_id');
        $order_product = order_product::findOrFail($id);
        $stock_status= \DB::table('product_stock_status')
                            ->where('client_id','=',$client_id)
                            ->first();
        if($order_product->quantity < 2){
            $delete = DB::table('order_product')->where('id', $id)->delete();   
            if($delete)
            {   
                $cek_order_product = order_product::where('order_id','=',$order_id)->first();
                if($cek_order_product == null){
                    DB::table('orders')->where('id', $order_id)->delete();
                }
                else{
                        $order = Order::findOrFail($order_id);
                        $order->total_price -= $request->get('price');
                        $order->save();
                    }
                //return redirect()->back()->with('status','Berhasil menghapus produk dari keranjang');
            }
        }
        else{

            $order_product = order_product::findOrFail($id);
            $cek_promo = product::findOrFail($order_product->product_id);

            $_this = new self;
            $qtyOrder = $order_product->quantity - 1;
            $readyStock = $cek_promo->stock -  ($_this->stockInfo($order_product->product_id)-$_this->TotalQtyFinish( $order_product->product_id));
            $prevstock = $readyStock + $order_product->quantity;
            if($prevstock <= 0){
                $preOrder = $qtyOrder;
                $avail = 0;
            }else{
                $avail = $prevstock;
                $preOrder = $qtyOrder - $prevstock;
            }

            $order_product->price_item = $cek_promo->price;
            $order_product->price_item_promo = $cek_promo->price_promo;
            $order_product->discount_item = $cek_promo->discount;
            if($stock_status->stock_status == 'ON'){
                $order_product->available = $avail;
                $order_product->preorder = $preOrder;
            }else{
                $order_product->available = 0;
                $order_product->preorder = 0;
            }
            $order_product->quantity -= 1;
            $order_product->save();
            if($order_product->save()){
                $order = Order::findOrFail($order_id);
                $order->total_price -= $request->get('price');
                $order->save();
                //return redirect()->back()->with('status','Berhasil mengurangi produk');
            }
        } 
        
    }

    public function delete(Request $request){
        
        $id = $request->get('id');
        $product_id = $request->get('product_id');
        $order_id = $request->get('order_id');
        $quantity = $request->get('quantity');
        $price = $request->get('price');
        $order_product = order_product::where('order_id','=',$order_id)->count();
                        if($order_product <= 1){
                        $delete = DB::table('order_product')->where('id', $id)->delete();   
                        if($delete){
                            //DB::table('orders')->where('id', $order_id)->delete();
                            $orders = Order::findOrFail($order_id);
                            $orders->forceDelete();
                            /*$orders->total_price = 0;
                            $orders->save();*/
                            }
                        }
                        else{
                             $delete2 = DB::table('order_product')->where('id', $id)->delete();
                             if($delete2){
                                $orders = Order::findOrFail($order_id);
                                $total_price = $price * $quantity;
                                $orders->total_price -= $total_price;
                                $orders->save();
                             }
                        }
                        return redirect()->back()->with('status','Product berhasil dihapus dari keranjang');
    }

    public function pesan(Request $request, $vendor){
        $date = date('Y-m-d H:i:s');
        $user_id = \Auth::user()->id;
        $client_id =\Auth::user()->client_id;
        $client_name = \App\B2b_client::findOrfail($client_id);
        $wa_numb=$client_name->phone_whatsapp;
        $id = $request->get('id');
        /*$cek_order = DB::select("SELECT order_product.order_id, order_product.product_id,
                    sum(order_product.quantity), products.stock, products.Product_name FROM products,order_product 
                    WHERE order_product.product_id = products.id AND order_product.order_id = '$id' 
                    GROUP BY order_product.product_id HAVING SUM(order_product.quantity) > products.stock");
        $count_cek = count($cek_order);
        $stock_status= DB::table('product_stock_status')
                        ->where('client_id',$client_id)->first();
        /*if(($count_cek > 0) && ($stock_status->stock_status == 'ON')){
            return view('errors/error_wa');
        }else{
            if($stock_status->stock_status == 'ON'){
                $cek_quantity = Order::with('products')->where('id',$id)->get();
                foreach($cek_quantity as $q){
                    foreach($q->products as $p){
                        $up_product = product::findOrfail($p->pivot->product_id);
                        $up_product->stock -= $p->pivot->quantity;
                        $up_product->save();
                        }
                    }
            }*/

            $user = User::findOrfail($user_id);
            $ses_order = $request->session()->get('ses_order');
            if($ses_order->customer_id == null){
                $name = $ses_order->name;
                $store_name = $ses_order->store_name;
                $addr_for_ses = $ses_order->address;
                $new_cust = new Customer;
                $new_cust->name = $name;
                $new_cust->phone = $ses_order->phone;
                $new_cust->phone_owner = $ses_order->phone_owner;
                $new_cust->phone_store = $ses_order->phone_store;
                $new_cust->store_name = $store_name;
                $new_cust->address = $ses_order->address;
                $new_cust->user_id = $user_id;
                $new_cust->client_id = $client_id;
                $new_cust->status = 'NEW';
                $new_cust->save();
                if ( $new_cust->save()){
                    $sel_cust = \App\Customer::where('client_id','=',$client_id)
                                ->whereRaw('BINARY name = ?',[$name])
                                ->where('phone','=',$ses_order->phone)
                                ->where('phone_owner','=',$ses_order->phone_owner)
                                ->where('phone_store','=',$ses_order->phone_store)
                                ->whereRaw('BINARY store_name = ?',[$store_name])
                                ->whereRaw('BINARY address = ?',[$addr_for_ses])
                                ->where('user_id','=',$user_id)
                                ->first();
                    //dd($sel_cust->id);
                    $customer = Customer::findOrfail($sel_cust->id);
                }
            }else{
                $customer = Customer::findOrfail($ses_order->customer_id);
            }
            
            $payment_method=$request->get('check_tunai_value');
            if($request->get('notes') != ""){
                $notes=$request->get('notes');
            }else{
                $notes = NULL;
            }

            //$city = City::findOrfail($user->city_id);
            $orders = Order::findOrfail($id);
            $orders->user_loc = $ses_order->user_loc;
            $orders->customer_id = $customer->id;
            $orders->payment_method = $payment_method;
            $orders->notes = $notes;
            $orders->created_at = $date;
            $orders->updated_at = $date;
            if($request->get('voucher_code_hide_modal') != ""){
                $keyword = $request->get('voucher_code_hide_modal');
                $vouchers_cek = \App\Voucher::where('code','=',"$keyword")->first();
                $orders->id_voucher = $vouchers_cek->id;
                $orders->total_price = $request->get('total_pesanan');
            }
            else{
                $orders->id_voucher = NULL;
            }
            $orders->save();

            $total_pesanan = $request->get('total_pesanan');
            if($request->get('voucher_code_hide_modal')!= ""){
                $sum_novoucher = $request->get('total_novoucher');
                $keyword = $request->get('voucher_code_hide_modal');
                $vouchers_cek = \App\Voucher::where('code','=',"$keyword")->first();
                $code_name = $vouchers_cek->name;
                $type = $vouchers_cek->type;
                $disc_amount = $vouchers_cek->discount_amount;
                $vouchers = \App\Voucher::findOrFail($vouchers_cek->id);
                $vouchers->uses +=1;
                $vouchers->save();
            }
            //$total_ongkir  = 15000;
            //$total_bayar  = $total_pesanan;
$message = \App\Message::where('client_id',$client_id)->first();

$txt_descwa='*'.$message->m_tittle.'*,

Tanggal        : '.$this->tgl_indo(date('Y-m-d')).'

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
                if($orders->save()){
                
                $orders_ach = Order::findOrfail($id);
                $month = date('m',strtotime($orders_ach->created_at));
                $year = date('Y',strtotime($orders_ach->created_at));
                $target_ach = \App\Sales_Targets::where('user_id',$user_id)
                            ->where('client_id',$client_id)
                            ->whereMonth('period', $month)
                            ->whereYear('period', $year)->first();
                //dd($month);
                if($target_ach){
                    
                    $target_ach->target_achievement +=  $orders_ach->total_price;
                    $target_ach->save();
                }

                //detil non paket
                $pesan = DB::table('order_product')
                        ->join('orders','order_product.order_id','=','orders.id')
                        ->join('products','order_product.product_id','=','products.id')
                        ->where('orders.id','=',"$id")
                        ->where('group_id','=',NULL)
                        ->where('paket_id','=',NULL)
                        ->get();

                //if have discount volume
                $cekCombineDisc = $this->volumeDiscCombineCek($orders->TotalQtyDiscVolume);
                if(count($orders->products_nonpaket) > 0){
                    foreach($orders->products_nonpaket as $p){
                        $cekItemDisc = $this->volumeDiscPerItemCek($p->id,$p->pivot->quantity);
                        if($cekItemDisc > 0){
                            $pivotOrder = \App\order_product::findorFail($p->pivot->id);
                            $pivotOrder->vol_disc_price = $cekItemDisc;
                            $pivotOrder->save();

                        }elseif($cekCombineDisc){
                            $cekPriceDisc = $this->volumePriceDisc($p->id,$cekCombineDisc->id);
                            if($cekPriceDisc){
                                $pivotOrder = \App\order_product::findorFail($p->pivot->id);
                                $pivotOrder->vol_disc_price = $cekPriceDisc->discount_price ;
                                $pivotOrder->save();
                            }
                        }
                    }
                }
                
$ttle_nonpkt='*'.$message->o_tittle.'*
';              
                if(count($pesan) > 0){    
                    $no_urt=0;
                    foreach($pesan as $key=>$tele){
                        $no_urt++;
                        $ttle_nonpkt.= $no_urt.'. '.$tele->Product_name.' = (Qty :'.$tele->quantity.')
';
                    }
                }
                
                $groupby_paket = DB::table('order_product')
                                ->where('order_id',$id)
                                ->whereNotNull('paket_id')
                                ->whereNotNull('group_id')
                                ->whereNull('bonus_cat')
                                ->distinct()
                                ->get(['paket_id','group_id']);
                $krj_paket=count($groupby_paket);
                if($krj_paket > 0){
$ttle_pesan_pkt='';
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
                        $data_paket = DB::table('order_product')
                                    ->join('products','order_product.product_id','=','products.id')
                                    ->where('order_id','=',"$id")
                                    ->where('group_id','=',$dtl_pkt->group_id)
                                    ->where('paket_id','=',$dtl_pkt->paket_id)
                                    ->whereNull('bonus_cat')
                                    ->get();

                        $no_pkt = 0;
                        foreach($data_paket as $key=>$dp){
                            $no_pkt++;
                            $ttle_pesan_pkt.=strtolower($this->number_to_alphabet($no_pkt)).'. '.$dp->Product_name.' = ( Qty :'.$dp->quantity.')
';
                        }

                        $data_bonus = DB::table('order_product')
                                    ->join('orders','order_product.order_id','=','orders.id')
                                    ->join('products','order_product.product_id','=','products.id')
                                    ->where('orders.id','=',"$id")
                                    ->where('group_id','=',$dtl_pkt->group_id)
                                    ->where('paket_id','=',$dtl_pkt->paket_id)
                                    ->whereNotNull('bonus_cat')
                                    ->get();

                        $no_bns = $data_paket->count();
                        foreach($data_bonus as $key => $db){
                            $no_bns++;
                            $ttle_pesan_pkt.= strtolower($this->number_to_alphabet($no_bns)).'. '.$db->Product_name.' = (Qty :'.$db->quantity.'~ Bonus)
';
                        }
                    }
                }
                


                if($request->get('voucher_code_hide_modal')!= ""){
                    if ($type == 1){
                        //$info_harga = '*Total Pesanan* : Rp.'.number_format(($sum_novoucher), 0, ',', '.').'%0APembayaran : '.$payment_method;
                        $info_harga = 'Pembayaran : '.$payment_method;
                    }else{
                        //$info_harga = '*Total Pesanan* : Rp.'.number_format(($sum_novoucher), 0, ',', '.').'%0APembayaran : '.$payment_method;
                        $info_harga = 'Pembayaran : '.$payment_method;
                    }
                }
                else{
                    //$info_harga = '*Total Pesanan* : Rp.'.number_format(($total_pesanan), 0, ',', '.').'%0APembayaran : '.$payment_method;
                    $info_harga = 'Pembayaran : '.$payment_method;
                }
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

                $note_sales = 'Notes            : '.$notes_wa;
                $text_wa=$list_text.'%0A'.$info_harga.'%0A'.$note_sales;
            
                $url = "https://api.whatsapp.com/send?phone=62$wa_numb&text=$text_wa";
                return Redirect::to($url);
                //Alert::success('', 'Pesanan berhasil dikirim');
                //return redirect()->route('home_customer');    
            }
        //}
        
        
    }

    public function voucher_code(Request $request){
        $keyword = $request->get('code');
        $vouchers = \App\Voucher::where('code','LIKE BINARY',"%$keyword%")->count();
        if($vouchers > 0 ){
            $vouchers_cek = \App\Voucher::where('code','LIKE BINARY',"%$keyword%")->first();
            if($vouchers_cek->uses < $vouchers_cek->max_uses){
                echo "taken";
            }else{
                echo "full_uses";
            }
            
          }else{
            echo "not_taken";
          }
    }

    /*public function apply_code(Request $request){
        $keyword = $request->get('code');
        $vouchers = \App\Voucher::where('code','=',"$keyword")->first();
        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $session_id = $ses_id.$clientIP;
        $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('session_id','=',"$session_id")
                    ->whereNull('orders.username')
                    ->count();
        if ($total_item < 1){
            echo '<div id="accordion">
                    <div class="card fixed-bottom" style="">
                        <div id="card-cart" class="card-header" >
                            <table width="100%" style="margin-bottom: 40px;">
                                <tbody>
                                    <tr>
                                        <td width="5%" valign="middle">
                                            <div id="ex4">
                                        
                                                <span class="p1 fa-stack fa-2x has-badge" data-count="0">
                                            
                                                    <!--<i class="p2 fa fa-circle fa-stack-2x"></i>-->
                                                    <i class="p3 fa fa-shopping-cart " data-count="4b" style=""></i>
                                                </span>
                                            </div> 
                                        </td>
                                        <td width="25%" align="left" valign="middle">
                                            <h5 id="total_kr_">Rp.0</h5>
                                        </td>
                                        <td width="5%" valign="middle" >
                                        <a id="cv" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                                                <i class="fas fa-chevron-up" style=""></i>
                                            </a>
                                        </td>
                                        <td width="33%" align="right" valign="middle">
                                        
                                        <h5>(0 Item)</h5>
                                        
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div  class="collapse" data-parent="#accordion" style="" >
                            <div class="card-body" id="card-detail">
                                <div class="col-md-12">
                                <input type="hidden" class="form-control" id="voucher_code_hide" value="">
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        else{
        $keranjang = \App\Order::with('products')
                    ->where('status','=','SUBMIT')
                    ->where('session_id','=',"$session_id")
                    ->whereNull('username')->get();
        $item = DB::table('orders')
                    ->where('session_id','=',"$session_id")
                    ->where('orders.status','=','SUBMIT')
                    ->whereNull('orders.username')
                    ->first();
        $item_name = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('session_id','=',"$session_id")
                    ->whereNotNull('orders.username')
                    ->first();
        $no_disc = DB::table('products')
                    ->join('order_product','products.id','=','order_product.product_id')
                    ->where('order_product.order_id','=',"$item->id")
                    ->where('products.discount','=','0')//->get();
                    ->sum(DB::raw('products.price * order_product.quantity'));
                    //->sum('products.price');
                    //->first();
        $sum_novoucher = $item->total_price;
        //$sum_nodisc = $no_disc->sum('products.price');
        if( $vouchers->type == 1){
           $potongan = ($no_disc * $vouchers->discount_amount) / 100;
            $item_price = $item->total_price - $potongan;
        }
        else if ($vouchers->type == 2)
        {
            $item_price = $item->total_price - $vouchers->discount_amount;
        }
        else
        {
            $item_price = $item->total_price;
        }
        echo 
        '<div id="accordion" class="fixed-bottom">
            <div class="card" style="border-radius:16px;">
                <div id="card-cart" class="card-header" >
                    <table width="100%" style="margin-bottom: 40px;">
                        <tbody>
                            <tr>
                                <td width="5%" valign="middle">
                                    <div id="ex4">
                                
                                        <span id="" class="p1 fa-stack fa-2x has-badge" data-count="'.$total_item.'">
                                    
                                            <!--<i class="p2 fa fa-circle fa-stack-2x"></i>-->
                                            <i class="p3 fa fa-shopping-cart " data-count="4b" style=""></i>
                                        </span>
                                    </div> 
                                </td>
                                <td width="25%" align="left" valign="middle">';
                                    
                                        echo'<h5 id="total_kr_">Rp.&nbsp;'.number_format(($item_price) , 0, ',', '.').'</h5>
                                        <input type="hidden" id="total_kr_val" value="'.$item_price.'">';
                                echo'    
                                </td>
                                <td width="5%" valign="middle" >
                                <a id="cv" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                                        <i class="fas fa-chevron-up" style=""></i>
                                    </a>
                                </td>
                                <td width="33%" align="right" valign="middle">
                                
                                <h5>('.$total_item.'&nbsp;Item)</h5>
                                
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="collapse-4" class="collapse" data-parent="#accordion" style="" >
                    <div class="card-body" id="card-detail">
                        <div class="col-md-12" style="padding-bottom:7rem;">
                            <table width="100%">
                                <tbody>';
                                    foreach($keranjang as $order){
                                        foreach($order->products as $detil){
                                        echo'<tr>
                                            <td width="25%" valign="middle">
                                                <img src="'.asset('storage/'.(($detil->image!='') ? $detil->image : 'no_image_availabl.png').'').'" 
                                                class="image-detail"  alt="...">   
                                            </td>
                                            <td width="60%" align="left" valign="top">
                                                <p class="name-detail">'.$detil->description.'</p>';
                                                if($detil->discount > 0){
                                                    $total=$detil->price_promo * $detil->pivot->quantity;
                                                }
                                                else{
                                                    $total=$detil->price * $detil->pivot->quantity;
                                                }
                                                echo'<h1 id="productPrice_kr'.$detil->id.'" style="color:#6a3137; !important; font-family: Open Sans;">Rp.&nbsp;'.number_format($total, 0, ',', '.').'</h1>
                                                <table width="10%">
                                                    <tbody>
                                                        <tr id="response-id'.$detil->id.'">
                                                            
                                                            <td width="10px" align="left" valign="middle">
                                                            <input type="hidden" id="order_id'.$detil->id.'" name="order_id" value="'.$order->id.'">';
                                                            if($detil->discount > 0)
                                                            {
                                                                echo'<input type="hidden" id="harga_kr'.$detil->id.'" name="price" value="'.$detil->price_promo.'">';
                                                            }
                                                            else{
                                                                echo'<input type="hidden" id="harga_kr'.$detil->id.'" name="price" value="'.$detil->price.'">';
                                                            }
                                                            echo'<input type="hidden" id="id_detil'.$detil->id.'" value="'.$detil->pivot->id.'">
                                                            <input type="hidden" id="jmlkr_'.$detil->id.'" name="quantity" value="'.$detil->pivot->quantity.'">    
                                                            <button class="button_minus" onclick="button_minus_kr('.$detil->id.')" style="background:none; border:none; color:#693234;outline:none;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                                                
                                                            </td>
                                                            <td width="10px" align="middle" valign="middle">
                                                                <p id="show_kr_'.$detil->id.'" class="d-inline" style="">'.$detil->pivot->quantity.'</p>
                                                            </td>
                                                            <td width="10px" align="right" valign="middle">
                                                                <button class="button_plus" onclick="button_plus_kr('.$detil->id.')" style="background:none; border:none; color:#693234;outline:none;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                            </td>
                                                        
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td width="15%" align="right" valign="top" style="padding-top: 5%;">
                                                <button class="btn btn-default" onclick="delete_kr('.$detil->id.')" style="">X</button>
                                                <input type="hidden"  id="order_id_delete'.$detil->id.'" name="order_id" value="'.$order->id.'">
                                                <input type="hidden"  id="quantity_delete'.$detil->id.'" name="quantity" value="'.$detil->pivot->quantity.'">';
                                                if($detil->discount > 0)
                                                    {
                                                    echo '<input type="hidden"  id="price_delete'.$detil->id.'" name="price" value="'.$detil->price_promo.'">';
                                                    }
                                                    else{
                                                        echo '<input type="hidden"  id="price_delete'.$detil->id.'" name="price" value="'.$detil->price.'">';
                                                    }
                                                echo'<input type="hidden"  id="product_id_delete'.$detil->id.'"name="product_id" value="'.$detil->id.'">
                                                <input type="hidden" id="id_delete'.$detil->id.'" name="id" value="'.$detil->pivot->id.'">
                                            </td>
                                        </tr>';
                                        
                                        }
                                    }
                                    echo '<tr>
                                        <td align="right" colspan="3">';
                                                
                                        echo'</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <div id="desc_code" style="display:block;">
                                <div class="jumbotron jumbotron-fluid ml-2 py-4 mb-0 px-3">
                                    <p class="lead">Anda mendapatkan potongan harga ';
                                    if($vouchers->type==1){
                                        echo $vouchers->discount_amount; 
                                        echo '%,';
                                    } 
                                    else{
                                        echo 'Rp.'.number_format(($vouchers->discount_amount) , 0, ',', '.').',';
                                    }
                                    echo'<br>'.$vouchers->description.'.</p>
                                </div>
                                <div class="mb-3 mt-1 ml-2">
                                    <a class="btn btn-default" onclick="reset_promo()">Reset Kode Promo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fixed-bottom">
                        <div class="p-3" style="background-color:#e9eff5;border-bottom-right-radius:18px;border-bottom-left-radius:18px;">
                        <input type="hidden" id="order_id_cek" name="id" value="';if($item !== null){echo $item->id;}else{echo '';} echo'"/>';
                            if($item!==null){
                                echo '<input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="'.$item_price.'">
                                <input type="hidden" name="total_pesanan" id="total_pesan_val_code" value="'.$item_price.'">
                                <input type="hidden" name="total_novoucher" id="total_novoucher_val_code" value="'.$sum_novoucher.'">';
                            }
                            else{
                                echo'<input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="0">';
                            }
                            if($total_item > 0){
                            echo'<div class="input-group mb-2 mt-2">
                                    <input type="text" class="form-control" id="voucher_code" 
                                    placeholder="Gunakan Kode Diskon" aria-describedby="basic-addon2" required style="background:#ffcc94;outline:none;">
                                    <div class="input-group-append" required>
                                        <button class="btn " type="submit" onclick="btn_code()" style="background:#6a3137;outline:none;color:white;">Terapkan</button>
                                    </div>
                                </div>';
                            echo '<input type="hidden" class="form-control" id="voucher_code_hide">';    
                            echo '<a type="button" id="beli_sekarang" class="btn btn-block button_add_to_pesan" onclick="show_modal()">Beli Sekarang</a>';
                            }
                        echo'</div>
                    </div>
                </div>
            </div>
        </div>';
        }
    }*/

    public function ajax_cart(Request $request)
    {   
        /*$ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $session_id = $ses_id.$clientIP;*/
        $id_user = \Auth::user()->id;
        $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('user_id','=',"$id_user")
                    ->whereNull('orders.customer_id')
                    ->distinct('order_product.product_id')
                    /*->whereNull('order_product.group_id')*/
                    ->count();
        //dd($id_user);
       /* $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('user_id','=',"$id_user")
                    ->whereNull('orders.customer_id')
                    ->count();*/
        if ($total_item < 1){
            echo '<div id="accordion" class="fixed-bottom" style="border-radius:0;z-index:1;">
                    <div class="card" style="border-radius:0;">
                        <a role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                        <div id="card-cart" class="card-header pt-1" style="border-radius:0;">
                            <div class="card-cart container">
                                <table class="table borderless">
                                    <tr>
                                        <td align="left" id="td_itm" width="40%">
                                            <h5 style="color:#000">'.$total_item.'&nbsp;Item</h5>
                                        </td>
                                        <td align="middle" id="td_crv" width="20%">
                                            <i class="fas fa-chevron-up" style=""></i>
                                        </td>
                                        <td align="right" id="td_krm-order" width="40%">
                                            <h5 class="pull-right" style="color: #000">Kirim Order&nbsp;&nbsp;<img src="'.asset('assets/image/right-arrow.png').'" width="20" class="my-auto" alt="right-arrow"></h5>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        </a>
                        <div  class="collapse" data-parent="#accordion" style="" >
                            <div class="card-body" id="card-detail">
                                <div class="col-md-12">
                                <input type="hidden" class="form-control" id="voucher_code_hide">
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        else
        {
            $keranjang = \App\Order::with('products_nonpaket')
                        ->where('status','=','SUBMIT')
                        ->where('user_id','=',"$id_user")
                        ->whereNull('customer_id')->get();
            $item = DB::table('orders')
                        ->where('user_id','=',"$id_user")
                        ->where('orders.status','=','SUBMIT')
                        ->whereNull('orders.customer_id')
                        ->first();
            $krj_paket = \App\order_product::where('order_id',$item->id)
                        ->whereNotnull('paket_id')
                        ->whereNotnull('order_id')
                        ->first();
            $item_name = DB::table('orders')
                        ->join('order_product','order_product.order_id','=','orders.id')
                        ->where('user_id','=',"$id_user")
                        ->whereNotNull('orders.customer_id')
                        ->first();
            $item_price = $item->total_price;
        echo 
        '<div id="accordion" class="fixed-bottom" style="border-radius:0;">
            <div class="card" style="border-radius:0;">
                <a role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                    <div id="card-cart" class="card-header pt-1" style="border-radius:0;">
                        <div class="card-cart container">
                            <table class="table borderless">
                                <tr>
                                    <td align="left" id="td_itm" width="40%">
                                        <h5 style="color:#000">'.$total_item.'&nbsp;Item</h5>
                                    </td>
                                    <td align="middle" id="td_crv" width="20%">
                                        <i class="fas fa-chevron-up" style=""></i>
                                    </td>
                                    <td align="right" id="td_krm-order" width="40%">
                                        <h5 class="pull-right" style="color: #000">Kirim Order&nbsp;&nbsp;<img src="'.asset('assets/image/right-arrow.png').'" width="20" class="my-auto" alt="right-arrow"></h5>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </a>
                <div id="collapse-4" class="collapse" data-parent="#accordion" style="" >
                    <div id="cont-collapse" class="container">
                        <div class="card-body" id="card-detail">
                            <div class="col-md-12" style="padding-bottom:10rem;">';
                            if($krj_paket !=null){
                            echo'<p id="p-title1" class="mb-2" style="font-weight:700;color: #153651;font-family: Montserrat;">Paket</p>
                                <table class="table-detail" width="100%">
                                    <tbody>';
                                            $groupby_paket = \DB::table('order_product')
                                                            ->where('order_id',$item->id)
                                                            ->whereNotNull('paket_id')
                                                            ->whereNotNull('group_id')
                                                            ->whereNull('bonus_cat')
                                                            ->distinct()
                                                            ->get(['paket_id','group_id']);
                                                
                                            foreach($groupby_paket as $dtl_pkt){
                                                    $paket_name =\App\Paket::where('id',$dtl_pkt->paket_id)
                                                                ->first();
                                                    $group_name =\App\Group::where('id',$dtl_pkt->group_id)
                                                                ->first();           
                                                echo'<tr class="pb-0">
                                                    <td width="30%" class="img-detail-cart" valign="top" style="padding-top:3%;">
                                                        <img src="'.asset('storage/'.(($group_name->group_image!='') ? $group_name->group_image : 'no_image_availabl.png').'').'" 
                                                        class="image-detail"  alt="...">
                                                    </td>
                                                    <td width="60%" class="td-desc-detail" align="left" valign="top" style="padding-top:3%;">
                                                        <p style="color: #000">'.$paket_name->display_name.',</p>
                                                        <p style="color: #000">'.$group_name->display_name.'</p>';
                                                            if($item){
                                                            $pkt_total_krj = \App\order_product::where('order_id',$item->id)
                                                            ->where('group_id',$dtl_pkt->group_id)
                                                            ->where('paket_id',$dtl_pkt->paket_id)
                                                            ->whereNull('bonus_cat')
                                                            ->sum('quantity');
                                                            $pkt_pirce = \App\order_product::where('order_id',$item->id)
                                                            ->where('group_id',$dtl_pkt->group_id)
                                                            ->where('paket_id',$dtl_pkt->paket_id)
                                                            ->whereNull('bonus_cat')
                                                            ->sum(\DB::raw('price_item * quantity'));
                                                            }
                                                        
                                                    echo'<h2 style="font-weight:700;color: #153651;font-family: Montserrat;">Rp.&nbsp;'.number_format($pkt_pirce, 0, ',', '.').',-</h2>
                                                        
                                                        <p style="color: #000"><span>Qty</span><span class="d-inline ml-2" style="color: #153651;font-weight:900;">'.$pkt_total_krj.'</span></p>
                                                        <a onclick="open_detail_pkt('.$item->id.','.$dtl_pkt->paket_id.','.$dtl_pkt->group_id.')" style="cursor: pointer"><span class="badge badge-secondary">Detail Paket</span></a>

                                                    </td>
                                                    <td width="15%" align="right" valign="top" style="padding-top:3%;">
                                                    <button class="btn btn-default" onclick="delete_kr_pkt('.$item->id.','.$dtl_pkt->paket_id.','.$dtl_pkt->group_id.')" style="">X</button>
                                                        <input type="hidden"  id="order_id_delete_pkt" name="order_id" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="border-bottom: 1px solid #ddd;">
                                                        <div class="row">
                                                            <div class="col-3 pt-1">
                                                                <p class="" style="font-weight:700;color: #153651;font-family: Montserrat;">Bonus :</p>
                                                            </div>
                                                            <div class="col-9">';
                                                                $groupby_bns = \App\order_product::where('order_id',$item->id)
                                                                                    ->where('paket_id',$dtl_pkt->paket_id)
                                                                                    ->where('group_id',$dtl_pkt->group_id)
                                                                                    ->whereNotNull('bonus_cat')
                                                                                    ->get();
                                                                                    //dd($groupby_bns);
                                                                foreach($groupby_bns as $bns){
                                                                    $prd_bns =\App\product::findOrfail($bns->product_id);
                                                                    
                                                                    echo'<p class="d-none d-md-block d-md-none mt-2" style="color: #000;margin-left:-11rem;">*' .$prd_bns->Product_name.'&nbsp;<span style="color: #153651;">('.$bns->quantity.')</span></p>
                                                                    <p class="d-md-none mt-2 ml-n4" style="color: #000;font-size:3vw;">*'. $prd_bns->Product_name.'&nbsp;<span style="color: #153651;">('.$bns->quantity.')</span></p>';
                                                                    
                                                                }
                                                            echo '</div>
                                                        </div>
                                                    </td>
                                                </tr>';
                                            }
                                        
                                echo'</tbody>
                                </table>';
                            }
                            if(($krj_paket != null) && (count($keranjang) > 0 )){
                                echo '<p id="p-title2" class="mt-4 mb-2" style="font-weight:700;color: #153651;font-family: Montserrat;">Produk Non-Paket</p>';
                            }

                            echo'<table class="table-detail" width="100%">
                                    <tbody>';
                                        foreach($keranjang as $order){
                                            foreach($order->products_nonpaket as $detil){
                                            echo'<tr>
                                                <td width="30%" class="img-detail-cart" valign="middle" style="border-bottom: 1px solid #ddd;padding-top:3%;">
                                                    <img src="'.asset('storage/'.(($detil->image!='') ? $detil->image : 'no_image_availabl.png').'').'" 
                                                    class="image-detail"  alt="...">   
                                                </td>
                                                <td width="60%" class="td-desc-detail" align="left" valign="top" style="border-bottom: 1px solid #ddd;padding-top:3%;">
                                                    <p style="color: #000">'.$detil->Product_name.'</p>';
                                                    if($detil->discount > 0){
                                                        $total=$detil->price_promo * $detil->pivot->quantity;
                                                    }
                                                    else{
                                                        $total=$detil->price * $detil->pivot->quantity;
                                                    }
                                                    echo'<h2 id="productPrice_kr'.$detil->id.'" style="font-weight:700;color: #153651;font-family: Montserrat;">Rp.&nbsp;'.number_format($total, 0, ',', '.').',-</h2>
                                                    <table width="20%" class="tabel-quantity">
                                                        <tbody>
                                                            <tr>
                                                                <td width="3%" align="left" valign="middle" rowspan="2">
                                                                    <p style="color: #000">Qty</p>
                                                                    <input type="hidden" id="order_id'.$detil->id.'" name="order_id" value="'.$order->id.'">';
                                                                    if($detil->discount > 0)
                                                                    {
                                                                        echo'<input type="hidden" id="harga_kr'.$detil->id.'" name="price" value="'.$detil->price_promo.'">';
                                                                    }
                                                                    else{
                                                                        echo'<input type="hidden" id="harga_kr'.$detil->id.'" name="price" value="'.$detil->price.'">';
                                                                    }
                                                                    echo'<input type="hidden" id="id_detil'.$detil->id.'" value="'.$detil->pivot->id.'">
                                                                    <input type="hidden" id="jmlkr_'.$detil->id.'" name="quantity" value="'.$detil->pivot->quantity.'">    
                                                                </td>
                                                                <td width="5%" align="left" valign="middle" rowspan="2">
                                                                    <p id="show_kr_'.$detil->id.'" class="d-inline" style="">'.$detil->pivot->quantity.'</p>
                                                                </td>
                                                                <td width="1%" align="center" valign="middle" bgcolor="#1A4066" style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                                                    <button class="button_plus" onclick="button_plus_kr('.$detil->id.')" style="background:none; border:none; color:#ffffff;outline:none;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="1%" align="middle" valign="middle" bgcolor="#1A4066" style="border-bottom-left-radius:5px;border-bottom-right-radius:5px;">
                                                                    <button class="button_minus" onclick="button_minus_kr('.$detil->id.')" style="background:none; border:none; color:#ffffff;outline:none;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td width="15%" align="right" valign="top" style="border-bottom: 1px solid #ddd;padding-top: 10%;">
                                                    <button class="btn btn-default" onclick="delete_kr('.$detil->id.')" style="">X</button>
                                                    <input type="hidden"  id="order_id_delete'.$detil->id.'" name="order_id" value="'.$order->id.'">
                                                    <input type="hidden"  id="quantity_delete'.$detil->id.'" name="quantity" value="'.$detil->pivot->quantity.'">';
                                                    if($detil->discount > 0)
                                                        {
                                                        echo '<input type="hidden"  id="price_delete'.$detil->id.'" name="price" value="'.$detil->price_promo.'">';
                                                        }
                                                        else{
                                                            echo '<input type="hidden"  id="price_delete'.$detil->id.'" name="price" value="'.$detil->price.'">';
                                                        }
                                                    echo'<input type="hidden"  id="product_id_delete'.$detil->id.'"name="product_id" value="'.$detil->id.'">
                                                    <input type="hidden" id="id_delete'.$detil->id.'" name="id" value="'.$detil->pivot->id.'">
                                                </td>
                                            </tr>';
                                            
                                            }
                                        }
                                        echo '<tr>
                                            <td align="right" colspan="3">';
                                                    
                                            echo'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            
                                <div id="desc_code" style="display: none;">
                                    <div class="jumbotron jumbotron-fluid ml-2 py-4 mb-3">
                                        <p class="lead"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fixed-bottom" style="background-color:#e9eff5;">
                            <div class="container">
                                <div class="col-md-12 py-3">
                                <input type="hidden" id="order_id_cek" name="id" value="';if($item !== null){echo $item->id;}else{echo '';} echo'"/>';
                                    if($item!==null){
                                        echo '<input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="'.$item_price.'">';
                                    }
                                    else{
                                        echo'<input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="0">';
                                    }
                                    if($total_item > 0){
                                    echo'<!--<div class="input-group mb-2 mt-2">
                                            <input type="text" class="form-control" id="voucher_code" 
                                            placeholder="Gunakan Kode Diskon" aria-describedby="basic-addon2" required style="background:#ffcc94;outline:none;">
                                            <div class="input-group-append" required>
                                                <button class="btn " type="submit" onclick="btn_code()" style="background:#6a3137;outline:none;color:white;">Terapkan</button>
                                            </div>
                                        </div>-->';
                                    echo'
                                        <!--
                                        <div id="divchecktunai" class="custom-control custom-checkbox checkbox-lg ml-n3 mb-4 mt-n2">
                                            <input type="checkbox" class="custom-control-input" id="checktunai" checked="">
                                            <label class="custom-control-label" for="checktunai" style="color: #000;font-weight:600;">Pembayaran Tunai</label>
                                        </div>
                                        -->
                                        <div id="div_total" class="row float-left mt-2">
                                            <p class="mt-1" style="color: #000;font-weight:bold; ">Total Harga</p>&nbsp;
                                            <h2 id="total_kr_" style="font-weight:700;color: #153651;font-family: Montserrat;">Rp.&nbsp;'.number_format(($item_price) , 0, ',', '.').',-</h2>
                                            <input type="hidden" id="total_kr_val" value="'.$item_price.'">  
                                            <input type="hidden" class="form-control" id="voucher_code_hide">
                                        </div>';    
                                    echo'
                                        <div id="chk-bl-btn" class="row justify-content-end my-auto">
                                            <a type="button" id="beli_sekarang" class="btn button_add_to_pesan float-right mb-2" onclick="show_modal()" style="padding: 10px 20px;">Pesan Sekarang <i class="fab fa-whatsapp" aria-hidden="true" style="color: #ffffff !important; font-weight:900;"></i></a>
                                        </div>';
                                    }
                                echo'</div>
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>';
        }
    }

    public function cek_order(Request $request){
        $stock_status= DB::table('product_stock_status')
                       ->where('client_id','=',\Auth::user()->client_id)
                       ->first();
        $order_id = $request->get('order_id');
        if($stock_status->stock_status == 'ON'){
            $cek_order = DB::select("SELECT order_product.order_id, order_product.product_id,
            sum(order_product.quantity), products.stock, products.Product_name FROM products,order_product 
            WHERE order_product.product_id = products.id AND order_product.order_id = '$order_id' 
            GROUP BY order_product.product_id HAVING SUM(order_product.quantity) > products.stock");
        }
        else{
            $cek_order = NULL;
        }
        
        //$count_cek = count($cek_order);
        //return $cek_order;
        // Fetch all records
        $cekData['data'] = $cek_order;
        echo json_encode($cekData);
        exit;
    }

    public function preview_order(Request $request)
    {
        $id = $request->get('order_id');
        $ses_order = $request->session()->get('ses_order');
        //dd($ses_order->store_name);
        if($ses_order->customer_id == null){
            $customer = $request->session()->get('ses_order');
            $toko = $customer->store_name;
            $disable_button = '';
            $ps_error_toko = '';
        }else{
            $customer = Customer::where('id',$ses_order->customer_id)
                        ->where('status','ACTIVE')->first();
            if($customer == null){
                $toko = '';
                $disable_button = 'disabled';
                $ps_error_toko = '<small>
                                    <small>
                                        <p class="my-2" style="line-height:1.3;color:red;font-weight:400;text-align:left">
                                            Toko yang dipilih telah dihapus atau dinonaktifkan, mohon untuk menghubungi admin terkait.
                                        </p>
                                    </small>
                                </small>';
            }
            else{
                $disable_button = '';
                $ps_error_toko = '';
                $toko = $customer->store_name;
            }
        }
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
        $cekCombineDisc = $this->volumeDiscCombineCek($order->TotalQtyDiscVolume);
        //$cekCombineDisc = $this->cekTotalOrderDisc($id);
        //dd($paket_list);
        //return view('orders.detail', ['order' => $order, 'paket_list'=>$paket_list]);
        echo'
        
        <div id="PreviewToko_Produk" style="overflow: hidden;">
            <div class="row px-3">
                <div class="col-md-3 px-0 py-0">
                    <p class="text-left mb-1" style="color: #1A4066 !important;">Nama Toko</p>
                </div>
                <div class="col-md-9 p-0">
                    <div class="panel panel-custom panel-default">
                        <div class="panel-body px-2">
                            <small>
                                <small>
                                <p class="my-2" style="line-height:1.3;color:#000;font-weight:400;text-align:left">
                                    '.$toko.'
                                </p>
                                </small>
                            </small>
                            '.$ps_error_toko.'
                         </div>
                    </div>
                </div>
                <input type="hidden" id="dsbl_btn_wa" value="'.$disable_button.'">
            </div>
            
            <div class="mb-0 mt-4">
                <p class="text-left" style="color: #1A4066 !important;">Detail Pesanan</p>
            </div>';
            
            if(count($order->products_nonpaket) > 0){
                echo'
                <table width="100%" class="table table-hover">
                    <thead style="background: #f0f1f2 !important;text-align:left;">
                        <th class="" width="50%" style="">
                            <small>
                                <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>Produk</b></p></small>
                            </small>
                        </th>
                        <th width="10%" style="">
                            <div class="d-none d-md-block d-md-none">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>Jumlah</b></p></small>
                                </small>
                            </div>
                            <div class="d-md-none">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>Jml</b></p></small>
                                </small>
                            </div> 
                        </th>
                        <th width="50%" style="text-align:right" class="text-right pl-0">
                            <small>
                                <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Sub Total</b></p></small>
                            </small> 
                        </th>
                    </thead>
                    <tbody>';
                        
                        //echo dd ($cekCombineDisc);
                        $totalPlusDiscItem = 0;
                        $totl_param = 0;
                        foreach($order->products_nonpaket as $p){
                        echo'
                        <tr>
                            <td width="50%" style="">
                                <small>
                                    <small><p class="p-p" style="line-height:normal;color:#000;font-weight:400;text-align:left;">'.$p->Product_name.'</p></small>';
                                    if($p->pivot->preorder > 0){
                                        echo'
                                        <span class="badge badge-info">Tersedia : '.$p->pivot->available.'</span>
                                        <span class="badge badge-warning">Pre-Order : '.$p->pivot->preorder.'</span>';
                                    }
                                    $cekItemDisc = $this->volumeDiscPerItemCek($p->id,$p->pivot->quantity);
                                    
                                    if($cekItemDisc > 0){
                                        echo'<br><span><small><b>@Rp. '.number_format($cekItemDisc, 2, ',', '.').'</b></small></span>';
                                    }
                                    if($cekCombineDisc){
                                        $cekPriceDisc = $this->volumePriceDisc($p->id,$cekCombineDisc->id);
                                        if($cekPriceDisc){
                                            echo'<br><span><small><b>@Rp. '.number_format($cekPriceDisc->discount_price, 2, ',', '.').'</b></small></span>';
                                       }
                                    }
                                echo'
                                
                                </small>
                            </td>
                            <td style="padding-bottom:0;">
                                <small>
                                    <p style="line-height:1.3;color:#000;font-weight:400;text-align:left">'.$p->pivot->quantity.'</p>
                                    
                                </small>
                            </td>
                            <td width="40%" align="right" style="padding-bottom:0;" class="pl-0">';
                                if($cekItemDisc > 0){
                                    $paramDiscItem = $cekItemDisc * $p->pivot->quantity;
                                    $PriceForSum = $cekItemDisc * $p->pivot->quantity;
                                    echo '<p style="line-height:1.3;color:#000;font-weight:400;text-align:right">Rp. '.number_format($cekItemDisc * $p->pivot->quantity, 2, ',', '.').'</p></>';
                                }elseif($cekCombineDisc){
                                    if($cekPriceDisc){
                                        $PriceForSum = $cekPriceDisc->discount_price * $p->pivot->quantity;
                                        $paramDiscItem = 0;
                                        echo '<p style="line-height:1.3;color:#000;font-weight:400;text-align:right">Rp. '.number_format($cekPriceDisc->discount_price * $p->pivot->quantity, 2, ',', '.').'</p></>';
                                    }else{
                                        $PriceForSum = $p->pivot->price_item * $p->pivot->quantity;
                                        $paramDiscItem = 0;
                                        echo '<p style="line-height:1.3;color:#000;font-weight:400;text-align:right">Rp. '.number_format($p->pivot->price_item * $p->pivot->quantity, 2, ',', '.').'</p></>';
                                    }
                                }else{
                                    if(($p->pivot->discount_item != NULL) && ($p->pivot->discount_item > 0)){
                                        $PriceForSum = $p->pivot->price_item_promo * $p->pivot->quantity;
                                        $paramDiscItem = 0;
                                        echo '<small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">Rp. '.number_format($p->pivot->price_item_promo * $p->pivot->quantity, 2, ',', '.').'</p></small>';
                                    }else{
                                        $PriceForSum = $p->pivot->price_item * $p->pivot->quantity;
                                        $paramDiscItem = 0;
                                        echo '<p style="line-height:1.3;color:#000;font-weight:400;text-align:right">Rp. '.number_format($p->pivot->price_item * $p->pivot->quantity, 2, ',', '.').'</p></>';
                                    }
                                }
                            $totalPlusDiscItem += $PriceForSum;
                            $totl_param += $paramDiscItem;       
                            echo'</td>
                        </tr>';
                        }
                        echo '<tr>
                            
                        </tr>
                        <tr>';
                            $pirce_r = \App\order_product::where('order_id',$order->id)
                                ->whereNull('group_id')
                                ->whereNull('paket_id')
                                ->whereNull('bonus_cat')
                                ->sum(\DB::raw('price_item * quantity'));
                            
                            
                            if($cekCombineDisc){
                                $volume_id = $cekCombineDisc->id;
                                /*$price_disc =  \App\order_product::whereHas('discountVolume',function($query) use ($volume_id){
                                                    return $query->where('volume_id',$volume_id);
                                                
                                            })
                                            ->where('order_id',$order->id)
                                            ->whereNull('group_id')
                                            ->whereNull('paket_id')
                                            ->whereNull('bonus_cat')->get();*/

                                $price_disc = \DB::select("SELECT * FROM order_product as op
                                                            JOIN volume_discount_products as vdp
                                                            ON op.product_id = vdp.product_id
                                                            WHERE vdp.volume_id = '$volume_id'
                                                            AND op.order_id = '$order->id'
                                                            AND op.group_id IS NULL
                                                            AND op. paket_id IS NULL
                                                            AND op.bonus_cat IS NULL;");

                                $priceVolume = 0;
                                $priceNodisc = 0;
                                foreach( $price_disc as $pd){
                                    $priceVolume += $pd->quantity * $pd->discount_price;
                                    $priceNodisc += $pd->quantity * $pd->price_item;
                                }

                                $minprice = $priceNodisc - $priceVolume;
                                $price_rd = $pirce_r - $minprice;
                                $grandDiscVolume = $order->total_price - $minprice;
                                       
                            }
                            
                            
                            echo'
                            <td width="50%" align="right">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Total :</b></p></small>
                                </small>
                            </td>
                            <td align="left">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;">
                                        <b>'.$order->TotalQtyDiscVolume.'</b></p>
                                    </small>
                                </small>
                            </td>
                            <td width="40%" align="right" style="padding-bottom:0;" class="pl-0">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;">';
                                        if($cekCombineDisc){
                                            echo '<b>Rp. '.number_format($price_rd, 2, ',', '.').'</b></p>';
                                        }elseif($totl_param > 0){
                                            echo '<b>Rp. '.number_format($totalPlusDiscItem, 2, ',', '.').'</b></p>';
                                        }
                                        else{
                                            echo '<b>Rp. '.number_format($pirce_r, 2, ',', '.').'</b></p>';
                                        }
                                    echo '</small>
                                </small>
                                
                            </td>
                        </tr>';
                        
                        //grand total
                    if(count( $paket_list) < 1){
                        echo'
                        <tr>
                            <td width="50%" align="right">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Grand Total :</b></p></small>
                                </small>
                            </td>
                            <td align="left">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;">
                                        <b>'.$order->TotalQtyDiscVolume.'</b></p>
                                    </small>
                                </small>
                            </td>
                            <td width="40%" align="right" style="padding-bottom:0;" class="pl-0">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;">';
                                        if($cekCombineDisc){
                                            echo '<b>Rp. '.number_format($grandDiscVolume, 2, ',', '.').'</b></p>';
                                        }elseif($totl_param > 0){
                                            echo '<b>Rp. '.number_format($totalPlusDiscItem, 2, ',', '.').'</b></p>';
                                        }
                                        else{
                                            echo '<b>Rp. '.number_format($order->total_price, 2, ',', '.').'</b></p>';
                                        }
                                    echo'</small>
                                </small>
                            </td>
                        </tr>';
                    }
                    echo'</tbody>
                </table>';
            }
            
            if(count( $paket_list) > 0){
                foreach($paket_list as $paket){
                    $paket_name =\App\Paket::where('id',$paket->paket_id)
                                    ->first();
                        $group_name =\App\Group::where('id',$paket->group_id)
                                    ->first();           
                    echo '<table width="100%" class="table table-hover">
                        <thead style="background: #f0f1f2 !important;">
                            <th class="" width="50%" style="">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>'.$paket_name->display_name.' - '.$group_name->display_name.'</b></p></small>
                                </small>
                            </th>
                            <th width="10%" style="">
                                <div class="d-none d-md-block d-md-none">
                                    <small>
                                        <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>Jumlah</b></p></small>
                                    </small>
                                </div>
                                <div class="d-md-none">
                                    <small>
                                        <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>Jml</b></p></small>
                                    </small>
                                </div> 
                            </th>
                            <th width="50%" style="text-align:right" class="text-right pl-0">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Sub Total</b></p></small>
                                </small> 
                            </th>
                        </thead>
                        <tbody>';
                                $cek_paket=\DB::table('order_product')
                                            ->join('products','products.id','=','order_product.product_id')
                                            ->where('order_id',$order->id)
                                            ->where('paket_id',$paket->paket_id)
                                            ->where('group_id',$paket->group_id)
                                            ->orderBy('bonus_cat','ASC')
                                            ->get();
                            foreach($cek_paket as $p){
                            
                            echo'<tr>
                                <td width="50%" style="padding-bottom:0;">';
                                    if($p->bonus_cat == NULL){
                                        echo '
                                            <small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">'.$p->Product_name.'</p></small>
                                       ';
                                    }else{
                                        echo '
                                            <small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">'.$p->Product_name.'&nbsp;(<small><b>BONUS</b></small>)</p></small>
                                        ';
                                    }
                                    if($p->preorder > 0){
                                        echo'
                                        <small>
                                            <span class="badge badge-info">Tersedia : '.$p->available.'</span>
                                            <span class="badge badge-warning">Pre-Order : '.$p->preorder.'</span>
                                        </small>';
                                    }
                                echo '</td>
                                <td style="padding-bottom:0;">
                                    
                                        <small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">'.$p->quantity.'</p></small>
                                    
                                </td>
                                <td align="right" width="50%" style="padding-bottom:0;">';
                                    if($p->bonus_cat == NULL){
                                        if(($p->discount_item != NULL) && ($p->discount_item > 0)){
                                            echo '
                                                <small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">Rp. '.number_format($p->price_item_promo * $p->quantity, 2, ',', '.').'</p></small>
                                            ';
                                        }else{
                                            echo '<small>
                                                <p style="line-height:1.3;color:#000;font-weight:400;text-align:right">Rp. '.number_format($p->price_item * $p->quantity, 2, ',', '.').'</p>
                                            </small>';
                                        }
                                    }
                                echo '</td>
                            </tr>';
                            }
                            
                            echo '<tr>
                            <td width="50%" align="right">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Total :</b></p></small>
                                </small>
                            </td>
                            <td align="left">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;">
                                        <b>'.$order->TotalQtyPaket.'</b></p>
                                    </small>
                                </small>
                            </td>';
                                    $pkt_pirce = \App\order_product::where('order_id',$order->id)
                                    ->where('group_id',$paket->group_id)
                                    ->where('paket_id',$paket->paket_id)
                                    ->whereNull('bonus_cat')
                                    ->sum(\DB::raw('price_item * quantity'));
                            echo'<td width="40%" align="right" style="padding-bottom:0;" class="pl-0">
                                    <small>
                                        <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Rp. '.number_format($pkt_pirce, 2, ',', '.').'</b></p></small>
                                    </small>
                                </td>
                            </tr>';

                            //grand total
                            echo'<tr>
                                <td width="50%" align="right">
                                    <small>
                                        <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Grand Total :</b></p></small>
                                    </small>
                                </td>
                                <td align="left">
                                    <small>
                                        <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;">
                                            <b>'.((int)$order->TotalQtyDiscVolume+(int)$order->TotalQtyPaket).'</b></p>
                                        </small>
                                    </small>
                                </td>
                                <td width="40%" align="right" style="padding-bottom:0;" class="pl-0">
                                    <small>
                                        <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;">';
                                            if($cekCombineDisc){
                                                echo '<b>Rp. '.number_format($grandDiscVolume, 2, ',', '.').'</b></p>';
                                            }elseif((count($order->products_nonpaket) > 0) && ($totl_param > 0)){
                                                $mingrandItem = $pirce_r - $totalPlusDiscItem;
                                                $grandItem = $order->total_price - $mingrandItem;
                                                echo '<b>Rp. '.number_format($grandItem, 2, ',', '.').'</b></p>';
                                            }else{
                                                echo '<b>Rp. '.number_format($order->total_price, 2, ',', '.').'</b></p>';
                                            }
                                        echo'</small>
                                    </small>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>';
                }
            }
            echo '
        </div>';

        
    }

    public function preview_checkout(Request $request)
    {
        
        $ses_order = $request->session()->get('ses_order');
        //dd($ses_order->store_name);
        if($ses_order->customer_id == null){
            $customer = $request->session()->get('ses_order');
            $toko = $customer->store_name;
            $disable_button = '';
            $ps_error_toko = '';
        }else{
            $customer = Customer::where('id',$ses_order->customer_id)
                        ->where('status','ACTIVE')->first();
            if($customer == null){
                $toko = '';
                $disable_button = 'disabled';
                $ps_error_toko = '<small>
                                    <small>
                                        <p class="my-2 pl-2" style="line-height:1.3;color:white;font-weight:400;text-align:left">
                                            Toko yang dipilih telah dihapus atau dinonaktifkan, mohon untuk menghubungi admin terkait.
                                        </p>
                                    </small>
                                </small>';
            }
            else{
                $disable_button = '';
                $ps_error_toko = '';
                $toko = $customer->store_name;
            }
        }
        
        echo'
        <div id="PreviewToko_CheckOut" style="overflow: hidden;">
            <div class="row px-3 mt-4">
                <div class="col-lg-12 p-0">
                    <div class="panel panel-custom panel-default">
                        <div class="panel-body px-2">
                            <small>
                                <small>
                                <p class="my-2 pl-2" style="line-height:1.3;color:#000;font-weight:400;text-align:left">
                                    '.$toko.'
                                </p>
                                </small>
                            </small>
                            '.$ps_error_toko.'
                         </div>
                    </div>
                </div>
                <input type="hidden" id="dsbl_btn_checkout" value="'.$disable_button.'">
            </div>
        </div>';
    }

    public function delete_allcart(Request $request)
    {
        $id = $request->get('order_id');
        $order = Order::findorfail($id);
        $order->products()->detach();
        $order->forceDelete();
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

    public function tgl_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
     
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    public function checkForCart(Request $request){
        $stock_status= DB::table('product_stock_status')
                       ->where('client_id','=',\Auth::user()->client_id)
                       ->first();
        
        $itemId = $request->get('ProductId');
        
        if($stock_status->stock_status == 'ON'){
            $item = \App\product::findOrfail($itemId);
            $restStock = $item->stock - ($this->stockInfo($itemId)-$this->TotalQtyFinish($itemId));
        }else{
            if($request->get('quantity') != ''){
                $quantity = $request->get('quantity');
                $restStock = (int)$quantity + 1;
            }
            else{
                $restStock = null;
            }
            
        }
        
        
        /*
        if($stock_status->stock_status == 'ON'){
            $itemId = $request->get('ProductId');
            //$quantity = $request->get('quantity');
            $item = \App\product::findOrfail($itemId);
            $restStock = $item->stock - $this->stockInfo($itemId);
        }
        else{
            $restStock = null;
        }*/

        return response()->json($restStock,200);
    }

    public static function targetItemInfo($item,$customer_id){
        $month = date('m');
        $year = date('Y');
        $date_now = date('Y-m-d');
        $targetItem = \App\Store_Targets::with('product_target')
                    ->whereHas('product_target', function($q) use($item){
                            $q->where('productId',$item);
                     })
                     ->where('customer_id',$customer_id)
                     ->where('period','<=',$date_now)
                     ->orderBy('period','DESC')
                     ->first();
        return $targetItem;
        
        
    }

    public static function achTargetItem($item,$customer_id){
        $month = date('m');
        $year = date('Y');
        $achtargetItem = \App\Order::with('products')
                    ->whereHas('products', function($q) use($item){
                            $q->where('product_id',$item);
                     })
                     ->where('customer_id',$customer_id)
                     ->whereMonth('finish_time', $month)
                     ->whereYear('finish_time', $year)
                     ->get();
        $totalQty = $achtargetItem->sum('TotalQuantity');
        $totalNml = $achtargetItem->sum('TotalNominal');
        return [$totalQty,$totalNml];
    }

    public static function stockInfo($item){
        /*$orders = \App\Order::with('products')
                    ->whereHas('products', function($q) use($item){
                            $q->where('product_id',$item);
                     })
                     ->where('status','SUBMIT')
                     ->where('client_id',\Auth::user()->client_id)
                     ->get();
        $totalQtyOrders = $orders->sum('TotalQuantity');*/
        $client_id = \Auth::user()->client_id;
        $orders = \DB::select("SELECT o.id , o.status, op.product_id, op.quantity, 
                    SUM(op.quantity) AS totalQuantity
                    FROM orders o
                    INNER JOIN order_product op ON op.order_id = o.id
                    WHERE op.product_id = '$item' AND (o.status != 'CANCEL'
                    OR o.status != 'NO-ORDER')
                    AND o.client_id = '$client_id' ");
        $totalQtyOrders = 0;
        foreach($orders as $odr){
            $totalQtyOrders =  $odr->totalQuantity;
        }
        $_this = new self;
        return $totalQtyOrders + $_this->stockInfoPaket($item) ;/*+ $_this->QtyLeftPartShip($item);*/
    }

    public static function stockInfoPaket($item){
        /*$orders = \App\Order::with('products')
                    ->whereHas('products', function($q) use($item){
                            $q->where('product_id',$item);
                     })
                     ->where('status','SUBMIT')
                     ->where('client_id',\Auth::user()->client_id)
                     ->get();
        $totalQtyOrders = $orders->sum('TotalQuantity');*/
        $client_id = \Auth::user()->client_id;
        $orders = \DB::select("SELECT o.id , o.status, op.product_id, op.quantity, 
                    SUM(op.quantity) AS totalQuantity
                    FROM orders o
                    INNER JOIN order_paket_tmp op ON op.order_id = o.id
                    WHERE op.product_id = '$item' AND o.status = 'SUBMIT'
                    /*OR o.status = 'PROCESS'*/
                    AND o.client_id = '$client_id' ");
        $totalQtyOrders = 0;
        foreach($orders as $odr){
            $totalQtyOrders =  $odr->totalQuantity;
        }
                   
        return $totalQtyOrders;
    }

    public function volumeDiscPerItemCek($item_id,$total){
        $cekVolumeDisc_ = \App\VolumeDiscount::where('client_id',\Auth::user()->client_id)
                ->where('max_order','=',0)
                ->where('min_order','<=',$total)
                ->where('type',2)
                ->where('status','ACTIVE')
                ->first();
        if($cekVolumeDisc_){
            $cekVolumeDiscP = \App\VolumeDiscountProduct::where('volume_id',$cekVolumeDisc_->id)
                            ->where('product_id',$item_id)->first();
            if($cekVolumeDiscP){
                $priceVdisc = $cekVolumeDiscP->discount_price;
            }else{
                $priceVdisc = 0;
            } 
           

        }else{
            $cekVolumeDiscMinMax = \App\VolumeDiscount::where('client_id',\Auth::user()->client_id)
                    ->where('max_order','>=',$total)
                    ->where('min_order','<=',$total)
                    ->where('type',2)
                    ->where('status','ACTIVE')
                    ->first();
            if($cekVolumeDiscMinMax){
                $cekVolumeDiscP = \App\VolumeDiscountProduct::where('volume_id',$cekVolumeDiscMinMax->id)
                            ->where('product_id',$item_id)->first();
                if($cekVolumeDiscP){
                    $priceVdisc = $cekVolumeDiscP->discount_price;
                }else{
                    $priceVdisc = 0;
                } 
            }else{
                $cekVolumeDiscMax = \App\VolumeDiscount::where('client_id',\Auth::user()->client_id)
                        ->where('max_order','<=',$total)
                        ->where('type',2)
                        ->orderBy('max_order','DESC')
                        ->where('status','ACTIVE')
                        ->first();

                if($cekVolumeDiscMax){
                    $cekVolumeDiscP = \App\VolumeDiscountProduct::where('volume_id',$cekVolumeDiscMax->id)
                                ->where('product_id',$item_id)->first();
                    if($cekVolumeDiscP){
                        $priceVdisc = $cekVolumeDiscP->discount_price;
                    }else{
                        $priceVdisc = 0;
                    } 
                }else{
                    $priceVdisc = 0;
                }
            }

        }

        /*$cekVolumeDisc = \App\VolumeDiscount::where('client_id',\Auth::user()->client_id)
                        ->where('max_order','>=',$total)
                        ->where('min_order','<=',$total)
                        ->where('type',2)
                        ->first();
        if($cekVolumeDisc){
            $cekVolumeDiscP = \App\VolumeDiscountProduct::where('volume_id',$cekVolumeDisc->id)
                            ->where('product_id',$item_id)->first();
            if($cekVolumeDiscP){
                $priceVdisc = $cekVolumeDiscP->discount_price;
            }else{
                $priceVdisc = 0;
            } 
        }else{
            $priceVdisc = 0;
        }*/

        return $priceVdisc;
    }

    public function volumeDiscCombineCek($total){
        $cekVolumeDisc_ = \App\VolumeDiscount::where('client_id',\Auth::user()->client_id)
                        ->where('max_order','=',0)
                        ->where('min_order','<=',$total)
                        ->where('type',1)
                        ->where('status','ACTIVE')
                        ->first();
        if($cekVolumeDisc_){
            $cekVolumeDisc = $cekVolumeDisc_ ;
            
        }else{
            $cekVolumeDiscMinMax = \App\VolumeDiscount::where('client_id',\Auth::user()->client_id)
                        ->where('max_order','>=',$total)
                        ->where('min_order','<=',$total)
                        ->where('type',1)
                        ->where('status','ACTIVE')
                        ->first();
            if($cekVolumeDiscMinMax){
                $cekVolumeDisc = $cekVolumeDiscMinMax ;
            }else{
                $cekVolumeDiscMax = \App\VolumeDiscount::where('client_id',\Auth::user()->client_id)
                        ->where('max_order','<=',$total)
                        ->where('type',1)
                        ->orderBy('max_order','DESC')
                        ->where('status','ACTIVE')
                        ->first();
                $cekVolumeDisc = $cekVolumeDiscMax ;
            }
            
        }
        
    
        return $cekVolumeDisc;
    }

    public function volumePriceDisc($item_id,$volume_id){
        $cekVolumeDiscP = \App\VolumeDiscountProduct::where('volume_id',$volume_id)
                            ->where('product_id',$item_id)->first();
            

        return $cekVolumeDiscP;
    }

    public function cekTotalOrderDisc($orderId){
        $orderCek = \App\Order::with('products', function($query){
                        $query->whereHas('volumDiscProduct');
                    })
                    ->where('id',$orderId)
                    ->get();
       
        return $orderCek;
    }

    public function QtyLeftPartShip($item){
        $client_id = \Auth::user()->client_id;
        $orders = \DB::select("SELECT o.id , o.status, op.product_id, op.quantity, 
                                    op.deliveryQty, op.preorder, 
                                    SUM(CASE WHEN op.preorder > 0 
                                    THEN (op.quantity - IFNULL(op.deliveryQty,0)) ELSE 0 END )
                                    AS totalQuantity
                                    FROM orders o
                                    INNER JOIN order_product op 
                                    ON op.order_id = o.id
                                    WHERE op.product_id = '$item' 
                                    AND o.status = 'PARTIAL-SHIPMENT'
                                    AND o.client_id = '$client_id' ");
        $totalQtyOrders = 0;
        foreach($orders as $odr){
            $totalQtyOrders =  $odr->totalQuantity;
        }

        return $totalQtyOrders;
    }

    public static function TotalQtyFinish ($item){
        $client_id = \Auth::user()->client_id;
        $orders = \DB::select("SELECT o.id , o.status, op.product_id, op.quantity, 
                    SUM(op.quantity) AS totalQuantity
                    FROM orders o
                    INNER JOIN order_product op ON op.order_id = o.id
                    WHERE op.product_id = '$item' AND o.status = 'FINISH'
                    AND o.client_id = '$client_id' ");
        $totalQtyOrders = 0;
        foreach($orders as $odr){
            $totalQtyOrders =  $odr->totalQuantity;
        }
        $_this = new self;
        return $totalQtyOrders + $_this->TotalDelvPart($item);
    }

    public function TotalDelvPart($item){
        $client_id = \Auth::user()->client_id;
        $orders = \DB::select("SELECT o.id , o.status, op.product_id,op.deliveryQty,
                                SUM(IFNULL(op.deliveryQty,0))
                                AS totalQuantity
                                FROM orders o
                                INNER JOIN order_product op 
                                ON op.order_id = o.id
                                WHERE op.product_id = '$item' 
                                AND o.status = 'PARTIAL-SHIPMENT'
                                AND o.client_id = '$client_id' ");
        $totalQtyOrders = 0;
        foreach($orders as $odr){
            $totalQtyOrders =  $odr->totalQuantity;
        }

        return $totalQtyOrders;
    }
    
}
