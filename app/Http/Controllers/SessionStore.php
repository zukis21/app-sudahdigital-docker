<?php

namespace App\Http\Controllers;
use App\Order;
use Illuminate\Http\Request;

class SessionStore extends Controller
{
    public function index(Request $request, $vendor){
        //$lat = $request->get('lat');
        //$lng = $request->get('lng');
        //$url = 'http://maps.google.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&sensor=false';
        //$geocode = @file_get_contents($url);
        //$json = json_decode($geocode);
        //$address = $json->results[0]->formatted_address;
        //echo $address;
        //echo $lat,$lng;
        if($request->get('nm_toko_hide') != ""){
            $id_user = \Auth::user()->id;
            //$client_id = \Auth::user()->client_id;
            //$cek_toko = $request->get('nm_toko_hide');
            //$name = $request->get('nm_cust_hide');
            //$addr_for_ses = $request->get('alamat_hide');
            //$new_cust = new \App\Customer;
            $ses_order = new Order;
            $ses_order->user_loc = $request->get('user_loc');
            $ses_order->name = $request->get('nm_cust_hide');
            $ses_order->phone = $request->get('no_telp_hide');
            $ses_order->phone_owner = $request->get('no_owner_hide');
            $ses_order->phone_store = $request->get('no_toko_hide');
            $ses_order->store_name = $request->get('nm_toko_hide');
            $ses_order->address = $request->get('alamat_hide');
            $ses_order->user_id = $id_user;
            //$ses_order->client_id = $client_id;
            $ses_order->status = 'NEW';
            $request->session()->put('ses_order', $ses_order);
            //dd($request->session()->get('ses_order', $ses_order));
            //$new_cust->save();
            /*if ( $new_cust->save()){
                $sel_cust = \App\Customer::where('client_id','=',$client_id)
                            ->where('name','LIKE BINARY',"%$name%")
                            ->where('phone','=',$request->get('no_telp_hide'))
                            ->where('phone_owner','=',$request->get('no_owner_hide'))
                            ->where('phone_store','=',$request->get('no_toko_hide'))
                            ->where('store_name','LIKE BINARY',"%$cek_toko%")
                            ->where('address','LIKE BINARY',"%$addr_for_ses%")
                            ->where('user_id','=',$id_user)
                            ->first();
                dd($sel_cust);
                $ses_order = new Order;
                $ses_order->user_loc = $request->get('user_loc');
                $ses_order->customer_id = $sel_cust->id;
                $request->session()->put('ses_order', $ses_order);
                dd($request->session()->get('ses_order', $ses_order));
            }
            */
        }
        else
            {
                $ses_order = new Order;
                //$ses_order->user_id = $request->get('user_id');
                //$ses_order->user_loc =$lat.','.$lng;
                $ses_order->user_loc = $request->get('user_loc');
                $ses_order->customer_id = $request->get('customer_id');
                $request->session()->put('ses_order', $ses_order);
            }
        return redirect()->route('home_customer',[$vendor]);
    }

    public function OrderSuccess(){
        $client_id = \Auth::user()->client_id;
        $vendor = \App\B2b_client::findOrFail($client_id);
        return redirect()->route('session.clear',[$vendor->client_slug]);
    }

    public function clear(Request $request, $vendor){
        $request->session()->forget('ses_order');
        return redirect()->route('home_customer',[$vendor]);
    }

    public function checkout_no_order(Request $request, $vendor){
        $user_id = \Auth::user()->id;
        $client_id = \Auth::user()->client_id;
        $ses_order = $request->session()->get('ses_order');
        if($ses_order->customer_id == null){
            $name = $ses_order->name;
            $store_name = $ses_order->store_name;
            $addr_for_ses = $ses_order->address;

            $new_cust = new \App\Customer;
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
                $customer = \App\Customer::findOrfail($sel_cust->id);
            }
        }else{
            $customer = \App\Customer::findOrfail($ses_order->customer_id);
        }

        $order = new \App\Order;
        $order->user_id = $user_id;
        $order->user_loc = $ses_order->user_loc;
        $order->client_id = $client_id;
        $order->customer_id = $customer->id;
        $order->notes_no_order = $request->get('notes_no_order');
        //$order->quantity = $quantity;
        $order->invoice_number = date('YmdHis');
        $order->total_price = 0;
        $order->status = 'NO-ORDER';
        $order->reasons_id = $request->get('reasons_id');
        $order->save();
        if($order->save()){
            $request->session()->forget('ses_order');
            return redirect()->route('home_customer',[$vendor]);
        }
    }

    public function logout_record(){
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $loged_out = \Carbon\Carbon::now();
        $log_time = $loged_out->toDateTimeString();
        //dd($log_time);
        $log_record = \App\LoginRecord::whereYear('logged_in',$year)
                    ->whereMonth('logged_in',$month)
                    ->whereDay('logged_in',$day)
                    ->where('user_id',auth()->user()->id)
                    ->where('client_id',auth()->user()->client_id)->first();
        if($log_record) {
            $log_record->logged_out = $log_time;
            $log_record->save();
        }
    }
}
