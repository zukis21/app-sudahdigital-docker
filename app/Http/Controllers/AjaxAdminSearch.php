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
      $users = \App\B2b_client::where('email','=',"$keyword")->count();
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

    public function post_sortable_pareto(Request $request){
      $pareto= \App\CatPareto::all();

      foreach ($pareto as $ban) {
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
    $cust = \App\B2b_client::where('client_slug','=',"$key_slug")->count();
    if ($cust > 0) {
        echo "taken";	
      }else{
        echo 'not_taken';
      }
  }

  public function TypeCustomerSearch(Request $request){
    if ($request->has('old_name')){
      $key_old = $request->get('old_name');
      $keyword = $request->get('name');
      $cust = \App\TypeCustomer::where('id','!=',$key_old)
              ->where('client_id','=',auth()->user()->client_id)
              ->where('name','=',$keyword)->count();
      if ($cust > 0) {
          echo "taken";	
        }else{
          echo 'not_taken';
        }
    }else{
      $keyword = $request->get('name');
      $cust = \App\TypeCustomer::where('name','=',$keyword)
            ->where('client_id','=',auth()->user()->client_id)
            ->count();
      if ($cust > 0) {
          echo "taken";	
        }else{
          echo 'not_taken';
        }
    }
     //$cust = \App\TypeCustomer::whereRaw("BINARY 'name'= ?",[$keyword])->count();
  }

  public function ParetoCodeSearch(Request $request){
    if ($request->has('old_code')){
      $key_old = $request->get('old_code');
      $keyword = $request->get('code');
      $pareto = \App\CatPareto::where('id','!=',$key_old)
              ->where('client_id','=',auth()->user()->client_id)
              ->where('pareto_code','=',"$keyword")->count();
      if ($pareto > 0) {
          echo "taken";	
      }else{
        echo 'not_taken';
      }
    }else{
      $keyword = $request->get('code');
      $pareto = \App\CatPareto::where('client_id','=',auth()->user()->client_id)
              ->where('pareto_code','=',"$keyword")->count();
      if ($pareto > 0) {
          echo "taken";	
      }else{
        echo 'not_taken';
      }
    }
    
  }

  public function UserExistSearch(Request $request){
    $user_id = $request->get('user_id');
    $date = $request->get('date').'-01';
    $cust = \App\Sales_Targets::where('user_id','=',$user_id)
            ->where('period','=',$date)->count();
    if ($cust > 0) {
        echo "taken";	
      }else{
        echo 'not_taken';
      }
  }

  public function DateExistSearch(Request $request){
    $date = $request->get('date').'-01';
    $cust = \App\Store_Targets::where('client_id','=',auth()->user()->client_id)
          ->where('period','=',$date)->count();
    if ($cust > 0) {
        echo "taken";	
      }else{
        echo 'not_taken';
      }
  }

  public function UserExistEditSearch(Request $request){
    $user_id = $request->get('user_id');
    $date = $request->get('date').'-01';
    $p_dt = $request->get('p_dt');
    $cust = \App\Sales_Targets::where('user_id','=',$user_id)
            ->where('period','!=',$p_dt)
            ->where('period','=',$date)
            ->count();
    if ($cust > 0) {
        echo "taken";	
      }else{
        echo 'not_taken';
      }
  }

  public function WorkPlanExistSearch(Request $request){
    $date = $request->get('date').'-01';
    $client_id = $request->get('client_id');
    $plan = \App\WorkPlan::where('client_id','=',$client_id)
            ->where('work_period','=',$date)->count();
    if ($plan > 0) {
        echo "taken";	
      }else{
        echo 'not_taken';
      }
  }

  public function post_sortable_reasons(Request $request){
    $reasons= \App\ReasonsCheckout::all();

    foreach ($reasons as $ban) {
        foreach ($request->posit as $order) {
            if ($order['id'] == $ban->id) {
                $ban->update(['position' => $order['position']]);
            }
        }
    }
  }
}
