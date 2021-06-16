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
        $vendor = \App\B2b_Client::findOrFail($client_id);
        return redirect()->route('session.clear',[$vendor->client_slug]);
    }

    public function clear(Request $request, $vendor){
        $request->session()->forget('ses_order');
        return redirect()->route('home_customer',[$vendor]);
    }
}
