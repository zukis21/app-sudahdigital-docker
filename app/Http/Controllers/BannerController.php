<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BannerController extends Controller
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
                if(Gate::allows('manage-banner')) return $next($request);
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
        $banner = \App\Banner::orderBy('position', 'ASC')
        ->where('client_id','=',auth()->user()->client_id)
        ->get();//paginate(10);\App\Banner::orderBy('id', 'DESC')->first();
        $keyword = $request->get('name');
        if($keyword){
            $banner = \App\Banner::where('name','LIKE',"%$keyword%")
            ->where('client_id','=',auth()->user()->client_id)
            ->get();//paginate(10);
        }
        return view('banner.index', ['banner'=>$banner,'vendor'=>$vendor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendor)
    {
        return view('banner.create',['vendor'=>$vendor]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vendor)
    {
        \Validator::make($request->all(), [
            "image" => "required|image|mimes:jpeg,png,jpg|max:500"
        ])->validate();
        $max_position = \App\Banner::where('client_id','=',$request->get('client_id'))
                      ->max('position');
                      //->orderBy('position','DESC')
                      //->value('position');
        //dd($max_position);
        
        $name = $request->get('name');
        $newBanner = new \App\Banner;
        $newBanner->name = $name;
        if($request->file('image')){
            $image_path = $request->file('image')->store('banner_images','public');
            $newBanner->image = $image_path;
        }
        $newBanner->client_id = $request->get('client_id');
        
        if($max_position == null){
            $newBanner->position = 1;
        }
        else{
            $newBanner->position = $max_position + 1;
        }
        
        $newBanner->create_by = \Auth::user()->id;
        $newBanner->save();
        
        //$newCategory->slug = \Str::slug($name,'-');
        
        
        return redirect()->route('banner.create',[$vendor])->with('status','Banner Slide Succesfully Created');
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
        $banner_edit = \App\Banner::findOrFail($id);
        return view('banner.edit',['banner_edit'=>$banner_edit,'vendor'=>$vendor]);
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

        $name = $request->get('name');
        //$slug = $request->get('slug');
        $banner = \App\Banner::findOrFail($id);
        $banner->name = $name;
        //$category->slug = $slug;

        if($request->file('image')){
            \Validator::make($request->all(), [
                "image" => "required|image|mimes:jpeg,png,jpg|max:500"
            ])->validate();
            if($banner->image && file_exists(storage_path('app/public/' .$banner->image))){
            \Storage::delete('public/' . $banner->name);
            }
            $new_image = $request->file('image')->store('banner_images','public');
            $banner->image = $new_image;
        }
        $banner->update_by = \Auth::user()->id;
        //$category->slug = \Str::slug($name);
        $banner->save();
            return redirect()->route('banner.edit', [$vendor,\Crypt::encrypt($id)])->with('status','Banner Slide Succsessfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vendor, $id)
    {
        $banner = \App\Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('banner.index',[$vendor])
        ->with('status', 'Banner Slide successfully moved to trash');
    }

    public function trash($vendor){
        $deleted_banner = \App\Banner::onlyTrashed()
        ->where('client_id','=',auth()->user()->client_id)
        ->get();//paginate(10);

        return view('banner.trash', ['banner' => $deleted_banner,'vendor'=>$vendor]);
    }

    public function restore($vendor, $id){

        $banner = \App\Banner::withTrashed()->findOrFail($id);
        if($banner->trashed()){
        $banner->restore();
        } 
        else 
        {
        return redirect()->route('banner.index',[$vendor])
        ->with('status', 'Banner Slide is not in trash');
        }
        return redirect()->route('banner.index',[$vendor])
        ->with('status', 'Banner Slide successfully restored');
    }

    public function deletePermanent($vendor, $id){

        $banner = \App\Banner::withTrashed()->findOrFail($id);
        if(!$banner->trashed()){
        return redirect()->route('banner.index',[$vendor])
        ->with('status', 'Can not delete permanent active banner slide');
        } else {
        $banner->forceDelete();
        return redirect()->route('banner.index',[$vendor])
        ->with('status', 'Banner Slide permanently deleted');

            }
    }
    
}
