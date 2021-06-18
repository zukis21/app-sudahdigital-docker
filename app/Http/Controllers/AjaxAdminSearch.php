<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxAdminSearch extends Controller
{
    public function email_search(Request $request){
        $keyword = $request->get('email');
        $users = \App\User::where('email','=',"$keyword")->count();
        if ($users > 0) {
            echo "taken";	
          }else{
            echo 'not_taken';
          }
    }

    public function email_so_search(Request $request){
      $keyword = $request->get('email');
      $users = \App\B2b_Client::where('email','=',"$keyword")->count();
      if ($users > 0) {
          echo "taken";	
        }else{
          echo 'not_taken';
        }
  }

    public function CitySearch(Request $request){
      $keyword = $request->get('q');
      $cities = \App\City::where('city_name','LIKE',"%$keyword%")->get();
      return $cities;
    }

    public function post_sortable(Request $request){
      $banners= \App\Banner::all();

      foreach ($banners as $ban) {
          foreach ($request->posit as $order) {
              if ($order['id'] == $ban->id) {
                  $ban->update(['position' => $order['position']]);
              }
          }
      }
      
      return response('Update Successfully.', 200);
    }

    public function CodeProductSearch(Request $request){
      $keyword = $request->get('code');
      $vouchers = \App\product::where('product_code','=',"$keyword")->count();
      if ($vouchers > 0) {
          echo "taken";	
        }else{
          echo 'not_taken';
        }
    }

    public function CategorySearch(Request $request){
      $keyword = $request->get('q');
      $categories = \App\Category::where('client_id','=',auth()->user()->client_id)
                   ->where('name','LIKE',"%$keyword%")->get();
      return $categories;
  }

  public function OnOff_stock(Request $request){
    $status = $request->get('status');
    $product = \DB::table('product_stock_status')
              ->where('client_id','=',auth()->user()->client_id)
              ->update(array('stock_status'=>$status));
  }
  
  public function GroupNameSearch(Request $request){
    $keyword = $request->get('code');
    $groups = \App\Group::where('client_id','=',auth()->user()->client_id)
            ->where('group_name','=',"$keyword")->count();
    if ($groups > 0) {
        echo "taken";	
      }else{
        echo 'not_taken';
      }
  }

  public function PaketNameSearch(Request $request){
    $keyword = $request->get('code');
    $pakets = \App\Paket::where('client_id','=',auth()->user()->client_id)
              ->where('paket_name','=',"$keyword")->count();
    if ($pakets > 0) {
        echo "taken";	
      }else{
        echo 'not_taken';
      }
  }

  public function CustomerajaxUserSearch(Request $request){
    $keyword = $request->get('q');
    $user = \App\User::where('roles','=','SALES')
          ->where('client_id','=',auth()->user()->client_id)
          ->where('name','LIKE',"%$keyword%")->get();
    return $user;
  }

  public function CustomerajaxCitySearch(Request $request){
    $keyword = $request->get('q');
    $cities = \App\City::where('type','=','Kota')
            ->where('city_name','LIKE',"%$keyword%")
            ->orderBy('display_order','ASC')
            ->orderBy('postal_code','ASC')
            ->get();
    return $cities;
  }

  public function CustomerCodeSearch(Request $request){
    $keyword = $request->get('code');
    $cust = \App\Customer::where('client_id','=',auth()->user()->client_id)
            ->where('store_code','=',"$keyword")->count();
    if ($cust > 0) {
        echo "taken";	
      }else{
        echo 'not_taken';
      }
  }

  public function ClientsoCodeSearch(Request $request){
    $keyword = $request->get('code');
    $key_slug = \Str::slug($keyword,'-');
    $cust = \App\B2b_Client::where('client_slug','=',"$key_slug")->count();
    if ($cust > 0) {
        echo "taken";	
      }else{
        echo 'not_taken';
      }
  }
}
