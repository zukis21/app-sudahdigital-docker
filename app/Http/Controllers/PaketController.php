<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class PaketController extends Controller
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
                if(Gate::allows('manage-paket')) return $next($request);
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
        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';
        if($status){
        $pakets = \App\Paket::where('paket_name','LIKE',"%$keyword%")
        ->where('client_id','=',auth()->user()->client_id)
        ->where('status',strtoupper($status))->get();//->paginate(10);
        }
        else
            {
            $pakets = \App\Paket::where('paket_name','LIKE',"%$keyword%")
            ->where('client_id','=',auth()->user()->client_id)
            ->get();
            //->paginate(10);
            }
        return view('paket.index', ['pakets'=> $pakets,'vendor'=>$vendor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendor)
    {
        return view('paket.create',['vendor'=>$vendor]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vendor)
    {
        
        $newPaket = new \App\Paket;
        $newPaket->paket_name = $request->get('paket_name');
        $newPaket->display_name = $request->get('display_name');
        $newPaket->bonus_quantity = $request->get('bonus_quantity');
        $newPaket->purchase_quantity = $request->get('purchase_quantity');
        $newPaket->client_id = $request->get('client_id');
        $newPaket->save();
        if($request->get('save_action') == 'SAVE'){
          return redirect()
                ->route('paket.create',[$vendor])
                ->with('status', 'Paket paket successfully saved');
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
    public function edit($vendor,$id)
    {
        $id = \Crypt::decrypt($id);
        $cek = \App\order_product::where('paket_id',$id)->first();
        if($cek){
            return redirect()
                ->route('paket.index',[$vendor])
                ->with('error_edit', 'Can\'t edit, this paket already exists in order');
        }
        else{
            $pakets = \App\Paket::findOrfail($id);
            return view('paket.edit', ['pakets' => $pakets,'vendor'=>$vendor]); 
        }
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
        $paket = \App\Paket::findOrFail($id);
        $paket->paket_name = $request->input('paket_name');
        $paket->display_name = $request->input('display_name');
        $paket->bonus_quantity = $request->input('bonus_quantity');
        $paket->purchase_quantity = $request->input('purchase_quantity');
        $paket->save();
        return redirect()->route('paket.edit', [$vendor,\Crypt::encrypt($id)])->with('status',
        'Paket successfully update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vendor,$id)
    {
        
        $cek_exist = \App\order_product::where('paket_id','=',$id)->count();
        if( $cek_exist > 0){
            return redirect()->route('paket.index',[$vendor])->with('error_edit',
            'Can\'t delete item, this paket already exist in order');
        }else{
            $paket = \App\Paket::findOrFail($id);
            $paket->delete();
            return redirect()->route('paket.index',[$vendor])->with('status',
            'Paket successfully delete');
        }
    }

    public function update_status(Request $request, $vendor){
        if($request->get('save_action') == 'ACTIVATE')
        {
            $active_id = $request->input('activate_id');
            $paket = \App\Paket::findOrFail($active_id);
            $paket->status='ACTIVE';
            $paket->save();
            
            return redirect()->route('paket.index',[$vendor])->with('status',
            'Paket successfully activate');
        }else{
            $deactive_id = $request->input('deactivate_id');
            $paket = \App\Paket::findOrFail($deactive_id);
            $paket->status='INACTIVE';
            $paket->save();
            
            return redirect()->route('paket.index',[$vendor])->with('status',
            'Paket successfully deactivate');
        }
        
    }

    
}
