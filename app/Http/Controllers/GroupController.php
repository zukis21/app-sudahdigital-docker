<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class GroupController extends Controller
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
                if(Gate::allows('manage-group')) return $next($request);;
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
        $groups = \App\Group::with('item_active')
        ->where('client_id','=',auth()->user()->client_id)
        ->where('group_name','LIKE',"%$keyword%")
        ->where('status',strtoupper($status))->get();//->paginate(10);
        /*$products_list = \App\product::with('groups')
                ->doesntHave('groups')->get();*/    
        }
        else
            {
            $groups = \App\Group::with('item_active')
            ->where('client_id','=',auth()->user()->client_id)
            ->where('group_name','LIKE',"%$keyword%")->get();//->paginate(10);
            //$products_list = \App\product::with('groups')
                //->doesntHave('groups')->get();
            //dd($products_list);
            }
        return view('grouppaket.index', ['groups'=> $groups,'vendor'=>$vendor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendor)
    {   
        //$products = \App\product::with('groups')
                //->doesntHave('groups')->get();
        $products=\App\product::where('client_id','=',auth()->user()->client_id)
                ->where('status','=','PUBLISH')
                ->get();
        return view('grouppaket.create', ['products'=>$products, 'vendor'=>$vendor]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vendor)
    {
        $group = new \App\Group;
        $group->client_id = $request->get('client_id');
        $group->group_name= $request->get('group_name');
        //$new_group->group_image = $request->file('group_image');
        $group->display_name = $request->get('display_name');
        $image = $request->file('group_image');
        if($image){
          $image_path = $image->store('groups-images', 'public');
      
          $group->group_image = $image_path;
        }
        //$group = \App\Group::create($request->all());
        if($request->has('all_product')) {
            $group->group_cat=$request->get('all_product');
            $group->save();
        }
        else{
            $group->save();
            $products = $request->input('product_id', []);
            for ($product=0; $product < count($products); $product++) {
                if ($products[$product] != '') {
                    $group->products()->attach($products[$product]);
                }
            }
        }
        
        
        if($request->get('save_action') == 'SAVE'){
          return redirect()
                ->route('groups.create',[$vendor])
                ->with('status', 'Group paket successfully saved');
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
        $groups = \App\Group::with('products')->findOrfail($id);
        /*$products_list = \App\product::with('groups')
                ->doesntHave('groups')
                ->get();*/
        $client_prid = \Auth::user()->client_id;
        $products_list = \DB::select("SELECT * FROM products p WHERE p.client_id = $client_prid AND 
                                        p.status = 'PUBLISH' AND NOT EXISTS
                                        (
                                            SELECT * FROM  group_product g
                                            WHERE   g.product_id = p.id
                                            AND g.group_id = '$id'
                                        )
                                    ");
        return view('grouppaket.edit', ['groups' => $groups,'products_list'=>$products_list,'vendor'=>$vendor]);
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
        if($request->get('save_action') == 'ADD'){
            //$group= $request->input('group_id');
            $products = $request->input('product_id', []);
            for ($product=0; $product < count($products); $product++) {
                if ($products[$product] != '') {
                    $cek_exist = \App\group_product::where('product_id',$products[$product])
                                ->where('group_id',$id)->first();
                    //$count =  $cek_exist->count();            
                        if($cek_exist){
                            $new_group_product = \App\group_product::findOrFail($cek_exist->id);
                            $new_group_product->status ='ACTIVE';
                            $new_group_product->save();
                        }
                        else{
                            $new_group_product = new \App\group_product;
                            $new_group_product->group_id =  $id;
                            $new_group_product->product_id = $products[$product];
                            $new_group_product->save();
                        }
                }
            }
            return redirect()->route('groups.edit', [$vendor,\Crypt::encrypt($id)])->with('status',
            'Item product successfully add');
        }
        else if($request->get('save_action') == 'DELETE_ITEM')
        {
            $del_id = $request->input('del_id');
            //$cek_id = \App\group_product::findOrfail($del_id);
            $cek_exist = \App\order_product::where('group_id','=',$id)->count();
            if( $cek_exist > 0){
                return redirect()->route('groups.edit', [$id])->with('error',
                'Can\'t delete item, this group already exist in order');
            }else{
                $group_paket = \App\group_product::findOrFail($del_id);
                $group_paket->delete();
                return redirect()->route('groups.edit', [$vendor,\Crypt::encrypt($id)])->with('status',
                'Item product successfully delete');
            }
        }
        else if($request->get('save_action') == 'DEACTIVATE')
        {
            $deactive_id = $request->input('deactivate_id');
            $group_product = \App\group_product::findOrFail($deactive_id);
            $group_product->status = 'INACTIVE';
            $group_product->save();
            return redirect()->route('groups.edit', [$vendor,\Crypt::encrypt($id)])->with('status',
            'Item product successfully deactivate');
        }
        else if($request->get('save_action') == 'ACTIVATE')
        {
            $active_id = $request->input('activate_id');
            $group_product = \App\group_product::findOrFail($active_id);
            /*$cek = \App\group_product::where('product_id','=',$group_product->product_id)
                    ->where('status','=','ACTIVE')->count();
            if($cek > 0){
                return redirect()->route('groups.edit', [$id])->with('error',
                'Can\'t activate item, this item already exist in other group');
            }
            else{
            */
            $group_product->status = 'ACTIVE';
            $group_product->save();
            return redirect()->route('groups.edit', [$vendor,\Crypt::encrypt($id)])->with('status',
            'Item product successfully activate');
            
        }else{
            $group = \App\Group::findOrFail($id);
            $group->group_name = $request->input('group_name');
            $group->display_name = $request->input('display_name');
            $new_image = $request->file('group_image');
            if($new_image){
                if($group->group_image && file_exists(storage_path('app/public/'.$group->group_image))){
                \Storage::delete('public/'. $group->group_image);
                }
            $new_image_path = $new_image->store('groups-images', 'public');
            $group->group_image = $new_image_path;
            }

            if($request->has('all_product')) {
                $group->save();
            }
            else{
                $group->group_cat=NULL;
                $group->save();
                $products = $request->input('product_id', []);
                for ($product=0; $product < count($products); $product++) {
                    if ($products[$product] != '') {
                        $group->products()->attach($products[$product]);
                    }
                }
            }
            //$group->save();
            return redirect()->route('groups.edit', [$vendor,\Crypt::encrypt($id)])->with('status_group',
            'Group successfully update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vendor,$id)
    {
        
        //$cek_id = \App\group_product::findOrfail($del_id);
        $cek_exist = \App\order_product::where('group_id','=',$id)->count();
        //dd($cek_exist);
        if( $cek_exist > 0){
            return redirect()->route('groups.index',[$vendor])->with('error',
            'Can\'t delete, this group already exist in order');
        }else{
            $group = \App\Group::findOrFail($id);
            $group->delete();
            $group->products()->detach();
            return redirect()->route('groups.index',[$vendor])->with('status',
            'Group successfully delete');
        }
    }

    public function update_status(Request $request, $vendor){
        if($request->get('save_action') == 'ACTIVATE')
        {
            $active_id = $request->input('activate_id');
            $group_product = \App\group_product::where('group_id',$active_id)->get();
            foreach($group_product as $item){
                $cek = \App\group_product::where('product_id','=',$item->product_id)
                        ->where('group_id',$active_id)
                        ->where('status','=','ACTIVE')->count();
                        //dd($cek);
                if($cek == 0 ){
                    $group_product = \App\group_product::where('id',$item->id);
                        $group_product->update([
                            'status' => 'ACTIVE'
                        ]);
                }
            }
            $group = \App\Group::findOrFail($active_id);
            $group->status='ACTIVE';
            $group->save();
            
            return redirect()->route('groups.index',[$vendor])->with('status',
            'Group successfully activate');
        }else{
            $deactive_id = $request->input('deactivate_id');
            $group = \App\Group::findOrFail($deactive_id);
            $group->status='INACTIVE';
            $group->save();
            if($group->save()){
                $group_product = \App\group_product::where('group_id',$deactive_id);
                $group_product->update([
                    'status' => 'INACTIVE'
                ]);
                
            }
            return redirect()->route('groups.index',[$vendor])->with('status_group',
            'Group successfully deactivate');
        }
        
    }
    

    /*public function add_item(Request $request)
    //{
        $group = \App\Group::create($request->all());
        $group= $request->input('group_id');
        $products = $request->input('product_id', []);
        for ($product=0; $product < count($products); $product++) {
            if ($products[$product] != '') {
                $cek_exist = \App\group_product::where('product_id',$products[$product])
                            ->where('group_id',$group)->first();
                //$count =  $cek_exist->count();            
                    if($cek_exist){
                        $new_group_product = \App\group_product::findOrFail($cek_exist->id);
                        $new_group_product->status ='ACTIVE';
                        $new_group_product->save();
                    }
                    else{
                        $new_group_product = new \App\group_product;
                        $new_group_product->group_id =  $group;
                        $new_group_product->product_id = $products[$product];
                        $new_group_product->save();
                    }
            }
        }
        $groups = \App\Group::with('products')->findOrfail($group);
        $products_list = \App\product::with('groups')
                ->doesntHave('groups')->get();
        return view('grouppaket.edit', ['groups' => $groups,'products_list'=>$products_list])
            ->with('status', 'Item group successfully add');
    }*/

    public function ajaxSearch(Request $request){
        $keyword = $request->get('q');
        $groups = \App\Group::where('name','LIKE',"%$keyword%")->get();
        return $groups;
    }

    
}
