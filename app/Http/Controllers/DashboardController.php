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

    public function home_admin($vendor, $msgs = null){
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);

        $message = \App\Message::where('client_id',$client->id)->first();

        if($msgs){
            return view('home',['vendor'=>$vendor,'client'=>$client,'message'=>$message,'msgs'=>$msgs]);
        }else{
            $msgs = null;
            return view('home',['vendor'=>$vendor,'client'=>$client,'message'=>$message,'msgs'=>$msgs]);
        }
        
    }

    public function update(Request $request, $vendor, $id)
    {
        \Validator::make($request->all(), [
            'client_image' => 'mimes:jpg,jpeg,png|max:1000', //only allow this type extension file.
        ]);
        $client = \App\B2b_client::findOrFail($id);
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

    public function store_message(Request $request, $vendor){
        $m_setting = new \App\Message();
        $m_setting->client_id = \Auth::user()->client_id;
        $m_setting->m_tittle =$request->get('m_tittle');
        $m_setting->s_tittle =$request->get('s_tittle');
        $m_setting->c_tittle =$request->get('c_tittle');
        $m_setting->o_tittle =$request->get('o_tittle');

        $m_setting->save();
        if($m_setting->save()){
            $msgs = 'create-messagesetting-success';
        }
        return redirect()->route('home_admin',[$vendor,$msgs])->with('status','Message Tiitle Succsessfully Create');
    }

    public function update_message(Request $request, $vendor, $id){
        $m_setting = \App\Message::findOrFail($id);
        $m_setting->m_tittle =$request->get('m_tittle');
        $m_setting->s_tittle =$request->get('s_tittle');
        $m_setting->c_tittle =$request->get('c_tittle');
        $m_setting->o_tittle =$request->get('o_tittle');

        $m_setting->save();
        if($m_setting->save()){
            $msgs = 'update-messagesetting-success';
        }
        return redirect()->route('home_admin',[$vendor,$msgs])->with('status','Message Tiitle Succsessfully Update');
    }
}
