<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
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
                if(Gate::allows('manage-users')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $vendor)
    {
        $users = \App\User::where('roles','!=','SALES')
        ->where('client_id','=',auth()->user()->client_id)
        ->get();//paginate(10);
        $filterkeyword = $request->get('keyword');
        $status = $request->get('status');
        if($filterkeyword){
            if($status){
                $users = \App\User::where('email','LIKE',"%$filterkeyword%")
                ->where('client_id',auth()->user()->client_id)
                ->where('status', 'LIKE', "%$status%")
                ->get();
                //->paginate(10);
            }
            else{
                $users = \App\User::where('email','LIKE',"%$filterkeyword%")
                ->where('client_id','=',auth()->user()->client_id)
                ->get();//paginate(10);
            }
        }
        if($status){
            $users = \App\User::where('status', 'Like', "%$status")
            ->where('client_id','=',auth()->user()->client_id)
            ->get();//paginate(10);
        }
        return view ('users.index',['users'=>$users,'vendor'=>$vendor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendor)
    {
        return view('users.create',['vendor'=>$vendor]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_user = new \App\User;
        $new_user->client_id = $request->get('client_id');
        $new_user->name = $request->get('name');
        $new_user->email = $request->get('email');
        $new_user->password = \Hash::make($request->get('password'));
        //$new_user->username = $request->get('username');
        $new_user->roles = $request->get('roles');
        $new_user->address = $request->get('address');
        $new_user->phone = $request->get('phone');
        if($request->file('avatar')){
            $file = $request->file('avatar')->store('avatars','public');
        $new_user->avatar =$file;
        }
        $new_user->save();

        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        if ( $new_user->save()){
            return redirect()->route('users.create',[$client->client_slug])->with('status','User Succsessfully Created');
        }else{
            return redirect()->route('users.create',[$client->client_slug])->with('error','User Not Succsessfully Created');
        }
        
       
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($vendor, $id)
    {
        $id = \Crypt::decrypt($id);
        $user = \App\User::findOrFail($id);
        return view('users.edit',['user'=>$user,'vendor'=>$vendor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vendor, $id)
    {
       
        $user = \App\User::findOrFail($id);
        //dd($user);
        $user->name = $request->get('name');
        if(auth()->user()->id != $id){
            $user->status = $request->get('status');
            $user->roles = $request->get('roles');
        }
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        if($request->file('avatar')){
            if($user->avatar && file_exists(storage_path('app/public/'.$user->avatar)))
            {
                \Storage::delete('public/'.$user->avatar);
            }
            $file = $request->file('avatar')->store('avatars','public');
            $user->avatar =$file;
        }
        $user->save();
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        return redirect()->route('users.edit',[$client->client_slug,\Crypt::encrypt($id)])->with('status','User Succsessfully Update');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vendor, $id)
    {
        $user = \App\User::findOrFail($id);
        $user->delete();
        //$client=\App\B2b_client::findOrfail(auth()->user()->client_id); 
        return redirect()->route('users.index',[$vendor])->with('status','User Succsessfully Delete');
    }

}
