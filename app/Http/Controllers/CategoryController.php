<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
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
                if(Gate::allows('manage-categories')) return $next($request);
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
        $categories = \App\Category::where('client_id','=',auth()->user()->client_id)
                    ->whereNull('parent_id')
                    ->orderBy('name','ASC')
                    ->get();//paginate(10);
        $keyword = $request->get('name');
        if($keyword){
            $categories = \App\Category::where('name','LIKE',"%$keyword%")
                    ->where('client_id','=',auth()->user()->client_id)
                    ->whereNull('parent_id')
                    ->orderBy('name','ASC')
                    ->get();//paginate(10);
        }
        return view('category.index', ['categories'=>$categories, 'vendor'=>$vendor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendor)
    {
        $categories = \App\Category::where('client_id','=',auth()->user()->client_id)
                    ->whereNull('parent_id')
                    ->orderBy('name','ASC')
                    ->get();
        return view('category.create',['vendor'=>$vendor,'categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vendor)
    {
        $name = $request->get('name');
        $newCategory = new \App\Category;
        
        $newCategory->client_id = $request->get('client_id');
        $newCategory->name = $name;
        if($request->file('image')){
            $image_path = $request->file('image')->store('category_images','public');
            $newCategory->image_category = $image_path;
        }
        $newCategory->create_by = \Auth::user()->id;
        
        if($request->get('parent_id') != ''){
            $newCategory->parent_id = $request->get('parent_id');
            $categories = \App\Category::findOrFail($request->get('parent_id'));
            $newCategory->slug = $categories->id.'-'.\Str::slug($categories->name,'-').'-'.\Str::slug($name,'-');
            //dd($categories);
        }
        else{
            $newCategory->parent_id = null;
            $newCategory->slug = \Str::slug($name,'-');
        }
        $newCategory->save();
        return redirect()->route('categories.create',[$vendor])->with('status','Category Succesfully Created'); 
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
        $cat_edit = \App\Category::findOrFail($id);
        $categories = \App\Category::whereNull('parent_id')
                    ->where('id', '!=', $cat_edit->id)->orderby('name', 'asc')->get();
        return view('category.edit',['cat_edit'=>$cat_edit,'vendor'=>$vendor,'categories'=>$categories]);
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
        $category = \App\Category::findOrFail($id);
        $category->name = $name;
        //$category->slug = $slug;

        if($request->file('image')){
            \Validator::make($request->all(), [
                "image" => "required|image|mimes:jpeg,png,jpg|max:1000"
            ])->validate();
            if($category->image_category && file_exists(storage_path('app/public/' .$category->image_category))){
            \Storage::delete('public/' . $category->name);
            }
            $new_image = $request->file('image')->store('category_images','public');
            $category->image_category = $new_image;
        }

        if($request->has('parent_id')){
            $category->parent_id = $request->get('parent_id');
            $categories = \App\Category::findOrFail($request->get('parent_id'));
            $category->slug = $categories->id.'-'.\Str::slug($categories->name,'-').'-'.\Str::slug($name,'-');
        }
        else{
            $category->parent_id = null;
            $category->slug = \Str::slug($name,'-');
        }
            
            $category->update_by = \Auth::user()->id;
            
            $category->save();
            return redirect()->route('categories.edit', [$vendor,\Crypt::encrypt($id)])->with('status','Category Succsessfully Update');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vendor, $id)
    {
        $category = \App\Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index',[$vendor])
        ->with('status', 'Category successfully moved to trash');
    }

    public function trash($vendor){
        $deleted_category = \App\Category::onlyTrashed()
        ->where('client_id','=',auth()->user()->client_id)
        ->whereNull('parent_id')
                    ->orderBy('name','ASC')
        ->get();//paginate(10);

        return view('category.trash', ['categories' => $deleted_category,'vendor'=>$vendor]);
    }

    public function restore($vendor, $id){

        $category = \App\Category::withTrashed()->findOrFail($id);
        if($category->trashed()){
        $category->restore();
        } 
        else 
        {
        return redirect()->route('categories.index',[$vendor])
        ->with('status', 'Category is not in trash');
        }
        return redirect()->route('categories.index',[$vendor])
        ->with('status', 'Category successfully restored');
    }

    public function deletePermanent($vendor, $id){

        /*$category = \App\Category::withTrashed()->findOrFail($id);
        if(!$category->trashed()){
        return redirect()->route('categories.trash',[$vendor])
        ->with('status', 'Can not delete permanent active category');
        } else {
        $category->forceDelete();
        return redirect()->route('categories.trash',[$vendor])
        ->with('status', 'Category permanently deleted');
        }*/

        $category = \App\Category::findOrFail($id);
        if(count($category->subcategory))
            {
                $subcategories = $category->subcategory;
                foreach($subcategories as $cat)
                {
                    $cat = \App\Category::findOrFail($cat->id);
                    $cat->parent_id = null;
                    $cat->save();
                }
            }
        $category->forceDelete();
        return redirect()->route('categories.index',[$vendor])
        ->with('status', 'Category successfully deleted permanently');

        
    }

    public function export($vendor) {
        return Excel::download( new CategoryExport(), 'Categories.xlsx') ;
    }
            
}
