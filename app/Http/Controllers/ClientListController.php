<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ClientListController extends Controller
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
                if(Gate::allows('manage-client')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index(Request $request, $vendor)
    {
        $client_list = \App\B2b_Client::where('type','CLIENT')
                    ->orderBy('id','DESC')->get();//paginate(10);
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        return view ('client_so.index',['client'=>$client,'client_list'=>$client_list,'vendor'=>$vendor]);
    }

    public function create($vendor)
    {
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        return view('client_so.create',['client'=>$client,'vendor'=>$vendor]);
    }

    public function store(Request $request, $vendor)
    {
        $new_cust = new \App\B2b_Client;
        $new_cust->client_name = $request->get('client_name');
        $new_cust->client_slug = \Str::slug($request->get('client_name'),'-');
        $new_cust->email = $request->get('email');
        $new_cust->company_name = $request->get('company_name');
        $new_cust->phone_whatsapp = $request->get('phone_whatsapp');
        $new_cust->phone = $request->get('phone');
        $new_cust->client_address = $request->get('client_address');
        $new_cust->save();
        if ( $new_cust->save()){
            $cek_client = \App\B2b_Client::where('email','=',$request->get('email'))->first();
            $new_login = new \App\User;
            $new_login->client_id = $cek_client->id;
            $new_login->name = 'Superadmin';
            $new_login->email = $request->get('login_email');
            $new_login->password = \Hash::make('superadmin');
            $new_login->roles = 'SUPERADMIN';
            $new_login->created_at = $cek_client->created_at;
            $new_login->save();
            return redirect()->route('client_so.create',[$vendor])->with('status','Client Succsessfully Created');
        }else{
            return redirect()->route('client_so.create',[$vendor])->with('error','Client Not Succsessfully Created');
        }
    }

    public function update_client(Request $request, $vendor)
    {
        if($request->get('save_action') == 'ACTIVATE')
        {
            $active_id = $request->input('activate_id');
            $client = \App\B2b_Client::findOrFail($active_id);
            $client->status = 'ACTIVE';
            $client->save();
            if($client->save()){
                $users = \DB::table('users')->where('client_id', '=',$active_id)->update(array('status' => 'ACTIVE'));
            }
            return redirect()->route('client_so.index',[$vendor])->with('status',
            'Client successfully activate');
        }else{
            $active_id = $request->input('deactivate_id');
            //dd($active_id);
            $client = \App\B2b_Client::findOrFail($active_id);
            
            $client->status='INACTIVE';
            $client->save();
            
            if($client->save()){
                /*
                $group_product = \App\group_product::where('group_id',$deactive_id);
                $group_product->update([
                    'status' => 'INACTIVE'
                ]);*/
                $users = \DB::table('users')->where('client_id', '=',$active_id)->update(array('status' => 'INACTIVE'));
            }
            return redirect()->route('client_so.index',[$vendor])->with('status',
            'Client successfully deactivate');
        }
    }
}
