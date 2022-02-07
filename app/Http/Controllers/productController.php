<?php

namespace App\Http\Controllers;

use App\product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsLowStock;
use App\Exports\AllProductExport;
use App\Imports\ProductsImport;
use Illuminate\Support\Arr;
use App\Exports\ProductListInfo;

class productController extends Controller
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
                if(Gate::allows('manage-products')) return $next($request);
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
            $products = \App\product::with('categories')
            ->where('client_id','=',auth()->user()->client_id)
            ->where('Product_name','LIKE',"%$keyword%")
            ->where('status',strtoupper($status))->get();//->paginate(10);
            $stock_status= DB::table('product_stock_status')
            ->where('product_stock_status.client_id','=',auth()->user()->client_id)
            ->first();
        }
        else
            {
                $products = \App\product::with('categories')
                ->where('client_id','=',auth()->user()->client_id)
                ->where('Product_name','LIKE',"%$keyword%")->get();
                //->paginate(10);
                $stock_status= DB::table('product_stock_status')
                ->where('product_stock_status.client_id','=',auth()->user()->client_id)
                ->first();
            }
        return view('products.index', ['products'=> $products, 'stock_status'=>$stock_status, 'vendor'=>$vendor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendor)
    {
        $client_id = \Auth::user()->client_id;
        $stock_status= DB::table('product_stock_status')
                    ->where('client_id','=',$client_id)
                    ->first();
        $categories = \App\Category::where('client_id','=',auth()->user()->client_id)
                    ->whereNull('parent_id')
                    ->orderBy('name','ASC')
                    ->get();
        return view('products.create',['stock_status'=>$stock_status,'vendor'=>$vendor,'categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vendor)
    {
        /*\Validator::make($request->all(), [
            "Product_name" => "required|min:0|max:200",
            "description" => "required|min:0|max:1000",
            "image" => "required",
            "price" => "required|digits_between:0,10",
            "stock" => "required|digits_between:0,10"
        ])->validate();*/
        $new_product = new \App\product;
        $new_product->client_id = $request->get('client_id');
        $new_product->product_code = $request->get('code');
        $new_product->Product_name = $request->get('Product_name');
        $new_product->description = $request->get('description');
        if($request->has('discount') && ($request->get('discount') > 0)){
            $new_product->discount = $request->get('discount');
            $percent = $request->get('discount');
            $harga = $request->get('price');
            $discount = ($harga * $percent)/100;
            $harga_discount = $harga - $discount;
            $new_product->price = $harga;
            $new_product->price_promo =  $harga_discount;
        }else{
            $new_product->discount = 0.00;
            $new_product->price = $request->get('price');
            $new_product->price_promo = $request->get('price');
        }
        $new_product->stock = $request->get('stock');
        $new_product->low_stock_treshold = $request->get('low_stock_treshold');
        if($request->has('top_product')){
            $new_product->top_product=$request->get('top_product');
        }else{
            $new_product->top_product = 0;
        }
        $new_product->status = $request->get('save_action');
        $new_product->slug = \Str::slug($request->get('Product_name'));
        $new_product->created_by = \Auth::user()->id;
        $image = $request->file('image');
      
        if($image){
          $image_path = $image->store('products-images', 'public');
      
          $new_product->image = $image_path;
        }
        
        $new_product->save();

        $new_product->categories()->attach($request->get('categories'));
      
        if($request->get('save_action') == 'PUBLISH'){
          return redirect()
                ->route('products.create',[$vendor])
                ->with('status', 'Product successfully saved and published');
        } else {
          return redirect()
                ->route('products.create',[$vendor])
                ->with('status', 'Product saved as draft');
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
        $client_id = \Auth::user()->client_id;
        //dd($client_id);
        $product = \App\product::findOrFail($id);
        $stock_status= DB::table('product_stock_status')
                      ->where('client_id','=',$client_id)->first();
        $a = '';
        foreach($product->categories as $p){
            $a = $p->id;
        }             
        //return $a;
        if($a != null){
            $cat_edit = \App\Category::findOrFail($a);
        }              
        else{
            $cat_edit= '';
        }
        //dd($a);
        $categories = \App\Category::where('client_id','=',auth()->user()->client_id)
                    ->whereNull('parent_id')
                    ->orderBy('name','ASC')
                    ->get();
        return view('products.edit', ['product' => $product, 'stock_status'=>$stock_status, 'vendor'=>$vendor,'categories'=>$categories,'cat_edit'=>$cat_edit]);
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
        $product = \App\product::findOrFail($id);
        $product->product_code = $request->get('code');
        $product->Product_name = $request->get('Product_name');
        $product->description = $request->get('description');
        if($request->has('discount') && ($request->get('discount') > 0)){
            $product->discount = $request->get('discount');
            $percent = $request->get('discount');
            $harga = $request->get('price');
            $discount = ($harga * $percent)/100;
            $harga_discount = $harga - $discount;
            $product->price = $harga;
            $product->price_promo = $harga_discount;
        }else{
            $product->price = $request->get('price');
            $product->discount = 0.00;
            $product->price_promo = $request->get('price');
        }
        $product->stock = $request->get('stock');
        $product->low_stock_treshold = $request->get('low_stock_treshold');
        if($request->has('top_product')){
            $product->top_product=$request->get('top_product');
        }else{
            $product->top_product = 0;
        }
        //$product->slug = $request->get('slug');
        $product->slug = \Str::slug($request->get('Product_name'));
        $new_image = $request->file('image');
        if($new_image){
            if($product->image && file_exists(storage_path('app/public/'.$product->image))){
            \Storage::delete('public/'. $product->image);
            }
        $new_image_path = $new_image->store('products-images', 'public');
        $product->image = $new_image_path;
        }
        $product->updated_by = \Auth::user()->id;
        $product->status = $request->get('status');
        $product->save();
        $product->categories()->sync($request->get('categories'));

        if($product->save()){
            $period = date('Y-m-01');
            //$year = date('Y');
            $store_target = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                            ->where('period','>=',$period)
                            ->get();
            //dd($store_target);
            if($store_target){
               foreach($store_target as $st){
                    $productsTarget = \App\ProductTarget::where('storeTargetId',$st->id)
                                    ->where('productId',$id)->first();
                    if($productsTarget){
                        $nml_values = $request->get('price');
                        $productsTarget->nominalValues = $nml_values * $productsTarget->quantityValues;
                        $productsTarget->save();
                    }
                } 
            }
            
        }
        return redirect()->route('products.edit', [$vendor, \Crypt::encrypt($product->id)])->with('status',
        'Product successfully updated');
    }

    public function actorderact(Request $request, $vendor, $id)
    {
        $product = \App\product::findOrFail($id);
        $product->status = $request->get('status');
        $product->save();
        $status_page = $request->get('status_page');
        if($status_page == 'low_stock'){
            return redirect()->route('products.low_stock', [$vendor])->with('status',
            'Product successfully '. $request->get('status'));
        }else{
            return redirect()->route('products.index', [$vendor, 'status' =>$status_page])->with('status',
            'Product successfully '. $request->get('status'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$vendor, $id)
    {
        $product = \App\product::findOrFail($id);
        $status_page = $request->get('status_page');
        $product->delete();
        
        if($status_page == 'low_stock'){
            return redirect()->route('products.low_stock', [$vendor])->with('status', 'Product moved to
            trash');
        }else{
            return redirect()->route('products.index',[$vendor,'status'=>$status_page])->with('status', 'Product moved to
            trash');
        }
        
    }

    public function trash($vendor){
        
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $products = \App\product::where('client_id','=',auth()->user()->client_id)
            ->onlyTrashed()
            ->get();//->paginate(10);
            $stock_status= DB::table('product_stock_status')
                ->where('product_stock_status.client_id','=',auth()->user()->client_id)
                ->first();
            return view('products.trash', ['products' => $products,'vendor'=>$vendor,'stock_status'=>$stock_status]);
        }else{
            abort(404, 'Tidak ditemukan');
        }
    }

    public function restore($vendor,$id){

        $product = \App\product::withTrashed()->findOrFail($id);
        if($product->trashed()){
        $product->restore();
        return redirect()->route('products.trash',[$vendor])->with('status', 'Product successfully restored');
        } else {
        return redirect()->route('products.trash',[$vendor])->with('status', 'Product is not in trash');
        }
    }

    public function deletePermanent($vendor, $id){

        $product = \App\product::withTrashed()->findOrFail($id);
        if(!$product->trashed()){
        return redirect()->route('products.trash',[$vendor])->with('status', 'Product is not in trash!')->with('status_type', 'alert');
        } else {
            if($product->orders()->count()){
                return back()->with('error','Cannot delete, product has orders records');
            }else{
                $product->categories()->detach();
                $product->forceDelete();
                return redirect()->route('products.trash',[$vendor])->with('status', 'Product permanently deleted!');
            }
        }

    }

    public function low_stock($vendor){
        /*$products = \App\product::with('categories')
                    ->where('products.client_id','=',auth()->user()->client_id)
                    ->whereRaw('stock < low_stock_treshold')->get();//->paginate(10);*/
        $products = \App\product::with('categories')
                    ->where('client_id','=',auth()->user()->client_id)
                    ->where('status','PUBLISH')->get();
        $stock_status= DB::table('product_stock_status')
                    ->where('product_stock_status.client_id','=',auth()->user()->client_id)
                    ->first();
        return view('products.low_stock', ['products' => $products, 'vendor'=>$vendor,'stock_status'=>$stock_status]);
    }

    public function edit_stock($vendor){
        return view('products.edit_stock',['vendor'=>$vendor]);
    }

    public function update_low_stock(Request $request, $vendor){
        $newstock= $request->get('stock');
        $product = DB::table('products')
                    ->where('client_id','=',auth()->user()->client_id)
                    ->whereRaw('stock < low_stock_treshold')
                    ->where('deleted_at',NULL)->update(array('stock' => $newstock));
        return redirect()->back()->with('status',
        'Stock successfully updated');
    }

    public function export_low_stock($vendor) {
        return Excel::download( new ProductsLowStock(), 'Products_low_stock.xlsx') ;
    }

    public function export_all($vendor) {
        return Excel::download( new AllProductExport(), 'Products.xlsx') ;
    }

    public function import_product($vendor){
        return view('products.import_products',['vendor'=>$vendor]);
    }

    public function import_data(Request $request, $vendor)
    {
        \Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx"
        ])->validate();
        
        Excel::import(new ProductsImport,request()->file('file'));
        return redirect()->route('products.import_products',[$vendor])->with('status', 'File successfully upload');
        /*$data = Excel::toArray(new ProductsImport, request()->file('file')); 

        $update = collect(head($data))
            ->each(function ($row, $key){
                DB::table('products')
                    ->where('id', $row['product_id'])
                    ->update(Arr::except($row,['product_id']));   
            });
        
        if($update){
            return redirect()->route('products.import_products')->with('status', 'File successfully upload'); 
        }
        */
    }

    public function exportProductInfo($vendor) {
        return Excel::download( new ProductListInfo(), 'ProductLists.xlsx') ;
    }

    public static function OrderSubmit($item){
        $client_id = \Auth::user()->client_id;
        $orders = \DB::select("SELECT o.id , o.status, op.product_id, op.quantity, 
                    SUM(op.quantity) AS totalQuantity
                    FROM orders o
                    INNER JOIN order_product op ON op.order_id = o.id
                    WHERE op.product_id = '$item' AND o.status = 'SUBMIT'
                    AND o.client_id = '$client_id' ");
        $totalQtyOrders = 0;
        foreach($orders as $odr){
            $totalQtyOrders =  $odr->totalQuantity;
        }
       
        return $totalQtyOrders ;
    }

    public static function OrderProcess($item){
        $client_id = \Auth::user()->client_id;
        $orders = \DB::select("SELECT o.id , o.status, op.product_id, op.quantity, 
                    SUM(op.quantity) AS totalQuantity
                    FROM orders o
                    INNER JOIN order_product op ON op.order_id = o.id
                    WHERE op.product_id = '$item' AND o.status = 'PROCESS'
                    AND o.client_id = '$client_id' ");
        $totalQtyOrders = 0;
        foreach($orders as $odr){
            $totalQtyOrders =  $odr->totalQuantity;
        }
       
        return $totalQtyOrders ;
    }

    public static function OrderPartialOutstanding($item){
        $client_id = \Auth::user()->client_id;
        $orders = \DB::select("SELECT o.id , o.status, op.product_id,op.deliveryQty,
                                SUM((op.quantity) - IFNULL(op.deliveryQty,0))
                                AS totalQuantity
                                FROM orders o
                                INNER JOIN order_product op 
                                ON op.order_id = o.id
                                WHERE op.product_id = '$item' 
                                AND o.status = 'PARTIAL-SHIPMENT'
                                AND o.client_id = '$client_id' ");
        $totalQtyOrders = 0;
        foreach($orders as $odr){
            $totalQtyOrders =  $odr->totalQuantity;
        }

        return $totalQtyOrders;
    }
}
