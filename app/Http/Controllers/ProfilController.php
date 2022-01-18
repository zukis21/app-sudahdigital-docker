<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($vendor)
    {
        $id=\Auth::user()->id;
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        $paket = \App\Paket::where('client_id','=',\Auth::user()->client_id)->first();
        $user = \App\User::where('id',$id)->first();
        return view('customer.profil',['user'=> $user,'paket'=>$paket,'vendor'=>$vendor,'client'=>$client]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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
        $user =\App\User::findOrFail($id);
        if($request->has('avatar')){
            if($request->file('avatar')){
                if($user->avatar && file_exists(storage_path('app/public/'.$user->avatar)))
                {
                    \Storage::delete('public/'.$user->avatar);
                }
                $file = $request->file('avatar')->store('avatars','public');
                $user->avatar =$file;
            }
        }else if($request->has('profil_desc')){
            $user->profile_desc = $request->get('profil_desc');
        }
        
        $user->save();
        return redirect()->route('profil.index',[$vendor,$id])->with('status','User Succsessfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
