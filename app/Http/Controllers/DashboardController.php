<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function __construct(){
        
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $param = \Route::current()->parameter('vendor');
            //dd($param);
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            //dd($client->client_slug);
            if($client->client_slug == $param){
                if(session()->get('client_sess')== null){
                    \Request::session()->put('client_sess',
                    ['client_name' => $client->client_name,'client_image' => $client->client_image]);
                }
                if(Gate::allows('home-admin')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function home_admin($vendor){
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        return view('home',['vendor'=>$vendor,'client'=>$client]);
    }

    public function update(Request $request, $vendor, $id)
    {
        \Validator::make($request->all(), [
            'client_image' => 'mimes:jpg,jpeg,png|max:1000', //only allow this type extension file.
        ]);
        $client = \App\B2b_Client::findOrFail($id);
        //dd($user);
        $client->client_name = $request->get('client_name');
        $client->company_name = $request->get('company_name');
        $client->email = $request->get('email');
        $client->phone_whatsapp = $request->get('phone_whatsapp');
        $client->phone = $request->get('phone');
        $client->client_address = $request->get('client_address');
        $client->fb_url = $request->get('fb_url');
        $client->inst_url = $request->get('inst_url');
        $client->ytb_url = $request->get('ytb_url');
        $client->twt_url = $request->get('twt_url');
        
        if($request->file('client_image')){
            $file_get = $request->file('client_image');
            $file = '/client_image/';
            //dd($file);
            $nama_file = time()."_".$file_get->getClientOriginalName();
            $tujuan_upload = public_path('/assets/image/client_image');
            $file_get->move($tujuan_upload,$nama_file);
            $client->client_image =$file.$nama_file;
        }
        $client->save();
        if($client->save()){
            $request->session()->forget('client_sess');
        }
        return redirect()->route('home_admin',[$vendor])->with('status','Profile Succsessfully Update');
    }
}
