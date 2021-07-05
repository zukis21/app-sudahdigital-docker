<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxDetailPesananSales extends Controller
{
    public function search_order(Request $request){
        
        $output = '';
        $user_id = \Auth::user()->id;
        $query = $request->get('query');
        if($query != '' ){
            $orders = \DB::select("SELECT orders.* ,customers.id as cs_id, customers.store_name, customers.status as cs
                                FROM orders INNER JOIN customers ON orders.customer_id=customers.id
                                WHERE orders.user_id='$user_id' AND (customers.store_name LIKE '%$query%'
                                OR orders.status LIKE '%$query%' OR orders.created_at LIKE '%$query%')");
                    /*DB::table('orders')
                    ->join('customers','orders.customer_id','=','customers.id')
                    ->whereNotNull('customer_id')
                    ->where('orders.user_id','=',"$user_id")
                    ->Where('orders.status','LIKE',"%$query%")
                    ->orWhere('orders.created_at','LIKE',"%$query%")
                    ->orWhere('customers.store_name','LIKE',"%$query%")
                    ->get();*/
            
                    /*\App\Order::with('products')
                    ->with(['customers'=>function($q) use ($query){
                        $q->where('store_name','LIKE',"%$query%");
                    }])
                    ->orWhere('user_id','=',"$user_id")
                    ->orWhere('status','LIKE',"%$query%")
                    ->orWhere('created_at','LIKE',"%$query%")
                    //->orWhere('customers.store_name','LIKE',"%$query%")
                    ->get();
                    */
        }
        else{
            $orders = \App\Order::with('customers')->whereNotNull('customer_id')
                    ->where('user_id','=',"$user_id")
                    ->get();
        }
        if($orders != null ){
            $total_row = count($orders);
        }
        else{
            $total_row = 0;
        }
        if($total_row > 0){
            foreach($orders as $order){
                
                if($query != ''){
                    $customer_store = $order->store_name;
                    if($order->cs == 'NEW'){
                        $c_bdge_new = '<span class="badge bg-primarry">New</span>';
                    }else{
                        $c_bdge_new='';
                    }
                }else{
                    $customer_store = $order->customers->store_name;
                    if($order->customers->status == 'NEW'){
                        $c_bdge_new = '<span class="badge bg-primarry">New</span>';
                    }else{
                        $c_bdge_new='';
                    }
                }

                if($order->status == "SUBMIT"){
                    $color_badge = 'bg-warning';
                }
                else if($order->status == "PROCESS"){
                    $color_badge = 'bg-info';
                }
                else if($order->status == "FINISH"){
                    $color_badge = 'bg-success';
                }
                else if($order->status == "CANCEL"){
                    $color_badge = 'bg-danger';
                }

                

                $output.='
                <tr>
                    <td width="20%" style="padding-left:7px;">
                        <span class="style-badge badge '.$color_badge.' text-white status-order">'.$order->status.'</span>
                    </td>
                    <td width="50%">
                        <span class="data-list-order"><p class="mb-n1">Tanggal Order</p></span>
                        <b class="data-list-order mb-4">'.$order->created_at.'</b><br>

                        <!--<span class="data-list-order"><p class="mb-n1 mt-2">Total Quantity</p></span>
                        <b class="data-list-order"></b><br>-->

                        <span class="data-list-order"><p class="mb-n1 mt-2">Total Harga</p></span>
                        <b class="data-list-order"> Rp. '.number_format($order->total_price).'</b><br>
                        
                        <a onclick="open_detail_list('.$order->id.')" style="cursor: pointer;">
                            <span class="style-badge badge text-light mt-2"
                                style="padding:5px 10px;background:#1A4066">
                                <small><b>Detail Pesanan</b></small>
                            </span>
                        </a>
                    </td>
                    <td width="30%">
                        <span class="data-list-order">'.$customer_store.'</span>
                        '.$c_bdge_new.'
                    </td>
                    
                </tr>';
            }
        }
        else{
            $output = '<tr>
                            <td align="center" colspan="3">Data tidak ditemukan</td>
                       </tr>';
        }
        $orders = array(
        'table_data'  => $output
        );
     
        echo json_encode($orders);
    
    }

    public function detail(Request $request)
    {
        $id = $request->get('order_id');
        $order = \App\Order::findOrFail($id);
        if($order->canceled_by != null){
            $order_cancel = \App\User::findOrFail($order->canceled_by);
        }else{
            $order_cancel = null;        
        }
        //$order_cancel = \App\User::findOrFail($order->canceled_by);
        $paket_list = \DB::table('order_product')
                ->join('pakets','pakets.id','=','order_product.paket_id')
                ->join('groups','groups.id','=','order_product.group_id')
                ->where('order_id',$id)
                ->whereNotNull('paket_id')
                ->whereNotNull('group_id')
                ->whereNull('bonus_cat')
                ->distinct()
                ->get(['paket_id','group_id']);
        if($order->status == 'SUBMIT'){
            $bg_badge = 'bg-warning';
            $txt = 'ORDER SUBMITED';
        }else if($order->status == 'PROCESS'){
            $bg_badge = 'bg-info';
            $txt= 'ORDER PROCESSED';
        }
        else if($order->status == 'FINISH'){
            $bg_badge = 'bg-success';
            $txt= 'ORDER FINISHED';
        }
        else if($order->status == 'CANCEL'){
            $bg_badge = 'bg-danger';
            $txt= 'ORDER CANCELED';
        }
                //dd($paket_list);
        //return view('orders.detail', ['order' => $order, 'paket_list'=>$paket_list]);
        echo'
        <div id="DataListOrder">
            <small style="color:#1A4066;"><b>Detail Order</b></small>
            <hr>
            <div style="color:#000;">
                <small><b>Tanggal Order</b> <br>
                <p class="mt-n1">'.$order->created_at.'</p></small>

                <small class="mb-n2"><b >Status Order</b><br></small>
                <span class="badge '.$bg_badge.'" 
                    style="color:#ffffff;
                        margin-top:-20px;
                        border-top-right-radius:0;
                        border-top-left-radius:0;
                        border-bottom-right-radius:0;
                        border-bottom-left-radius:0;">
                    '.$order->status.'
                </span>
                
                <br>
                <!--
                <p class="mt-n1">'.$order->status.'</p></small>
                -->
                <small class="mt-n1"><b>Nama Toko</b><br>
                <p class="mt-n1">'.$order->customers->store_name.'</p></small>';
                /*if($order->customers->status == 'NEW'){
                    echo '<span class="badge bg-pink">New</span>';
                }*/
                echo'
                <small><b>Contact Person</b><br> 
                <p class="mt-n1">'.$order->customers->name.'</p></small>

                <small><b>Email</b><br>';
                if($order->customers->email){
                    echo'<p class="mt-n1">'.$order->customers->email.'</p></small>';
                }else{
                    echo'<p class="mt-n1">-</p></small>';
                }

                echo'
                <small><b>Alamat Toko</b><br>
                <p class="mt-n1">'.$order->customers->address.'</p></small>
                
                <small><b>No. Hp</b><br>
                <p class="mt-n1">'.$order->customers->phone.'</p></small>

                <small><b>No. Telp. Toko :</b><br>';
                if($order->customers->phone_store){
                    echo'<p class="mt-n1">'.$order->customers->phone_store.'</p></small>';
                }else{
                    echo'<p class="mt-n1">-</p></small>';
                }
                
                echo'<small><b>No. Telp. Pemilik Toko</b><br>';
                if($order->customers->phone_owner){
                    echo'<p class="mt-n1">'.$order->customers->phone_owner.'</p></small>';
                }else{
                    echo'<p class="mt-n1">-</p></small>';
                } 

                echo'
                <small><b>Nama Sales</b><br>
                <p class="mt-n1">'.$order->users->name.'</p></small>
                
                <small><b>ON/Off Lokasi Sales</b><br>
                <p class="mt-n1">'.$order->user_loc.'</p></small>

                
                <small><b>Jenis Pembayaran</b><br> 
                <p class="mt-n1">'.$order->payment_method.'</p></small>
                
                <small><b>Keterangan Order</b> <br>';
                if($order->notes){
                    echo'<p class="mt-n1">'.$order->notes.'</p></small>';
                }else{
                    echo'<p class="mt-n1">-</p></small>';
                }
                if($order->status == 'CANCEL'){
                    echo'
                    <small><b>Keterangan Pembatalan</b><br>
                    <p class="mt-n1">'.$order->notes_cancel.'</p></small>
                    
                    <small><b>Dibatalkan Oleh</b><br>
                    <p class="mt-n1">'.$order_cancel->name.'</p></small>';
                }
            echo'
           </div>
            <div class="mb-2">
                <small style="color:#1A4066;"><b>Detail Produk</b></small>
            </div>';
            
            if(count($order->products_nonpaket) > 0){
                echo'
                    <table width="100%" class="table table-hover" style="">
                        <thead class="thead-dark">
                            <th width="50%" style="padding-bottom:0;">
                                <small><b><p style="line-height:1.2;">Produk (NonPaket)</p></b></small>
                            </th>
                            <th width="" style="padding-bottom:0;">
                                <small><b><p style="line-height:1.2;">Jumlah </p></b></small> 
                            </th>
                            <th width="40%" style="padding-bottom:0;" class="text-right">
                                <small><b><p style="line-height:1.2;">Sub Total</p></b></small>
                            </th>
                        </thead>
                        <tbody>';
                            foreach($order->products_nonpaket as $p){
                                echo'<tr>
                                    <td width="50%" style="padding-bottom:0;">
                                        <small>
                                            <p style="line-height:1.2;">'.$p->Product_name.'</p>
                                        </small>
                                    </td>
                                    <td style="padding-bottom:0;">
                                        <small>
                                            <p style="line-height:1.2;">'.$p->pivot->quantity.'</p>
                                        </small>
                                    </td>
                                    <td width="40%" align="right" style="padding-bottom:0;">';
                                        if(($p->pivot->discount_item != NULL) && ($p->pivot->discount_item > 0)){
                                        echo '<small><p style="line-height:1.2;">Rp. '.number_format($p->pivot->price_item_promo * $p->pivot->quantity, 0, ',', '.').'</p></small>';
                                        }else{
                                        echo '<small><p style="line-height:1.2;">Rp. '.number_format($p->pivot->price_item * $p->pivot->quantity, 0, ',', '.').'</p></>';
                                        }
                                    echo'</td>
                                </tr>';
                            }
                            echo '<tr>';
                                $pirce_r = \App\order_product::where('order_id',$order->id)
                                    ->whereNull('group_id')
                                    ->whereNull('paket_id')
                                    ->whereNull('bonus_cat')
                                    ->sum(\DB::raw('price_item * quantity'));
                                
                                echo'<td colspan="2" align="right">
                                    <small>
                                        <p style="line-height:1.2;">
                                            <b>Total Harga :</b>
                                        </p>
                                    </small>
                                </td>
                                <td width="40%" align="right">
                                    <small>
                                        <p style="line-height:1.2;">
                                            <b>Rp. '.number_format($pirce_r, 0, ',', '.').'</b>
                                        </p>
                                    </small>
                                </td>
                            </tr>

                            <tr>
                            </tr>
                        </tbody>
                    </table>';
            }
            
            if(count( $paket_list) > 0){
                foreach($paket_list as $paket){
                    $paket_name =\App\Paket::where('id',$paket->paket_id)
                                    ->first();
                        $group_name =\App\Group::where('id',$paket->group_id)
                                    ->first();           
                    echo '<table width="100%" class="table table-hover ">
                        <thead class="thead-dark">
                            <th width="50%" style="padding-bottom:0;">
                                <small><b><p style="line-height:1.2;">Product '.$paket_name->display_name.' - '.$group_name->display_name.'</p></b></small>
                            </th>
                            <th width="" style="padding-bottom:0;">
                                <small><b><p style="line-height:1.2;">Jumlah </p></b></small> 
                            </th>
                            <th width="40%" style="padding-bottom:0;" class="text-right">
                                <small><b><p style="line-height:1.2;">Sub Total</p></b></small>
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
                                        echo '<small><p style="line-height:1.2;">'.$p->Product_name.'</p></small>';
                                    }else{
                                        echo '<small><p style="line-height:1.2;">'.$p->Product_name.'&nbsp;(<small><b>BONUS</b></small>)</p></samall>';
                                    }
                                echo '</td>
                                <td style="padding-bottom:0;">
                                    <small><p style="line-height:1.2;">'.$p->quantity.'</p></small>
                                </td>
                                <td align="right" width="40%" style="padding-bottom:0;">';
                                    if($p->bonus_cat == NULL){
                                        if(($p->discount_item != NULL) && ($p->discount_item > 0)){
                                            echo '<small><p style="line-height:1.2;">Rp. '.number_format($p->price_item_promo * $p->quantity, 0, ',', '.').'</p></samall>';
                                        }else{
                                            echo '<small><p style="line-height:1.2;">Rp. '.number_format($p->price_item * $p->quantity, 0, ',', '.').'</p></small>';
                                        }
                                    }
                                echo '</td>
                            </tr>';
                            }
                            
                            echo '<tr>
                            <td colspan="2" align="right"><small><p style="line-height:1.2;"><b>Total Harga :</b></p></small></p></td>';
                                    $pkt_pirce = \App\order_product::where('order_id',$order->id)
                                    ->where('group_id',$paket->group_id)
                                    ->where('paket_id',$paket->paket_id)
                                    ->whereNull('bonus_cat')
                                    ->sum(\DB::raw('price_item * quantity'));
                                echo'<td width="40%" align="right"><small><p style="line-height:1.2;"><b>Rp. '.number_format($pkt_pirce, 0, ',', '.').'</b></p></small></td>
                            </tr>
                        </tbody>
                    </table>';
                }
            }
            echo '<div class="grand-total" style="">
                
                    <table width="100%" class="table table-hover">
                        <thead class="thead-light">
                            <th style="border-bottom:none;" width="" class="text-right"><small><p style="line-height:1.2;"><b>Grand Total :</p></small></th>
                            <th style="border-bottom:none;" width="40%" class="text-right"><small><p style="line-height:1.2;"><b>Rp. '.number_format($order->total_price, 0, ',', '.').'</b></small></th>
                        </thead>
                    </table>
                
            </div>';
            if($order->status == 'SUBMIT'){
                echo'
                <div class="p-btn-detil">
                    <button type="submit" onclick="cancel_status('.$order->id.')" class="bt-dtl-pesan btn btn-danger py-1 px-3 mb-5 float-right mt-4"
                        style="background-color: #FF0000 !important;
                                border-top-right-radius:20px;
                                border-top-left-radius:20px;
                                border-bottom-right-radius:0;
                                border-bottom-left-radius:0;">
                        <i class="fa fa-times fa-1x" aria-hidden="true" style="color:#fff;font-weight:900;">
                        </i>&nbsp;<b>Batalkan Pesanan</b>
                    </button>
                </div>   
                ';
                
            }
        echo'
        </div>';

        
    }

    public function cancel_success(){
        $client_id = \Auth::user()->client_id;
        $vendor_cek= \App\B2b_Client::findorFail($client_id);
        $vendor = $vendor_cek->client_slug;
        
        return redirect()->route('pesanan', [$vendor]);
    }
}
