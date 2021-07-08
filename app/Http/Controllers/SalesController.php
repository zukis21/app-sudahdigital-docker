<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
Use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;

class SalesController extends Controller
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
                if(Gate::allows('manage-sales')) return $next($request);
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
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $users = \App\User::with('cities')->where('roles','=','SALES')
            ->where('client_id','=',auth()->user()->client_id)
            ->get();//paginate(10);
            $filterkeyword = $request->get('keyword');
            $status = $request->get('status');
            if($filterkeyword){
                if($status){
                    $users = \App\User::where('email','LIKE',"%$filterkeyword%")
                    ->where('status', 'LIKE', "%$status%")
                    ->where('client_id',auth()->user()->client_id)
                    ->get();
                    //->paginate(10);
                }
                else{
                    $users = \App\User::where('email','LIKE',"%$filterkeyword%")
                    ->where('client_id',auth()->user()->client_id)
                    ->get();//paginate(10);
                }
            }
            if($status){
                $users = \App\User::where('status', 'Like', "%$status")
                ->where('client_id',auth()->user()->client_id)
                ->get();//paginate(10);
            }
            
        }
        else{
            $user_id = \Auth::user()->id;
            $users = \App\User::whereHas('sls_exists', function($q) use($user_id)
                    {
                        return $q->where('spv_id','=',"$user_id");
                    })
                    //->whereIn('group_id', $user)
                    ->where('roles','=','SALES')
                    ->get();
                    //dd($users);
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
    public function store(Request $request, $vendor)
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
        $new_user->sales_area = $request->get('sales_area');
        
        $new_user->save();
        if ( $new_user->save()){
            return redirect()->route('sales.create',[$vendor])->with('status','Sales Succsessfully Created');
        }else{
            return redirect()->route('sales.create',[$vendor])->with('error','Sales Not Succsessfully Created');
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
        $user =\App\User::findOrFail($id);
        $user->name = $request->get('name');
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        $user->sales_area = $request->get('sales_area');
        $user->status = $request->get('status');
        $user->save();
        return redirect()->route('sales.edit',[$vendor,\Crypt::encrypt($id)])->with('status','Sales Succsessfully Update');
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
        return redirect()->route('sales.index',[$vendor])->with('status','Sales Succsessfully Delete');
    }

    public function export($vendor) {
        return Excel::download( new SalesExport(), 'Sales_Rep.xlsx') ;
    }
}
