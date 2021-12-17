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
      $vouchers = \App\product::where('client_id',\Auth::user()->client_id)
                ->where('product_code','=',"$keyword")->count();
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

  public function CekQtyOrder(Request $request){
    $jumlah = $request->get('jumlah');
    $keyword = $request->get('product_id');
    $pr = \App\product::where('id',$keyword)->first();
    $stock = $pr->stock;
    if ($jumlah > $stock) {
        echo "taken";	
      }else{
        echo 'not_taken';
      }
  }

  public function cekForFinishOrder(Request $request){
      $orderId = $request->get('order_id');
      $order = \App\order_product::where('order_id','=',$orderId)
              ->whereRaw('deliveryQty < quantity')
              ->count();
      if ($order > 0) {
        echo "taken";	
      }else{
        echo "not_taken";
      }        
  }

  public function salesCheckDelivery(){
    $idSpv = \Auth::user()->id;
    $sales = \App\Spv_sales::with('sales')
                ->join('users', 'spv_sales.sls_id', '=', 'users.id')
                ->orderBy('users.name', 'ASC')
                ->where('spv_id',$idSpv)
                ->get();
    return $sales;

  }

  public function salesDelivery(Request $request){
    $_this = new self;
    $sales = $_this->salesCheckDelivery();

    $day = $request->get('day');
    $minus = 0 - (int)$day;
    $month = $request->get('month');
    $year = $request->get('year');
    $date_now = $request->get('date_now');

      foreach($sales as $sls){
        $user_id = $sls->id;
        $from = date('Y-m-01',strtotime($date_now));
        $order_minday = date('Y-m-d', strtotime("-$day day", strtotime($date_now)));
        $order_overday = \App\Order::where('user_id',$user_id)
                        ->whereNotNull('customer_id')
                        ->whereBetween('created_at', [$from,$order_minday])
                        ->where(function($qr) {
                            $qr->where('status','=','SUBMIT')
                            ->orWhere('status','=','PROCESS')
                            ->orWhere('status','=','PARTIAL-SHIPMENT');
                        })
                        ->orderBy('created_at','DESC')
                        ->get();
        [$cust_not_exists,$cust_exists] = \App\Http\Controllers\DashboardController::storeNotOrder($sls->sls_id,$month,$year,$date_now);
        
        echo'<tr>
            <td>'
                .$sls->sales->name.
            '</td> 
            <td>
                <a href="" data-toggle="modal" data-target="#notOrderModal'.$sls->sls_id.'">
                    <span class="badge bg-red">'.count($cust_not_exists).'</span>
                </a>
                <div class="modal fade" id="notOrderModal'.$sls->sls_id.'" tabindex="-1" role="dialog" style="display: none;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="defaultModalLabel">List Toko Pareto Belum Order</h4>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group">';
                                    if(count($cust_not_exists) > 0 ){
                                        $last_orders = Array(); 
                                        foreach ($cust_not_exists as $item){
                                            
                                            $last_order = \App\Http\Controllers\DashboardController::lastOrder($item->id,$date_now);
                                            array_push($last_orders, $last_order);
                                            
                                        }
                                       
                                            arsort($last_orders);
                                            $keys = array_keys($last_orders);
                                       
                                          foreach($keys as $key){
                                            $cust_id = $cust_not_exists[$key]->id;
                                            echo'<li class="list-group-item">
                                                <b>'.$cust_not_exists[$key]->store_code. '-' .$cust_not_exists[$key]->store_name.'</b>,';
                                                if($last_orders[$key] != ''){
                                                    echo'<span class="badge bg-cyan popoverData" id="popoverData" data-trigger="hover" data-container="body" data-placement="top" 
                                                    data-content="';if($last_orders[$key] == ''){ echo " ";}else{echo'Jumlah hari belum order';} echo'">'.$last_orders[$key].' Hari</span>'; 
                                                }   
                                                echo'<br><span>'.$cust_not_exists[$key]->address.'</span><br>';
                                                
                                                    [$visit_off,$visit_on] = \App\Http\Controllers\DashboardController::visitNoOrder($cust_id,$month,$year);
                                                    $visit = $visit_off + $visit_on;
                                               
                                                if($visit_off > 0 ){
                                                    
                                                    echo'<i class="fal fa-location-slash text-danger popoverData"  data-trigger="hover" data-container="body" data-placement="top" 
                                                    data-content="Checkout tanpa order & Off location."></i><b class="text-danger m-r-10">'.$visit_off.'</b>';
                                                    
                                                }
                                                if($visit_on > 0){
                                                    
                                                    echo'<i class="fal fa-location text-danger popoverData" data-trigger="hover" data-container="body" data-placement="top" 
                                                    data-content="Checkout tanpa order & On location."></i><b class="text-danger">'.$visit_on.'</b>';
                                                    
                                                }
                                            echo'</li>';
                                          }
                                    }else{
                                        echo'<li class="list-group-item border-0" style="color: #1A4066;border-bottom-right-radius:0;
                                        border-bottom-left-radius:0;"><b>Tidak ada data</b></li>';
                                    }  
                                echo'</ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <a href="" data-toggle="modal" data-target="#orderModal'.$sls->sls_id.'">
                    <span class="badge bg-green">'.count($cust_exists).'</span>
                </a>
                <div class="modal fade" id="orderModal'.$sls->sls_id.'" tabindex="-1" role="dialog" style="display: none;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="defaultModalLabel">List Toko Pareto Sudah Order</h4>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group">';
                                    if(count($cust_exists) > 0 ){
                                        $last_odrs = Array();
                                        foreach ($cust_exists as $it){
                                        
                                            $last_odr = \App\Http\Controllers\DashboardController::lastOrder($it->id,$date_now);
                                            array_push($last_odrs, $last_odr);
                                        
                                        }
                                        asort($last_odrs);
                                        $keys_exists = array_keys($last_odrs);
                                        
                                        foreach($keys_exists as $k){
                                            $cust_id_ex = $cust_exists[$k]->id;
                                            echo'<li class="list-group-item">
                                                <b>'.$cust_exists[$k]->store_code. '-'. $cust_exists[$k]->store_name.'</b>,';
                                                if($last_odrs[$k] != ''){
                                                    echo'<span class="badge bg-cyan popoverData" id="popoverData" data-trigger="hover" data-container="body" data-placement="top" 
                                                    data-content="';if($last_odrs[$k] == ''){echo"";}else{echo'Jumlah hari belum order';} echo'">'.$last_odrs[$k].' Hari</span>';
                                                }   
                                                echo'<br><span>'.$cust_exists[$k]->address.'</span><br>';
                                                
                                                    [$NoOdrVisit_off,$NoOdrVisit_on] = \App\Http\Controllers\DashboardController::visitNoOrder($cust_id_ex,$month,$year);
                                                    [$OdrVisit_off,$OdrVisit_on] = \App\Http\Controllers\DashboardController::visitOrder($cust_id_ex,$month,$year);
                                                    $visit_noorder = $NoOdrVisit_off + $NoOdrVisit_on;
                                                    $order_visit = $OdrVisit_off + $OdrVisit_on;
                                                
                                                if($NoOdrVisit_off > 0 ){
                                                    
                                                    echo'<i class="fal fa-location-slash text-danger popoverData"  
                                                    data-trigger="hover" data-container="body" data-placement="top" 
                                                    data-content="Checkout tanpa order & Off location."></i>
                                                    <b class="text-danger m-r-10">'.$NoOdrVisit_off.'</b>';
                                                    
                                                }
                                                if($NoOdrVisit_on > 0){
                                                    
                                                    echo'<i class="fal fa-location text-danger popoverData" 
                                                    data-trigger="hover" data-container="body" data-placement="top" 
                                                    data-content="Checkout tanpa order & On location."></i>
                                                    <b class="text-danger">'.$NoOdrVisit_on.'</b>';
                                                    
                                                }
                                                if($OdrVisit_off > 0 ){
                                                    echo'<br>
                                                    <i class="fal fa-location-slash popoverData" style="color:#3F51B5" 
                                                    data-trigger="hover" data-container="body" data-placement="top" 
                                                    data-content="Order off location."></i>
                                                    <b class="text-primary m-r-10" style="color:#3F51B5">'.$OdrVisit_off.'</b>';
                                                
                                                }

                                                if($OdrVisit_on > 0){
                                                    echo'<br>
                                                    <i class="fal fa-location popoverData"  style="color:#3F51B5"
                                                    data-trigger="hover" data-container="body" data-placement="top" 
                                                    data-content="Order on Location."></i>
                                                    <b class="text-primary" style="color:#3F51B5">'.$OdrVisit_on.'</b>';
                                                
                                                }
                                            echo'</li>';
                                         }
                                    }else{
                                        echo'<li class="list-group-item border-0" style="color: #1A4066;border-bottom-right-radius:0;
                                        border-bottom-left-radius:0;"><b>Tidak ada data</b></li>';
                                    }  
                                echo'</ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            
                <td>
                
                    <a href="" data-toggle="modal" data-target="#overdayModal'.$sls->sls_id.'">
                        <span class="badge bg-orange">'.count($order_overday).'</span>
                    </a>
                    <div class="modal fade" id="overdayModal'.$sls->sls_id.'" tabindex="-1" role="dialog" style="display: none;">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="defaultModalLabel">Pesanan Tidak Dikirim > '.$day.' Hari</h4>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group">';
                                        if(count($order_overday) > 0 ){
                                          $distances = Array();
                                          foreach ($order_overday as $over){
                                              
                                              $distance = \App\Http\Controllers\DashboardController::amountDayNotDelv($over->id,$date_now);
                                              array_push($distances, $distance);
                                             
                                          }
                                           
                                            arsort($distances);
                                            $keyDis = array_keys($distances);
                                          
                                            foreach ($keyDis as $ky){
                                                echo'<li class="list-group-item">
                                                    <b class="text-success">#'.$order_overday[$ky]->invoice_number.'<br>
                                                        <span class="badge bg-blue-grey" style="border-radius:10px;">'.$order_overday[$ky]->status.'</span>
                                                    </b>';
                                                    if($distances[$ky] != ''){
                                                        echo'<span class="badge bg-cyan popoverData" id="popoverData" data-trigger="hover" data-container="body" data-placement="top" 
                                                        data-content="';if($distances[$ky] == ''){echo'';}else{echo 'Jumlah hari belum kirim';}echo'">'.$distances[$ky].' Hari</span>'; 
                                                    }
                                                    echo'<br>
                                                    <b>';if($order_overday[$ky]->customer_id ){echo $order_overday[$ky]->customers->store_name;}else{echo"";}echo'</b>,
                                                    <br><span>';if($order_overday[$ky]->customer_id){echo $order_overday[$ky]->customers->address;}else{echo'';}echo'</span><br>
                                                </li>';
                                            }
                                          }else{
                                            echo'<li class="list-group-item border-0" style="color: #1A4066;border-bottom-right-radius:0;
                                            border-bottom-left-radius:0;"><b>Tidak ada data</b></li>';
                                        }  
                                    echo'</ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </td>
            
        </tr>';
      }
  }

}
