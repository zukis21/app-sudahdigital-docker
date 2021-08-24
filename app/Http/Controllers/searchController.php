<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\product;
use Illuminate\Http\Request;


class searchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    public function index(Request $request, $vendor, $key)
    {   
        $id_user = \Auth::user()->id;
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        $message = \App\Message::where('client_id',$client->id)->first();
        $banner = \App\Banner::where('client_id','=',$client->id)
                ->orderBy('position', 'ASC')->limit(5)->get();
        /*$categories = \App\Category::where('client_id','=',$client->id)
                    ->get();//paginate(10);*/
        $categories = \App\Category::where('client_id','=',$client->id)
                    ->whereNull('parent_id')
                    ->orderBy('name','ASC')
                    ->get();
        $paket = \App\Paket::where('client_id','=',$client->id)->first();//paginate(10);
        $cat_count = $categories->count();
        $stock_status= DB::table('product_stock_status')
                        ->where('client_id','=',$client->id)
                        ->first();
                        
        $top_product = product::with('categories')
                    ->where('client_id','=',$client->id)
                    ->where('top_product','=','1')
                    ->where('status','=','PUBLISH')
                    ->orderBy('top_product','ASC')->get();
                    
        $product = product::with('categories')
            ->where('client_id','=',$client->id)
            //->where('top_product','=','0')
            ->where("Product_name", "LIKE", "%$key%")
            ->where('status','=','PUBLISH')
            ->get();//->paginate(6);
                
        $top_count = $top_product->count();
        $count_data = $product->count();
        $keranjang = DB::select("SELECT orders.user_id, orders.status,orders.client_id,orders.customer_id, 
                    products.Product_name, products.image, products.price, products.discount,
                    products.price_promo, order_product.id, order_product.order_id,
                    order_product.product_id,order_product.quantity,order_product.group_id 
                    FROM order_product, products, orders WHERE order_product.group_id IS NULL
                    AND orders.client_id = '$client->id' AND orders.id = order_product.order_id AND 
                    order_product.product_id = products.id AND orders.status = 'SUBMIT' 
                    AND orders.user_id = '$id_user' AND orders.customer_id IS NULL ");
        $item = DB::table('orders')
                    ->where('client_id','=',$client->id)
                    ->where('user_id','=',"$id_user")
                    ->where('orders.status','=','SUBMIT')
                    ->whereNull('orders.customer_id')
                    ->first();
        $item_name = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('client_id','=',$client->id)
                    ->where('user_id','=',"$id_user")
                    ->whereNotNull('orders.customer_id')
                    ->first();
        
        $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('orders.client_id','=',$client->id)
                    ->where('user_id','=',$id_user)
                    ->whereNull('orders.customer_id')
                    ->distinct('order_product.product_id')
                    /*->whereNull('order_product.group_id')*/
                    ->count();
        //dd($item_name->id);
        //dd($total_item);
        $data=['total_item'=> $total_item, 
                'keranjang'=>$keranjang,
                'top_product'=>$top_product,
                'top_count'=>$top_count, 
                'product'=>$product,
                'item'=>$item,
                'item_name'=>$item_name,
                'count_data'=>$count_data,
                'paket'=>$paket,
                'categories'=>$categories,
                'cat_count'=>$cat_count,
                'banner'=>$banner,
                'stock_status'=>$stock_status,
                'vendor'=>$vendor,
                'client'=>$client,
                'message'=>$message,
                ];  
                   
        return view('customer.content_customer',$data);
        
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
    public function update(Request $request, $id)
    {
        //
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
