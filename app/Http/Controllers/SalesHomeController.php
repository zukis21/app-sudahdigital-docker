<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\product;
use Illuminate\Http\Request;

class SalesHomeController extends Controller
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

    public function index(Request $request, $vendor, $cat = null)
    {   
        $routeName = \Route::currentRouteName();

        $id_user = \Auth::user()->id;
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        $banner = \App\Banner::where('client_id','=',$client->id)
                ->orderBy('position', 'ASC')->limit(5)->get();
        $categories = \App\Category::where('client_id','=',$client->id)
                    ->get();//paginate(10);
        $paket = \App\Paket::where('client_id','=',$client->id)->first();//paginate(10);
        $cat_count = $categories->count();
        $stock_status= DB::table('product_stock_status')
                        ->where('client_id','=',$client->id)
                        ->first();
        if($routeName == 'home_paket'){
            $all_product = \App\product::where('client_id','=',$client->id)
                          ->where('status','=','PUBLISH')->get();
        }                
        $top_product = product::with('categories')
                    ->where('client_id','=',$client->id)
                    ->where('top_product','=','1')
                    ->where('status','=','PUBLISH')
                    ->orderBy('top_product','ASC')->get();
        if($cat){
            //$category_id = $request->get('cats');
            $cat_id = \App\Category::whereRaw('BINARY slug = ?',[$cat])->first();
            //dd($cat_id);
            if($cat_id){
                $product = \App\product::where('client_id','=',$client->id)
                    ->whereHas('categories',function($q) use ($cat_id){
                    return $q->where('category_id','=',$cat_id->id)
                    ->where('status','=','PUBLISH');
                    //->where('top_product','=','0');
                    })
                ->get();
            }else{
                abort(404, 'Tidak ditemukan');
            }
        }else{
            if($routeName == 'home_paket'){
                $product = \App\Group::with('item_active')
                            ->where('client_id','=',$client->id)
                            ->where('status','ACTIVE')
                            ->get();
            }
            else{
                $product = product::with('categories')
                    ->where('client_id','=',$client->id)
                    //->where('top_product','=','0')
                    ->where('status','=','PUBLISH')
                    ->get();//->paginate(6);
                }
        }
            
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
        /*$krj_paket = DB::select("SELECT orders.user_id, orders.status,orders.customer_id, 
                    products.Product_name, products.image, products.price, products.discount,
                    products.price_promo, order_product.id, order_product.order_id,
                    order_product.product_id,order_product.quantity,order_product.group_id,order_product.bonus_cat  
                    FROM order_product, products, orders WHERE order_product.group_id IS NOT NULL
                    AND orders.id = order_product.order_id AND order_product.bonus_cat IS NULL AND
                    order_product.product_id = products.id AND orders.status = 'SUBMIT' 
                    AND orders.user_id = '$id_user' AND orders.customer_id IS NULL ");*/
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
        if($routeName == 'home_paket'){
            $data=['total_item'=> $total_item, 
                'keranjang'=>$keranjang,
                'all_product'=>$all_product,
                'product'=>$product,
                'item'=>$item,
                'item_name'=>$item_name,
                'count_data'=>$count_data,
                'paket'=>$paket,
                'categories'=>$categories,
                'cat_count'=>$cat_count,
                'banner'=>$banner,
                'client'=>$client,
                //'paket_id'=>$paket_id,
                'vendor'=>$vendor,
                'stock_status'=>$stock_status
            ];
        }else{
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
                'client'=>$client
                ];  
        }            
        
        if($routeName == 'home_paket'){
            return view('customer.paket',$data);
        }else{
            return view('customer.content_customer',$data);
        }
    } 
}
