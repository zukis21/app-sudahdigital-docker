<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VolumeDiscountProductImport;

class volumeDiscountController extends Controller
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
                if(Gate::allows('volume-discount')) return $next($request);;
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index(Request $request, $vendor){
        $vDiscounts = \App\VolumeDiscount::where('client_id','=',auth()->user()->client_id)
                    ->get();
            
        return view('volumediscount.index', ['vDiscounts'=>$vDiscounts,'vendor'=>$vendor]);
    }

    public function create($vendor)
    {
        $vDiscounts = \App\VolumeDiscount::where('client_id','=',\Auth::user()->client_id)
                    ->orderBy('min_order','DESC')->first();
        return view('volumediscount.create',['vDiscounts'=>$vDiscounts,'vendor'=>$vendor]);
    }

    public function store(Request $request, $vendor){
        $new_volume_discount = new \App\VolumeDiscount();
        $new_volume_discount->client_id = \Auth::user()->client_id;
        $new_volume_discount->name = $request->get('name');
        $new_volume_discount->type = $request->get('type');
        $new_volume_discount->min_order = $request->get('min_order');
        if($request->get('hideMaxOrder') != ''){
            $new_volume_discount->max_order = $request->get('max_order');
        }
        $new_volume_discount->status = 'INACTIVE';
        $new_volume_discount->save();
        
        return redirect()
                ->route('vDiscount.create',[$vendor])
                ->with('status', 'Discount successfully created');
    }

    public function createEditProduct($vendor, $id){
        $get_id = \Crypt::decrypt($id);
        $vDiscounts = \App\VolumeDiscount::findOrfail($get_id);

        $countInverse = \App\VolumeDiscount::where('client_id',\Auth::user()->client_id)
                        ->where('id','!=',$get_id)->count();

        if($vDiscounts->max_order > 0){
            $vDiscMin = \App\VolumeDiscount::where('client_id',\Auth::user()->client_id)
                    ->where('min_order','>',$vDiscounts->max_order)
                    ->orderBy('min_order','ASC')->first();
        }else{
            $vDiscMin = NULL;
        }
        

        $vDiscMax = \App\VolumeDiscount::where('client_id',\Auth::user()->client_id)
                    ->where('max_order','<',$vDiscounts->min_order)
                    ->orderBy('max_order','DESC')->first();

        $details_vDiscounts = \App\VolumeDiscountProduct::where('volume_id',$get_id)
                            ->get();

        return view('volumediscount.edit',
                    [
                        'vDiscounts'=>$vDiscounts,
                         'vDiscMin'=>$vDiscMin,
                         'vDiscMax'=>$vDiscMax,
                         'vendor'=>$vendor,
                         '$details_vDiscounts'=>$details_vDiscounts,
                         'countInverse'=>$countInverse,
                    ]);
    }

    public function itemImport(Request $request, $vendor){
        \Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx"
        ])->validate();

        $id = $request->get('volume_id');
        
        $data = Excel::import(new VolumeDiscountProductImport($id), request()->file('file'));
        if($data){
            $cekItem = \App\VolumeDiscountProduct::where('volume_id', $id)
                        ->first();
            if($cekItem){
                $vDiscount = \App\VolumeDiscount::findOrFail($id);
                $vDiscount->status = 'ACTIVE';
                $vDiscount->save();
            }
            return redirect()->back()->with('status', 'File successfully upload');
        }
        
    }

    public function deleteItem($vendor,$itemId,$volume_id){
        $item = \App\VolumeDiscountProduct::findOrFail($itemId);
        $item->forceDelete();
        
        $cekItem = \App\VolumeDiscountProduct::where('volume_id',$volume_id)
                ->first();
        if(!$cekItem){
            $vDiscount = \App\VolumeDiscount::findOrFail($volume_id);
            $vDiscount->status = 'INACTIVE';
            $vDiscount->save();
        }
       
        return redirect()->back()->with('status', 'Item successfully deleted!');
    }

    public function update(Request $request, $vendor, $id){
        $volume_discount = \App\VolumeDiscount::findOrFail($id);
        $volume_discount->client_id = \Auth::user()->client_id;
        $volume_discount->name = $request->get('name');
        $volume_discount->type = $request->get('type');
        $volume_discount->min_order = $request->get('min_order');
        if($request->get('hideMaxOrder') != ''){
            $volume_discount->max_order = $request->get('max_order');
        }else{
            $volume_discount->max_order = 0;
        }
        $volume_discount->save();

        return redirect()
                ->back()
                ->with('status', 'Discount successfully update');
    }

    public function deleteAllItem($vendor,$volumeId){
        $item = \App\VolumeDiscountProduct::where('volume_id',$volumeId)->get()->each->delete();
        if($item){
            $vDiscount = \App\VolumeDiscount::findOrFail($volumeId);
            $vDiscount->status = 'INACTIVE';
            $vDiscount->save();
        }
        return redirect()->back()->with('status', 'All item successfully deleted!');
    }

    public function editStatus($vendor, $id, $status){
        $volume_discount = \App\VolumeDiscount::findOrFail($id);
        $volume_discount->status = $status;
        $volume_discount->save();
        return redirect()->back()->with('status', 'Status changed successfully!');
    }
}
