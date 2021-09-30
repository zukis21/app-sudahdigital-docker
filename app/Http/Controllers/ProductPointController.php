<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ProductPointController extends Controller
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
                if(Gate::allows('points-products')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index(Request $request, $vendor){
        /*$PointsProducts = \App\ProductReward::where('client_id',auth()->user()->client_id)
                ->groupBy('expires_at')
                ->select('*', \DB::raw('count(*) as total'))
               // ->selectRaw('sum(product_id) as sum, product_id')
                ->orderBy('id','DESC')
                ->get();
        //dd($PointsProducts);*/
        $PointsProducts = \App\ProductReward::where('client_id',auth()->user()->client_id)
                         ->where('status','ACTIVE')
                         ->orderBy('created_at','DESC')->get();
        return view ('points_products.index',['PointsProducts'=>$PointsProducts,'vendor'=>$vendor]);
    }

    public function create($vendor)
    {
        
        $products = \App\product::where('client_id',auth()->user()->client_id)
                    ->where('status','=','PUBLISH')
                    ->get();
        
        //dd($start_date);
        return view('points_products.create',['vendor'=>$vendor,'products'=>$products]);
    }

    public function store(Request $request, $vendor){
        
        if($request->has('products_id')){
            if(count($request->products_id) > 0) {
                $sum = 0;
                
                foreach ($request->products_id as $i => $v){
                    $data_PrPoints=array(
                        'client_id'=>\Auth::user()->client_id,
                        'product_id'=>$request->products_id[$i],
                        'quantity_rule'=>$request->quantity_rule[$i] ?? '0',
                        'prod_point_val'=>$request->prod_point_val[$i] ?? '0',
                    );
                    $cek_product = \App\ProductReward::where('client_id',\Auth::user()->client_id)
                                ->where('status','ACTIVE')
                                ->where('product_id',$request->products_id[$i])->first();
                    if($cek_product){
                        $ChangeStatus = \App\ProductReward::findOrFail($cek_product->id);
                        $ChangeStatus->status = 'EXPIRED';
                        $ChangeStatus->save();
                        if($ChangeStatus->save()){
                            $new_PrPoints = new \App\ProductReward();
                            $new_PrPoints->create($data_PrPoints);
                        }
                    }else{
                        $new_PrPoints = new \App\ProductReward();
                        $new_PrPoints->create($data_PrPoints);
                    }
                    
                }
            }
            return redirect()->route('pr_points.create',[$vendor])->with('status','Points Products Succsessfully Created');
        }
        else{
            return back()->withInput()->with('error','Failed to save, no products added');
        }
    }

    public function edit($vendor, $id)
    {
        $id = \Crypt::decrypt($id);
        $point = \App\ProductReward::findorFail($id);
        
        $products = \App\product::where('client_id',auth()->user()->client_id)
                    ->where('status','=','PUBLISH')
                    ->get();

        
        return view('points_products.edit',
                    [
                        'vendor'=>$vendor,
                        'point'=>$point,
                        'products'=>$products,
                    ]);
    }

    public function update(Request $request, $vendor, $id){
        
        $pointProduct = \App\ProductReward::findOrFail($id);
        $pointProduct->product_id = $request->get('product_id');
        $pointProduct->quantity_rule = $request->get('quantity_rule');
        $pointProduct->prod_point_val = $request->get('prod_point_val');

        $pointProduct->save();

        return redirect()->route('pr_points.edit',[$vendor,\Crypt::encrypt($id)])->with('status','Points Products Succsessfully Update');

    }

    public function destroy($vendor, $id){

        $del_item = \App\ProductReward::findOrFail($id);
        $del_item->delete();

        

        return redirect()->route('pr_points.index', [$vendor])->with('status',
        'Item successfully delete');
    }
}
