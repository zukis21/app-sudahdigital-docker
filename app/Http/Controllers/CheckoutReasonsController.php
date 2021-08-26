<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CheckoutReasonsController extends Controller
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
                if(Gate::allows('checkout-reasons')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index(Request $request, $vendor){
        $reasons = \App\ReasonsCheckout::where('client_id','=',auth()->user()->client_id)
                    ->orderBy('position','ASC')
                    ->get();
        return view ('orders.index_reasons',['reasons'=>$reasons,'vendor'=>$vendor]);
    }

    public function create($vendor)
    {
        return view('orders.create_reasons',['vendor'=>$vendor]);
    }

    public function store(Request $request, $vendor)
    {
        
        $max_position = \App\ReasonsCheckout::where('client_id','=',$request->get('client_id'))
                      ->max('position');
                      //->orderBy('position','DESC')
                      //->value('position');
        //dd($max_position);
        
        $name = $request->get('reasons_name');
        $newReasons = new \App\ReasonsCheckout;
        $newReasons->reasons_name = $name;
        
        $newReasons->client_id = $request->get('client_id');
        
        if($max_position == null){
            $newReasons->position = 1;
        }
        else{
            $newReasons->position = $max_position + 1;
        }
        
        $newReasons->save();
        
        //$newCategory->slug = \Str::slug($name,'-');
        
        
        return redirect()->route('reasons.create',[$vendor])->with('status','Reasons Succesfully Created');
    }

    public function edit($vendor,$id)
    {
        $id = \Crypt::decrypt($id);
        $reasons_edit = \App\ReasonsCheckout::findOrFail($id);
        return view('orders.edit_reasons',['reasons_edit'=>$reasons_edit,'vendor'=>$vendor]);
    }

    public function update(Request $request, $vendor, $id)
    {
        $name = $request->get('reasons_name');
        $reasons = \App\ReasonsCheckout::findOrFail($id);
        $reasons->reasons_name = $name;
        $reasons->save();
        return redirect()->route('reasons.edit', [$vendor,\Crypt::encrypt($id)])->with('status','Reasons Succsessfully Update');
    }

    public function delete_permanent($vendor, $id){

        $reasons = \App\ReasonsCheckout::findOrFail($id);

        $order_reasons = \App\Order::where('reasons_id',$id)->count();
        //dd($order_reasons);
        if($order_reasons > 0){
            return redirect()->route('reasons.index',[$vendor])->with('error', 'Cannot be deleted, because this data already exists in order');
        }
        else {
            $reasons->forceDelete();
            return redirect()->route('reasons.index',[$vendor])->with('status', 'Reasons permanently deleted!');
        }
    }
}
