@extends('customer.layouts.template-nocart')
@section('title') Dashboard @endsection
@section('content')
<style>
  .highcharts-credits {
    display: none !important;
  }

  .height-chart{
    height: 350px;
  }

  .popover{
    background: #ececec;
  }

  .progress {
    overflow: visible;
    
  }

  .progress-bar {
      overflow: visible;
      border-radius: 5px;
  }

  /*img {
      height: 2vh;
      margin-left: auto;
      margin-bottom: 2.9vh
  }*/

  .progress-icon{
    margin-left:auto;
    border-radius:50%;
    width:19px;
    height:19px;
    line-height:19px;
    margin-right:-1px;
  }

  /* Tabs*/
  section {
      padding: 15 0;
  }

  section .section-title {
      text-align: center;
      color: #ffff;
      margin-bottom: 50px;
      text-transform: uppercase;
  }

  #tabs{
    background: #ffffff;
    color: #1A4066;
  }

  #tabs .tab-pane{
    font-weight: normal;
    color: #1A4066;
    height:300px;
    overflow-y:auto;
  }

  .last-order-info{
    position:absolute;
    top:1; 
    right:5px;
  }
  /*.style-7::-webkit-scrollbar
  {
    width: 5px;
    background-color: #eee;
  }

  .style-7::-webkit-scrollbar-thumb
  {
    border-radius: 10px;
    background-image: -webkit-gradient(linear,
                      left bottom,
                      left top,
                      color-stop(0.44, rgb(194, 198, 206)),
                      color-stop(0.72, rgb(180, 186, 192)),
                      color-stop(0.86, rgb(169, 171, 179)));
  }*/

   #tabs .nav-item{
    font-weight: 600;
  }

  #tabs .nav-item{
    border-top-right-radius:20px;
    border-top-left-radius:20px;
    background-color: #eee;
  }

  #tabs .nav-link{
    border-top-right-radius:20px;
    border-top-left-radius:20px;
  }

  #tabs .nav-link i{
    color: #1A4066;
    /*background-color: #1A4066;*/
  }

  #tabs .nav-tabs {
    background-color: #ffff;
    border-top-right-radius:20px;
    border-top-left-radius:20px;
    
  }

  #tabs .nav-link.active {
      background-color: #1A4066;
      border: 1px solid transparent;
      border-top-right-radius:20px;
      border-top-left-radius:20px;
      color: #eee;
      font-weight: bold;
  }

  #tabs .nav-link.active  i{
    
    color: #ffff;
    /*background-color: #ffff;*/
  }

  #tabs .nav-fill > a {
    border-top-right-radius:20px;
    border-top-left-radius:20px;
  }

  #tabs .tab-content {
    background-color: #fff;
    padding : 5px 15px;
    box-shadow: 0 0.3rem 1rem rgba(0, 0, 0, 0.3);
    font-weight: normal;
  }

  #tabs .tab-pane{
    font-size: 16px;
  }

  #tabs .img-icon{
    width:20px;
    height:20px;
  }

  @media (max-width : 425px){
    .last-order-info{
      right:2px;
    }
  }

  @media (max-width : 425px){
    #tabs{
      font-size:14px;
    }
    
    #tabs i{
      font-size:12px;
    }

    #tabs .list-group {
      font-size:13px;
    }

    .dashboard i{
      font-size:12px;
    }

    .dashboard-tittle{
      font-size:14px;
    }
  }

  @media (max-width : 338px){
    #tabs{
      font-size:12px;
    }

    #tabs i{
      font-size:12px;
    }

    #tabs .list-group {
      font-size:12px;
    }
  }
</style>

    <div class="container pb-4" style="">
        <div class="row align-middle">
            <div class="col-sm-12 col-md-12">
                <nav aria-label="breadcrumb" class="float-right mt-0">
                    <ol class="breadcrumb px-0 button_breadcrumb">
                        <li id="prf-brd" class="breadcrumb-pesan-item active mt-2" aria-current="page">Dashboard</li>&nbsp;
                        <li class="breadcrumb-pesan-item" style="color: #000!important;"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-src-order col-12" style="z-index: 2;">
                <div class="welcome">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="content px-4">
                            @if($target)
                            <h6 class="mx-2"><b>{{Auth::user()->name}}<span class="mx-3 lead">|</span>   {{date('F'.' Y', strtotime(\Carbon\Carbon::now()))}}</b></h6>
                            @else
                            <h6>
                                Dashboard {{Auth::user()->name}} {{date('F'.' Y', strtotime(\Carbon\Carbon::now()))}}
                                Tidak Dapat Ditampilkan Karena Target Belum Dibuat.
                            </h6>   
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if($target)
          @php
            function singkat_angka($n, $presisi=1) {
              if ($n < 900) {
                $format_angka = number_format($n, $presisi);
                $simbol = '';
              } else if ($n < 900000) {
                $format_angka = number_format($n / 1000, $presisi);
                $simbol = ' Rb';
              } else if ($n < 900000000) {
                $format_angka = number_format($n / 1000000, $presisi);
                $simbol = ' Jt';
              } else if ($n < 900000000000) {
                $format_angka = number_format($n / 1000000000, $presisi);
                $simbol = ' M';
              } else {
                $format_angka = number_format($n / 1000000000000, $presisi);
                $simbol = ' T';
              }
            
              if ( $presisi > 0 ) {
                $pisah = '.' . str_repeat( '0', $presisi );
                $format_angka = str_replace( $pisah, '', $format_angka );
              }
              
              return $format_angka . $simbol;
            }

            /*if ($target){
              $sisa = $target->target_values - $target->target_achievement;
            }*/

            $total_ach_ppn = 0;
            foreach($order_ach as $p){
              $total_ach_ppn += $p->total_price;
            }

            if($target->ppn == 1){
              $total_ach = $total_ach_ppn/1.1;
            }else{
              $total_ach = $total_ach_ppn;
            }
            
            //return $total_ach;
            //echo number_format($total_ach);
          @endphp
          <div class="row justify-content-center" style="">
            <!--
            <div class="col-12" style="z-index: 2;">
                <section class='statis text-center'>
                    <div class="container">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="box bg-primary">
                            <i class="fal fa-store"></i>
                            <h3>{{$cust_total}}</h3>
                            <p class="lead">Jumlah Toko</p>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="box bg-success">
                            <i class="fal fa-shopping-cart" aria-hidden="true"></i>
                            <h3>{{$order}}</h3>
                            <p class="lead">Toko Sudah Order</p>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="box bg-danger">
                            <i class="fal fa-shopping-cart" aria-hidden="true"></i>
                            <i class="fas fa-slash fa-2x "></i>
                            <h3>{{$cust_total - $order}}</h3>
                            <p class="lead">Toko Belum Order</p>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="box bg-primary">
                            <i class="fal fa-bullseye-arrow"></i>
                            <h3>{{$target ? number_format($target->target_values) : '0'}}</h3>
                            <p class="lead">Target (Rp)</p>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="box bg-success">
                            <i class="fal fa-trophy" aria-hidden="true"></i> 
                            <h3>
                              {{number_format($total_ach)}}
                              
                              
                            </h3>
                            <p class="lead">Pencapaian (Rp)</p>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="box bg-danger">
                            <i class="fal fa-bullseye-arrow"></i>
                            <i class="fas fa-slash fa-2x "></i>
                            <h3>
                              @php
                                if ($target){
                                  $sisa = $target->target_values - $total_ach;
                                }
                              @endphp  
                              {{$target ? number_format($sisa) : '0'}}
                            </h3>
                            <p class="lead">Target Belum Capai (Rp)</p>
                          </div>
                        </div>
                      </div>
                    </div>
                </section>
            </div>
            -->
            
            <div class="col-12 mb-3" style="z-index: 2;">
              <section class="info-box">
                <div class="container">
                  <div class="row">

                    <!--total toko order-->
                    <div class="col-md-4 mb-4" data-aos="zoom-in">
                      <div class="box-blue">
                        <i class="fal fa-shopping-cart fa-fw bg-white" aria-hidden="true"></i>
                        <div class="info">
                          <div class="media-body align-self-center">
                            <div class="text-right mt-1">
                              <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                {{$order}} / {{$cust_total}}
                              </span>
                              <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                            </div>
                        </div>
                        </div>
                        <div class="mt-4" >
                          <h6 class="">Total Toko Order <span class="float-right">{{round((($order/$cust_total) * 100),2)}}%</span></h6>
                          
                          <div class="progress progress-sm m-0 " style="height: 10px;">
                            <div class="progress-bar" role="progressbar" 
                              aria-valuenow="{{($order/$cust_total) * 100}}" aria-valuemin="0" aria-valuemax="100" 
                              style="width: {{($order/$cust_total) * 100}}%;
                              background-color: #95E0F9 !important;">
                                <span class="sr-only">{{($order/$cust_total) * 100}}% Complete</span>
                                <!--<i class="fas fa-star bg-danger progress-icon fa-xs" style=""></i>-->
                                <i class="fas fa-running  text-danger progress-icon" style="font-size:16px;background-color: #95E0F9"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    
                    @if($pareto)
                      @php
                        $user_id = \Auth::user()->id;
                        $date_now = date('Y-m-d');
                        $month = date('m');
                        $year = date('Y');
                      @endphp
                      @foreach($pareto as $prt)
                        @php
                          //jumlah toko pareto
                          $cust_total_p = App\Http\Controllers\DashboardSalesController::total_pareto($user_id,$prt->id);

                          $cust_exists_p = App\Http\Controllers\DashboardSalesController::amountParetoOrder($user_id,$month,$year,$prt->id);
                        @endphp

                        <!--Total toko pareto-->
                        <div class="col-md-4 mb-4" data-aos="zoom-in">
                          <div class="box-blue">
                            <i class="fas fa-shopping-cart fa-fw bg-white" aria-hidden="true"></i>
                            <div class="info">
                              <div class="media-body align-self-center">
                                <div class="text-right mt-1">
                                  <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                    {{$target ? count($cust_exists_p) : '0'}} / {{$target ? $cust_total_p : '0'}}
                                  </span>
                                    <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                </div>
                            </div>
                            </div>
                            <div class=" mt-4" >
                              <h6 class="">Total Toko Pareto ({{$prt->pareto_code}})<span class="float-right">{{count($cust_exists_p) ? round(((count($cust_exists_p)/$cust_total_p)  * 100),2): '0'}}%</span></h6>
                              <div class="progress progress-sm m-0" style="height: 10px;">
                                
                                  <div class="progress-bar" role="progressbar" 
                                      aria-valuenow="{{count($cust_exists_p) ? round(((count($cust_exists_p)/$cust_total_p)  * 100),2): '0'}}" 
                                      aria-valuemin="0" aria-valuemax="100" style="width: {{count($cust_exists_p) ? round(((count($cust_exists_p)/$cust_total_p)  * 100),2): '0'}}%;background-color: #95E0F9 !important;">
                                      <span class="sr-only">{{count($cust_exists_p) ? round(((count($cust_exists_p)/$cust_total_p)  * 100),2): '0'}}% Complete</span>
                                      <!--<i class="fas fa-star bg-danger progress-icon fa-xs" style=""></i>-->
                                      <i class="fas fa-running  text-danger progress-icon" style="font-size:16px;background-color: #95E0F9"></i>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    @endif

                    <!--Target Sales Total-->
                    <div class="col-md-4 mb-4" data-aos="zoom-in">
                      @if(($target->target_type == 1) || ($target->target_type == 3))
                        @php
                          $ach_quantity = App\Http\Controllers\DashboardSalesController::achQuantity();
                        @endphp
                      @endif
                      @if($target->target_type == 1)
                        <div class="box-green">
                          <i class="fal fa-bullseye-arrow fa-fw bg-white" aria-hidden="true"></i>
                          <div class="info">
                            <div class="media-body align-self-center">
                              <div class="text-right mt-1">
                                <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                  {{$target ? $ach_quantity : '0'}} / {{$target ? $target->target_quantity : '0'}}
                                </span>
                                <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                              </div>
                          </div>
                          </div>
                          <div class="mt-4" >
                            <h6 class="">Target Sales Total <span class="float-right">{{ $target ? round((($ach_quantity/$target->target_quantity) * 100) ,2) : '0'}}%</span></h6>
                            <div class="progress progress-sm m-0" style="height: 10px;">
                              
                                <div class="progress-bar " role="progressbar" aria-valuenow="{{$target ? ($ach_quantity/$target->target_quantity) * 100 : '0'}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$target ? ($ach_quantity/$target->target_quantity) * 100 : '0'}}%;background-color: #95E0F9 !important;">
                                    <span class="sr-only">{{$target ? ($ach_quantity/$target->target_quantity) * 100 : '0'}}% Complete</span>
                                    <!--<i class="fas fa-star bg-danger progress-icon fa-xs" style=""></i>-->
                                    <i class="fas fa-running  text-danger progress-icon" style="font-size:16px;background-color: #95E0F9"></i>
                                </div>
                            </div>
                          </div>
                        </div>
                      @elseif($target->target_type == 2)
                        <div class="box-green">
                          <i class="fal fa-bullseye-arrow fa-fw bg-white" aria-hidden="true"></i>
                          <div class="info">
                            <div class="media-body align-self-center">
                              <div class="text-right mt-1">
                                <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                  {{$target ? singkat_angka($total_ach) : '0'}} / {{$target ? singkat_angka($target->target_values) : '0'}}
                                </span>
                                <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                              </div>
                          </div>
                          </div>
                          <div class="mt-4" >
                            <h6 class="">Target Sales Total <span class="float-right">{{($target->target_values > 0 ) ? round((($total_ach/$target->target_values) * 100) ,2) : '0'}}%</span></h6>
                            <div class="progress progress-sm m-0" style="height: 10px;">
                              
                                <div class="progress-bar " role="progressbar" aria-valuenow="{{($target->target_values > 0 ) ? ($total_ach/$target->target_values) * 100 : '0'}}" aria-valuemin="0" aria-valuemax="100" style="width: {{($target->target_values > 0 ) ? ($total_ach/$target->target_values) * 100 : '0'}}%;background-color: #95E0F9 !important;">
                                    <span class="sr-only">{{($target->target_values > 0 ) ? ($total_ach/$target->target_values) * 100 : '0'}}% Complete</span>
                                    <!--<i class="fas fa-star bg-danger progress-icon fa-xs" style=""></i>-->
                                    <i class="fas fa-running  text-danger progress-icon" style="font-size:16px;background-color: #95E0F9"></i>
                                </div>
                            </div>
                          </div>
                        </div>
                      @elseif($target->target_type == 3)
                        <div class="flip-container target-sales-total" onclick="flipSalesTotal()">
                          <div class="flipper">
                            <div class="back">
                              <div class="box-green">
                                <i class="fal fa-bullseye-arrow fa-fw bg-white" aria-hidden="true"></i>
                                <div class="info">
                                  <div class="media-body align-self-center">
                                    <div class="text-right mt-1">
                                      <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                        {{$target ? singkat_angka($total_ach) : '0'}} / {{$target ? singkat_angka($target->target_values) : '0'}}
                                      </span>
                                      <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                    </div>
                                </div>
                                </div>
                                <div class="mt-4" >
                                  <h6 class="">Target Sales Total <span class="float-right">{{($target->target_values > 0 ) ? round((($total_ach/$target->target_values) * 100) ,2) : '0'}}%</span></h6>
                                  <div class="progress progress-sm m-0" style="height: 10px;">
                                    
                                      <div class="progress-bar " role="progressbar" aria-valuenow="{{($target->target_values > 0 ) ? ($total_ach/$target->target_values) * 100 : '0'}}" aria-valuemin="0" aria-valuemax="100" style="width: {{($target->target_values > 0 ) ? ($total_ach/$target->target_values) * 100 : '0'}}%;background-color: #95E0F9 !important;">
                                          <span class="sr-only">{{($target->target_values > 0 ) ? ($total_ach/$target->target_values) * 100 : '0'}}% Complete</span>
                                          <!--<i class="fas fa-star bg-danger progress-icon fa-xs" style=""></i>-->
                                          <i class="fas fa-running  text-danger progress-icon" style="font-size:16px;background-color: #95E0F9"></i>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="front">
                              <div class="box-green">
                                <i class="fal fa-bullseye-arrow fa-fw bg-white" aria-hidden="true"></i>
                                <div class="info">
                                  <div class="media-body align-self-center">
                                    <div class="text-right mt-1">
                                      <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                        {{$target ? $ach_quantity : '0'}} / {{$target ? $target->target_quantity : '0'}}
                                      </span>
                                      <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                    </div>
                                </div>
                                </div>
                                <div class="mt-4" >
                                  <h6 class="">Target Sales Total <span class="float-right">{{ $target ? round((($ach_quantity/$target->target_quantity) * 100) ,2) : '0'}}%</span></h6>
                                  <div class="progress progress-sm m-0" style="height: 10px;">
                                    
                                      <div class="progress-bar " role="progressbar" aria-valuenow="{{$target ? ($ach_quantity/$target->target_quantity) * 100 : '0'}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$target ? ($ach_quantity/$target->target_quantity) * 100 : '0'}}%;background-color: #95E0F9 !important;">
                                          <span class="sr-only">{{$target ? ($ach_quantity/$target->target_quantity) * 100 : '0'}}% Complete</span>
                                          <!--<i class="fas fa-star bg-danger progress-icon fa-xs" style=""></i>-->
                                          <i class="fas fa-running  text-danger progress-icon" style="font-size:16px;background-color: #95E0F9"></i>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endif
                    </div>

                    <!--target Sales pareto-->
                    @if($pareto)
                      
                      @foreach($pareto as $prt)
                      @php
                      //target/pencapaian pareto
                      if($period_par != null){
                          $pr = $prt->id;
                        
                        //target val pareto
                        $target_str = App\Http\Controllers\DashboardSalesController::TrgValPareto($user_id,$period_par,$pr);
                        //$total_tp = json_decode($target_str,JSON_NUMERIC_CHECK);
                        //$total_target = $total_tp[0];
                        $total_target = $target_str;
                        
                        //target qty pareto
                        $target_tqp = App\Http\Controllers\DashboardSalesController::TrgQtyPareto($user_id,$period_par,$pr);
                        //$total_tqp = json_decode($target_tqp,JSON_NUMERIC_CHECK);
                        $total_trgqp = $target_tqp;
                          
                        //ach pareto nominal values
                        $ach_p = App\Http\Controllers\DashboardSalesController::achUserPareto($user_id,$month,$year,$pr,$period_par);

                        //ach pareto qty values
                        $ach_qty_p = App\Http\Controllers\DashboardSalesController::achUsrTgQtyPareto($user_id,$month,$year,$pr,$period_par);
                        
                        $per_par_type = App\Http\Controllers\DashboardSalesController::PeriodType($period_par);
                        
                        $total_ap = json_decode($ach_p,JSON_NUMERIC_CHECK);
                        $total_ach_pareto_ppn = $total_ap[0];
                        if($target->ppn == 1){
                          $total_ach_pareto = $total_ach_pareto_ppn/1.1;
                        }else{
                          $total_ach_pareto = $total_ach_pareto_ppn;
                        }
                      }
                      @endphp
                        <!--target/pencapaian pareto-->
                          <div class="col-md-4 mb-4" data-aos="zoom-in">
                            @if($target->target_type == 1)
                              <div class="box-green">
                                <i class="fas fa-bullseye-arrow fa-fw bg-white" aria-hidden="true"></i>
                                <div class="info">
                                  <div class="media-body align-self-center">
                                    <div class="text-right mt-1">
                                      <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                        {{$period_par ? $ach_qty_p : '0'}} / {{$period_par ? $total_trgqp : '0'}}
                                      </span>
                                      <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                    </div>
                                  </div>
                                </div>
                                <div class=" mt-4">
                                  <h6 class="">Target Sales Pareto ({{$prt->pareto_code}})<span class="float-right">{{($period_par && $total_trgqp) ? round((($ach_qty_p/$total_trgqp)  * 100) ,2) : '0'}}%</span></h6>
                                  <div class="progress progress-sm m-0" style="height: 10px;">
                                    
                                      <div class="progress-bar bg-info" role="progressbar" 
                                          aria-valuenow="{{$period_par && $total_trgqp ? round((($ach_qty_p/$total_trgqp)  * 100),2): '0'}}" 
                                          aria-valuemin="0" aria-valuemax="100" style="width: {{$period_par && $total_trgqp ? round((($ach_qty_p/$total_trgqp)  * 100),2): '0'}}%;background-color: #95E0F9 !important;">
                                          <span class="sr-only">{{$period_par && $total_trgqp ? round((($ach_qty_p/$total_trgqp)  * 100),2): '0'}}% Complete</span>
                                          <!--<i class="fas fa-star bg-danger progress-icon fa-xs" style=""></i>-->
                                          <i class="fas fa-running  text-danger progress-icon" style="font-size:16px;background-color: #95E0F9"></i>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            @elseif($target->target_type == 2)
                              <div class="box-green">
                                <i class="fas fa-bullseye-arrow fa-fw bg-white" aria-hidden="true"></i>
                                <div class="info">
                                  <div class="media-body align-self-center">
                                    <div class="text-right mt-1">
                                      <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                        {{$period_par ? singkat_angka($total_ach_pareto) : '0'}} / {{$period_par ? singkat_angka($total_target) : '0'}}
                                      </span>
                                      <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                    </div>
                                  </div>
                                </div>
                                <div class=" mt-4">
                                  <h6 class="">Target Sales Pareto ({{$prt->pareto_code}})<span class="float-right">{{($period_par && $total_target) ? round((($total_ach_pareto/$total_target)  * 100) ,2) : '0'}}%</span></h6>
                                  <div class="progress progress-sm m-0" style="height: 10px;">
                                    
                                      <div class="progress-bar bg-info" role="progressbar" 
                                          aria-valuenow="{{$period_par && $total_target ? round((($total_ach_pareto/$total_target)  * 100),2): '0'}}" 
                                          aria-valuemin="0" aria-valuemax="100" style="width: {{$period_par && $total_target ? round((($total_ach_pareto/$total_target)  * 100),2): '0'}}%;background-color: #95E0F9 !important;">
                                          <span class="sr-only">{{$period_par && $total_target ? round((($total_ach_pareto/$total_target)  * 100),2): '0'}}% Complete</span>
                                          <!--<i class="fas fa-star bg-danger progress-icon fa-xs" style=""></i>-->
                                          <i class="fas fa-running  text-danger progress-icon" style="font-size:16px;background-color: #95E0F9"></i>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            @elseif($target->target_type == 3)
                              <div class="flip-container target-pareto-total" onclick="flipAchPareto()">
                                <div class="flipper">
                                  <div class="front">
                                    <div class="box-green">
                                      <i class="fas fa-bullseye-arrow fa-fw bg-white" aria-hidden="true"></i>
                                      <div class="info">
                                        <div class="media-body align-self-center">
                                          <div class="text-right mt-1">
                                            <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                              {{$period_par ? $ach_qty_p : '0'}} / {{$period_par ? $total_trgqp : '0'}}
                                            </span>
                                            <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                          </div>
                                        </div>
                                      </div>
                                      <div class=" mt-4">
                                        <h6 class="">Target Sales Pareto ({{$prt->pareto_code}})<span class="float-right">{{($period_par && $total_trgqp) ? round((($ach_qty_p/$total_trgqp)  * 100) ,2) : '0'}}%</span></h6>
                                        <div class="progress progress-sm m-0" style="height: 10px;">
                                          
                                            <div class="progress-bar bg-info" role="progressbar" 
                                                aria-valuenow="{{$period_par && $total_trgqp ? round((($ach_qty_p/$total_trgqp)  * 100),2): '0'}}" 
                                                aria-valuemin="0" aria-valuemax="100" style="width: {{$period_par && $total_trgqp ? round((($ach_qty_p/$total_trgqp)  * 100),2): '0'}}%;background-color: #95E0F9 !important;">
                                                <span class="sr-only">{{$period_par && $total_trgqp ? round((($ach_qty_p/$total_trgqp)  * 100),2): '0'}}% Complete</span>
                                                <!--<i class="fas fa-star bg-danger progress-icon fa-xs" style=""></i>-->
                                                <i class="fas fa-running  text-danger progress-icon" style="font-size:16px;background-color: #95E0F9"></i>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="back">
                                    <div class="box-green">
                                      <i class="fas fa-bullseye-arrow fa-fw bg-white" aria-hidden="true"></i>
                                      <div class="info">
                                        <div class="media-body align-self-center">
                                          <div class="text-right mt-1">
                                            <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                              {{$period_par ? singkat_angka($total_ach_pareto) : '0'}} / {{$period_par ? singkat_angka($total_target) : '0'}}
                                            </span>
                                            <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                          </div>
                                        </div>
                                      </div>
                                      <div class=" mt-4">
                                        <h6 class="">Target Sales Pareto ({{$prt->pareto_code}})<span class="float-right">{{($period_par && $total_target) ? round((($total_ach_pareto/$total_target)  * 100) ,2) : '0'}}%</span></h6>
                                        <div class="progress progress-sm m-0" style="height: 10px;">
                                          
                                            <div class="progress-bar bg-info" role="progressbar" 
                                                aria-valuenow="{{$period_par && $total_target ? round((($total_ach_pareto/$total_target)  * 100),2): '0'}}" 
                                                aria-valuemin="0" aria-valuemax="100" style="width: {{$period_par && $total_target ? round((($total_ach_pareto/$total_target)  * 100),2): '0'}}%;background-color: #95E0F9 !important;">
                                                <span class="sr-only">{{$period_par && $total_target ? round((($total_ach_pareto/$total_target)  * 100),2): '0'}}% Complete</span>
                                                <!--<i class="fas fa-star bg-danger progress-icon fa-xs" style=""></i>-->
                                                <i class="fas fa-running  text-danger progress-icon" style="font-size:16px;background-color: #95E0F9"></i>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endif
                          </div>
                      @endforeach
                    @endif

                    <!--prediksi pencapaian-->
                    <div class="col-md-4 mb-4" style="display:flex;" data-aos="zoom-in">
                      @if($target->target_type == 1)
                        <div class="box-red w-100">
                          <i class="fal fa-analytics fa-fw bg-white" aria-hidden="true" style="align-items: center"></i>
                          <div class="info">
                            <div class="media-body align-self-center">
                              <div class="text-right mt-1">
                                <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                  
                                  @if($target && $work_plan)
                                    @php
                                      $current_day = date('d');
                                      $hari_berjalan = ((int)$current_day) - $day_off;
                                      $hari_kerja = $work_plan->working_days;
                                      $prediksi_qty = ($ach_quantity/$hari_berjalan) * $hari_kerja;
                                    @endphp
                                  @endif
                                  {{($target && $work_plan) ? $prediksi_qty : '0'}} / {{$target ? $target->target_quantity : '0'}}
                                </span>
                                  
                                  <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                              </div>
                            </div>
                          </div>

                          <div class="ml-1" style="margin-top:34px;">
                            <div class="page-header">
                              <div class="float-left">
                                <h6 class="">Prediksi Pencapaian</h6>
                              </div>
                              <div class="float-right">
                                
                              </div>
                            </div>
                          </div>

                        </div>
                      @elseif($target->target_type == 2)
                        <div class="box-red w-100">
                          <i class="fal fa-analytics fa-fw bg-white" aria-hidden="true" style="align-items: center"></i>
                          <div class="info">
                            <div class="media-body align-self-center">
                              <div class="text-right mt-1">
                                <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                  
                                  @if($target && $work_plan)
                                    @php
                                      $current_day = date('d');
                                      $hari_berjalan = ((int)$current_day) - $day_off;
                                      $hari_kerja = $work_plan->working_days;
                                      $prediksi = ($total_ach/$hari_berjalan) * $hari_kerja;
                                    @endphp
                                  @endif
                                  {{($target && $work_plan) ? singkat_angka($prediksi) : '0'}} / {{$target ? singkat_angka($target->target_values) : '0'}}
                                </span>
                                  
                                  <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                              </div>
                            </div>
                          </div>

                          <div class="ml-1" style="margin-top:34px;">
                            <div class="page-header">
                              <div class="float-left">
                                <h6 class="">Prediksi Pencapaian</h6>
                              </div>
                              <div class="float-right">
                                
                              </div>
                            </div>
                          </div>

                        </div>
                      @elseif($target->target_type == 3)
                      @if($target && $work_plan)
                                    @php
                                      $current_day = date('d');
                                      $hari_berjalan = ((int)$current_day) - $day_off;
                                      $hari_kerja = $work_plan->working_days;
                                      $prediksi_qty = ($ach_quantity/$hari_berjalan) * $hari_kerja;
                                    @endphp
                                  @endif
                        <div class="flip-container prediksi-pencapaian" onclick="flipPredCapai();">
                          <div class="flipper">
                            <div class="front">
                              <div class="box-red w-100">
                                <i class="fal fa-analytics fa-fw bg-white" aria-hidden="true" style="align-items: center"></i>
                                <div class="info">
                                  <div class="media-body align-self-center">
                                    <div class="text-right mt-1">
                                      <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                        {{($target && $work_plan) ? number_format($prediksi_qty,1) : '0'}} / {{$target ? $target->target_quantity : '0'}}
                                      </span>
                                        
                                        <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                    </div>
                                  </div>
                                </div>

                                <div class="ml-1" style="margin-top:34px;">
                                  <div class="page-header">
                                    <div class="float-left">
                                      <h6 class="">Prediksi Pencapaian</h6>
                                    </div>
                                    <div class="float-right">
                                      
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>

                            <div class="back">
                              <div class="box-red w-100">
                                <i class="fal fa-analytics fa-fw bg-white" aria-hidden="true" style="align-items: center"></i>
                                <div class="info">
                                  <div class="media-body align-self-center">
                                    <div class="text-right mt-1">
                                      <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                        
                                        @if($target && $work_plan)
                                          @php
                                            $prediksi = ($total_ach/$hari_berjalan) * $hari_kerja;
                                          @endphp
                                        @endif
                                        {{($target && $work_plan) ? singkat_angka($prediksi) : '0'}} / {{$target ? singkat_angka($target->target_values) : '0'}}
                                      </span>
                                        
                                        <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                    </div>
                                  </div>
                                </div>

                                <div class="ml-1" style="margin-top:34px;">
                                  <div class="page-header">
                                    <div class="float-left">
                                      <h6 class="">Prediksi Pencapaian</h6>
                                    </div>
                                    <div class="float-right">
                                      
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      @endif
                    </div>
                    
                    <!--Average Daily-->
                    @if($target->target_type == 3 || $target->target_type == 1)
                      @php
                        $max_av_qty = App\Http\Controllers\DashboardSalesController::MaxYearQuantity();
                      @endphp
                    @endif
                    <div class="col-md-4 mb-4" data-aos="zoom-in" style="display:flex;">
                      @if($target->target_type == 1)
                        <div class="box-red w-100">
                          <i class="fas fa-tachometer-average fa-fw bg-white" aria-hidden="true" style="align-items: center"></i>
                          <div class="info">
                            <div class="media-body align-self-center">
                              <div class="text-right mt-1">
                                  <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                    {{($target && $work_plan) ? $ach_quantity/$hari_berjalan : '0'}} / {{$max_av_qty}}
                                  </span>
                                  <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                              </div>
                            </div>
                          </div>

                          <div class="ml-1" style="margin-top:34px;">
                            <div class="page-header">
                              <div class="float-left">
                                <h6 class="">Average Daily / Average Max Daily </h6>
                              </div>
                              <div class="float-right">
                                
                              </div>
                            </div>
                          </div>

                        </div>
                      @elseif($target->target_type == 2)
                        <div class="box-red w-100">
                          <i class="fas fa-tachometer-average fa-fw bg-white" aria-hidden="true" style="align-items: center"></i>
                          <div class="info">
                            <div class="media-body align-self-center">
                              <div class="text-right mt-1">
                                  <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                    {{($target && $work_plan) ? singkat_angka($total_ach/$hari_berjalan) : '0'}} / {{singkat_angka($max_av)}}
                                  </span>
                                  <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                              </div>
                            </div>
                          </div>

                          <div class="ml-1" style="margin-top:34px;">
                            <div class="page-header">
                              <div class="float-left">
                                <h6 class="">Average Daily / Average Max Daily </h6>
                              </div>
                              <div class="float-right">
                                
                              </div>
                            </div>
                          </div>

                        </div>
                      @elseif($target->target_type == 3)
                      <div class="flip-container average-daily" onclick="flipAverDaily()">
                        <div class="flipper">
                          <div class="front">
                            <div class="box-red w-100">
                              <i class="fas fa-tachometer-average fa-fw bg-white" aria-hidden="true" style="align-items: center"></i>
                              <div class="info">
                                <div class="media-body align-self-center">
                                  <div class="text-right mt-1">
                                      <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                        {{($target && $work_plan) ? number_format($ach_quantity/$hari_berjalan,1) : '0'}} / {{$max_av_qty}}
                                      </span>
                                      <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                  </div>
                                </div>
                              </div>

                              <div class="ml-1" style="margin-top:34px;">
                                <div class="page-header">
                                  <div class="float-left">
                                    <h6 class="">Average Daily / Average Max Daily </h6>
                                  </div>
                                  <div class="float-right">
                                    
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                          <div class="back">
                            <div class="box-red w-100">
                              <i class="fas fa-tachometer-average fa-fw bg-white" aria-hidden="true" style="align-items: center"></i>
                              <div class="info">
                                <div class="media-body align-self-center">
                                  <div class="text-right mt-1">
                                      <span class="border px-2 py-1 font-weight-bold h4" style="border-radius: 10px;">
                                        {{($target && $work_plan) ? singkat_angka($total_ach/$hari_berjalan) : '0'}} / {{singkat_angka($max_av)}}
                                      </span>
                                      <p class="mb-0 mt-1 text-truncate">&nbsp;</p>
                                  </div>
                                </div>
                              </div>

                              <div class="ml-1 " style="margin-top:34px;">
                                <div class="page-header">
                                  <div class="float-left">
                                    <h6 class="">Average Daily / Average Max Daily </h6>
                                  </div>
                                  <div class="float-right">
                                    
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>
                      @endif
                    </div>

                  </div>
                </div>
              </section>
            </div>
            
          </div>

          
          <div class="row justify-content-center mb-4" style="">
              <div class="col-12" style="z-index: 2;">
                  <!-- Tabs -->
                  <section id="tabs">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-md-12" data-aos="fade-up">
                          <nav>
                            <div class="nav nav-tabs nav-fill border-0" id="nav-tab" role="tablist">
                              <a class="nav-item nav-link active" id="nav-no-have-order-tab" data-toggle="tab" href="#nav-no-have-order" role="tab"  aria-selected="true">
                                <span style="float: left;">
                                  <i class="fal fa-store mr-2"></i>
                                  <i class="fas fa-times" style="position: absolute;margin-left:-20px;margin-top:2px;font-weight:100"></i>
                                  Toko Pareto Belum Order
                                </span>
                                <span class="badge badge-danger my-auto badge-pill" style="float:right;font-size:14px;">{{count($cust_not_exists)}}</span>
                              </a>
                              <a class="nav-item nav-link" id="nav-have-order-tab" data-toggle="tab" href="#nav-have-order" role="tab"  aria-selected="false">
                                <span style="float: left;">  
                                  <i class="fal fa-store mr-2"></i>
                                  <i class="fas fa-check" style="position: absolute;margin-left:-20px;margin-top:2px;font-weight:100"></i>
                                  Toko Pareto Sudah Order
                                </span>
                                <span class="badge badge-success my-auto badge-pill" style="float:right;font-size:14px;">{{count($cust_exists)}}</span>
                              </a>
                              <a class="nav-item nav-link" id="nav-no-have-process-tab" data-toggle="tab" href="#nav-no-have-process" role="tab"  aria-selected="false">
                                <span style="float: left;">
                                  <i class="fal fa-shipping-timed mr-2"></i>  
                                  Order Belum Kirim > 5 Hari
                                </span>
                                <span class="badge badge-warning my-auto badge-pill" style="float:right;font-size:14px;border-ra">{{count($order_overday)}}</span>
                              </a>
                          </nav>

                          
                          <div class="tab-content py-3 px-3" id="nav-tabContent">
                            <!--toko belum order--->
                            <div class="tab-pane fade show active " id="nav-no-have-order" 
                              role="tabpanel" aria-labelledby="nav-no-have-order-tab" >
                              <ul class="list-group w-100 ">
                                @if(count($cust_not_exists) > 0 )
                                  <?php $last_orders = Array(); ?>
                                  @foreach ($cust_not_exists as $item)
                                    @php
                                      $last_order = App\Http\Controllers\DashboardSalesController::lastOrder($item->id);
                                      array_push($last_orders, $last_order);
                                    @endphp
                                  @endforeach
                                  @php 
                                    arsort($last_orders);
                                    $keys = array_keys($last_orders);
                                  @endphp
                                  @foreach($keys as $key)
                                    @if($last_orders[$key] == '')
                                      <li class="list-group-item border-right-0 border-left-0" style="color: #1A4066;border-bottom-right-radius:0;
                                        border-bottom-left-radius:0;">
                                          <div class="float-left ml-n3" style="margin-right:35%;">
                                            <b>{{$cust_not_exists[$key]->store_code}} - {{$cust_not_exists[$key]->store_name}}</b>,
                                          </div>
                                          <div class="last-order-info">
                                            
                                            <a class="pe-auto popoverData" data-container="body" 
                                              data-toggle="popover" data-placement="top" 
                                              data-content="{{$last_orders[$key] == '' ? '': 'Jumlah hari belum order'}}" 
                                              data-trigger="hover">
                                              @if($last_orders[$key] != '')
                                                <span class="badge badge-info" style="cursor: pointer">{{$last_orders[$key]}} Hari</span>
                                              @endif
                                            </a>
                                          
                                          </div>
                                          <br><p class="mb-n3 ml-n3">{{$cust_not_exists[$key]->address}}</p><br>
                                        @php
                                            [$visit_off,$visit_on] = App\Http\Controllers\DashboardSalesController::visitNoOrder($cust_not_exists[$key]->id);
                                            $visit = $visit_off + $visit_on;
                                        @endphp
                                        @if($visit_off > 0 )
                                          <!--
                                          <a class="pe-auto popoverData" data-container="body" 
                                            data-toggle="popover" data-placement="top" 
                                            data-content="Visit tanpa order." 
                                            data-trigger="hover">
                                            <i class="fas fa-times-circle text-danger mr-1 ml-n3"></i><b class="text-secondary">{{$visit}}</b>
                                          </a>
                                          -->
                                          <a class="pe-auto popoverData" data-container="body" 
                                            data-toggle="popover" data-placement="top" 
                                            data-content="Check out tanpa order & Off Location." 
                                            data-trigger="hover">
                                            <i class="fal fa-location-slash text-danger mr-1 ml-n3"></i><b class="text-danger">{{$visit_off}}</b>
                                          </a>
                                        @endif
                                        @if($visit_on > 0)
                                          <a class="pe-auto popoverData" data-container="body" 
                                            data-toggle="popover" data-placement="top" 
                                            data-content="Checkout tanpa order & On Location." 
                                            data-trigger="hover">
                                            <i class="fal fa-location text-danger mr-1 {{$visit_off > 0 ? 'ml-3' : 'ml-n3'}}"></i><b class="text-danger">{{$visit_on}}</b>
                                          </a>
                                        @endif 
                                      </li>
                                    @endif
                                  @endforeach
                                  @foreach($keys as $key)
                                    @if($last_orders[$key] != '')
                                      <li class="list-group-item border-right-0 border-left-0" style="color: #1A4066;border-bottom-right-radius:0;
                                        border-bottom-left-radius:0;">
                                          <div class="float-left ml-n3" style="margin-right:35%;">
                                            <b>{{$cust_not_exists[$key]->store_code}} - {{$cust_not_exists[$key]->store_name}}</b>,
                                          </div>
                                          <div class="last-order-info">
                                            
                                            <a class="pe-auto popoverData" data-container="body" 
                                              data-toggle="popover" data-placement="top" 
                                              data-content="{{$last_orders[$key] == '' ? '': 'Jumlah hari belum order'}}" 
                                              data-trigger="hover">
                                              @if($last_orders[$key] != '')
                                                <span class="badge badge-info" style="cursor: pointer">{{$last_orders[$key]}} Hari</span>
                                              @endif
                                            </a>
                                          
                                          </div>
                                          <br><p class="mb-n3 ml-n3">{{$cust_not_exists[$key]->address}}</p><br>
                                        @php
                                            [$visit_off,$visit_on] = App\Http\Controllers\DashboardSalesController::visitNoOrder($cust_not_exists[$key]->id);
                                            $visit = $visit_off + $visit_on;
                                        @endphp
                                        @if($visit_off > 0 )
                                          <!--
                                          <a class="pe-auto popoverData" data-container="body" 
                                            data-toggle="popover" data-placement="top" 
                                            data-content="Visit tanpa order." 
                                            data-trigger="hover">
                                            <i class="fas fa-times-circle text-danger mr-1 ml-n3"></i><b class="text-secondary">{{$visit}}</b>
                                          </a>
                                          -->
                                          <a class="pe-auto popoverData" data-container="body" 
                                            data-toggle="popover" data-placement="top" 
                                            data-content="Check out tanpa order & Off Location." 
                                            data-trigger="hover">
                                            <i class="fal fa-location-slash text-danger mr-1 ml-n3"></i><b class="text-danger">{{$visit_off}}</b>
                                          </a>
                                        @endif
                                        @if($visit_on > 0)
                                          <a class="pe-auto popoverData" data-container="body" 
                                            data-toggle="popover" data-placement="top" 
                                            data-content="Checkout tanpa order & On Location." 
                                            data-trigger="hover">
                                            <i class="fal fa-location text-danger mr-1 {{$visit_off > 0 ? 'ml-3' : 'ml-n3'}}"></i><b class="text-danger">{{$visit_on}}</b>
                                          </a>
                                        @endif 
                                      </li>
                                    @endif
                                  @endforeach
                                @else
                                  <li class="list-group-item border-0" style="color: #1A4066;border-bottom-right-radius:0;
                                  border-bottom-left-radius:0;"><b>Nihil</b></li>
                                @endif  
                              </ul>
                            </div>

                            <!--toko sudah order--->
                            <div class="tab-pane fade" id="nav-have-order" role="tabpanel" aria-labelledby="nav-have-order-tab">
                              <ul class="list-group w-100">
                                
                                @if(count($cust_exists) > 0 )
                                  <?php $last_odrs = Array(); ?>
                                  @foreach ($cust_exists as $it)
                                    @php
                                      $last_odr = App\Http\Controllers\DashboardSalesController::lastOrder($it->id);
                                      array_push($last_odrs, $last_odr);
                                    @endphp
                                  @endforeach
                                  @php 
                                    asort($last_odrs);
                                    $keys_exists = array_keys($last_odrs);
                                  @endphp
                                  @foreach($keys_exists as $k)
                                    <li class="list-group-item border-right-0 border-left-0" 
                                    style="color: #1A4066;
                                          border-bottom-right-radius:0;
                                          border-bottom-left-radius:0;">
                                      <div class="float-left ml-n3" style="margin-right:35%;">
                                          <b>{{$cust_exists[$k]->store_code}} - {{$cust_exists[$k]->store_name}}</b>,
                                      </div>
                                      <div class="last-order-info">
                                        <a class="pe-auto popoverData" data-container="body" 
                                          data-toggle="popover" data-placement="top" 
                                          data-content="{{$last_odrs[$k] == '' ? '': 'Jumlah hari belum order'}}" 
                                          data-trigger="hover">
                                          @if($last_odrs[$k] != '')
                                            <span class="badge badge-info" style="cursor: pointer">{{$last_odrs[$k]}} Hari</span>
                                          @endif
                                        </a>
                                      
                                      </div>
                                      <br><p class="mb-n3 ml-n3">{{$cust_exists[$k]->address}}</p><br> 
                                    
                                      @php
                                        [$NoOdrVisit_off,$NoOdrVisit_on] = App\Http\Controllers\DashboardSalesController::visitNoOrder($cust_exists[$k]->id);
                                        [$OdrVisit_off,$OdrVisit_on] = App\Http\Controllers\DashboardSalesController::visitOrder($cust_exists[$k]->id);
                                        $visit_noorder = $NoOdrVisit_off + $NoOdrVisit_on;
                                        $order_visit = $OdrVisit_off + $OdrVisit_on;
                                      @endphp
                                      @if($NoOdrVisit_off > 0 )
                                        <!--
                                        <a class="pe-auto popoverData" data-container="body" 
                                          data-toggle="popover" data-placement="top" 
                                          data-content="Visit tanpa order." 
                                          data-trigger="hover">
                                          <i class="fas fa-times-circle text-danger ml-n3"></i>
                                          <b class="text-secondary">{{$visit_noorder}}</b>
                                        </a>
                                        -->
                                        <a class="pe-auto popoverData" data-container="body" 
                                          data-toggle="popover" data-placement="top" 
                                          data-content="Check out tanpa order & Off Location." 
                                          data-trigger="hover">
                                          <i class="fal fa-location-slash text-danger mr-1 ml-n3"></i>
                                          <b class="text-danger">{{$NoOdrVisit_off}}</b>
                                        </a>
                                      @endif
                                      @if($NoOdrVisit_on > 0)
                                        <a class="pe-auto popoverData" data-container="body" 
                                          data-toggle="popover" data-placement="top" 
                                          data-content="Check out tanpa order & On Location." 
                                          data-trigger="hover">
                                          <i class="fal fa-location text-danger mr-1 {{$NoOdrVisit_off > 0 ? 'ml-3' : 'ml-n3'}} "></i>
                                          <b class="text-danger">{{$NoOdrVisit_on}}</b>
                                        </a>
                                      @endif
                                      @if($OdrVisit_off > 0 )
                                        <br>
                                        <!--
                                        <a class="pe-auto popoverData"  data-container="body" 
                                          data-toggle="popover" data-placement="top" 
                                          data-content="Visit & order." 
                                          data-trigger="hover">
                                          <i class="fas fa-check-circle   ml-n3" 
                                          style="color:#1A4066"></i>
                                          <b class="text-secondary">{{$order_visit}}</b>
                                        </a>
                                        -->
                                        <a class="pe-auto popoverData" data-container="body" 
                                          data-toggle="popover" data-placement="top" 
                                          data-content="Order Off Location." 
                                          data-trigger="hover">
                                          <i class="fal fa-location-slash mr-1 ml-n3" style="color: #1A4066"></i>
                                          <b style="color: #1A4066">{{$OdrVisit_off}}</b>
                                        </a>
                                      @endif
                                      @if($OdrVisit_on > 0)
                                        <a class="pe-auto popoverData" data-container="body" 
                                          data-toggle="popover" data-placement="top" 
                                          data-content="Order On Location." 
                                          data-trigger="hover">
                                          <i class="fal fa-location mr-1 {{$OdrVisit_off > 0 ? 'ml-3' : 'ml-n3'}}" style="color: #1A4066"></i>
                                          <b style="color: #1A4066">{{$OdrVisit_on}}</b>
                                        </a>
                                      @endif
                                    </li>
                                  @endforeach
                                @else
                                  <li class="list-group-item border-0" style="color: #1A4066;border-bottom-right-radius:0;
                                  border-bottom-left-radius:0;"><b>Nihil</b></li>
                                @endif  
                              </ul>
                            </div>
                            
                            <!--toko belum kirim > 5 hari--->
                            <div class="tab-pane fade" id="nav-no-have-process" role="tabpanel" aria-labelledby="nav-no-have-process-tab">
                              <ul class="list-group w-100 ">
                                @if(count($order_overday) > 0 )
                                  @foreach ($order_overday as $over)
                                    <li class="list-group-item border-right-0 border-left-0" style="color: #1A4066;border-bottom-right-radius:0;
                                      border-bottom-left-radius:0;">
                                        <b class="text-success mb-3">#{{$over->invoice_number}}</b><br>  
                                          
                                        <b>{{$over->customer_id ? $over->customers->store_name : ''}}</b>,<br>
                                          {{$over->customer_id ? $over->customers->address :''}}
                                    </li>
                                  @endforeach
                                @else
                                  <li class="list-group-item border-0" style="color: #1A4066;border-bottom-right-radius:0;
                                  border-bottom-left-radius:0;"><b>Nihil</b></li>
                                @endif  
                              </ul>
                            </div>
                            
                          </div>
                        
                        </div>
                      </div>
                    </div>
                  </section>
                  <!-- ./Tabs -->
              </div>
          </div>
        
          <!--
          <div class="row justify-content-center" style="">
              <div class="col-12" style="z-index: 2;">
                  <section class="statistics">
                      <div class="container-fluid">
                        <div class="row">

                          <div class="col-md-6 mb-4 d-flex" data-aos="fade-up">
                            <div class="box w-100">
                              <ul class="list-group w-100 " style="border-top-right-radius:20px;
                              border-top-left-radius:20px;">
                                <li class="list-group-item active border-right-0 border-left-0" 
                                  style="background-color:#1A4066;
                                        border-top-right-radius:20px;
                                        border-top-left-radius:20px;
                                        border-color:#1A4066;
                                        color:#fff;">
                                
                                    <i class="fas fa-times bg-white py-1 px-2 mr-2 my-auto" 
                                    style="color:#1A4066;border-radius:5px;float: left;"></i>
                                  <span style="display: block; padding-left: 40px;">
                                    <b>Toko Pareto Belum Order {{date('F Y', strtotime(\Carbon\Carbon::now()))}}</b>
                                  </span>
                                  
                                </li>
                                @if(count($cust_not_exists) > 0 )
                                  @foreach ($cust_not_exists as $item)
                                    <li class="list-group-item border-right-0 border-left-0" style="color: #1A4066;border-bottom-right-radius:0;
                                    border-bottom-left-radius:0;"><b>{{$item->store_name}}</b>,<br>{{$item->address}}</li>
                                  @endforeach
                                @else
                                  <li class="list-group-item border-right-0 border-left-0" style="color: #1A4066;border-bottom-right-radius:0;
                                  border-bottom-left-radius:0;"><b>Nihil</b></li>
                                @endif  
                              </ul>
                            </div>
                          </div>

                          <div class="col-md-6 mb-4 d-flex" data-aos="fade-up">
                            <div class="box w-100">
                              <ul class="list-group w-100" style="border-top-right-radius:20px;
                                border-top-left-radius:20px;">
                                <li class="list-group-item active border-right-0 border-left-0" 
                                  style="background-color:#1A4066;
                                        border-top-right-radius:20px;
                                        border-top-left-radius:20px;
                                        border-color:#1A4066;
                                        color:#fff;">
                                <i class="fas fa-check bg-white py-1 mr-2" 
                                style="color:#1A4066;border-radius:5px;float: left;padding-left:6px;padding-right:6px;"></i>
                                <span style="display: block; padding-left: 40px;">
                                  <b>Toko Pareto Sudah Order {{date('F Y', strtotime(\Carbon\Carbon::now()))}}</b>
                                </span>
                                </li>
                                @if(count($cust_exists) > 0 )
                                  @foreach ($cust_exists as $it)
                                    <li class="list-group-item border-right-0 border-left-0" 
                                    style="color: #1A4066;
                                          border-bottom-right-radius:0;
                                          border-bottom-left-radius:0;">
                                          <b>{{$it->store_name}}</b>,<br>{{$it->address}} 
                                      <//!--<span class="badge badge-warning">{{$it->pareto->pareto_code}}</span>--//>
                                    </li>
                                  @endforeach
                                @else
                                  <li class="list-group-item border-right-0 border-left-0" style="color: #1A4066;border-bottom-right-radius:0;
                                  border-bottom-left-radius:0;"><b>Nihil</b></li>
                                @endif  
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                  </section>
              </div>
          </div>
          -->

          <div class="row justify-content-center dashboard" style="">
            <div class="col-12 mt-2" style="z-index: 2;">
                <!--<section class="statistics">-->
                    <div class="container-fluid">
                      <div class="row">
                        <!--chart daily max//>
                        <div class="col-md-4 mb-4" data-aos="fade-up">
                          <div class="box w-100">
                            <ul class="list-group w-100" style="box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);border-top-right-radius:20px;
                              border-top-left-radius:20px;">
                              <li class="list-group-item active" 
                                    style="background-color:#1A4066;
                                          border-top-right-radius:20px;
                                          border-top-left-radius:20px;
                                          border-color:#1A4066;
                                          color:#fff;">
                                <i class="fal fa-chart-bar py-1 mr-2"
                                style="border-radius:5px;float: left;padding-left:6px;padding-right:6px;"></i>
                                <span class="font-weight-bold dashboard-tittle" style="display: block; padding-left: 40px;">Daily Max <//--{{date('F Y', strtotime(\Carbon\Carbon::now()))}}--//></span>
                              </li>
                              <li class="list-group-item" style="color: #1A4066;">
                                <div id="container_daily" style="height: 350px;"></div>
                              </li>
                            </ul>
                          </div>
                        </div>
                        -->

                        @if($target->target_type == 1)
                          <!--chart all sales quantity--->
                          <div class="col-md-12 mb-4" data-aos="fade-up">
                            <div class="box w-100">
                              <ul class="list-group w-100" style="box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);border-top-right-radius:20px;
                                border-top-left-radius:20px;">
                                <li class="list-group-item active" 
                                      style="background-color:#1A4066;
                                            border-top-right-radius:20px;
                                            border-top-left-radius:20px;
                                            border-color:#1A4066;
                                            color:#fff;">
                                  <i class="fal fa-chart-bar py-1 mr-2"
                                  style="border-radius:5px;float: left;padding-left:6px;padding-right:6px;"></i>
                                  <span class="font-weight-bold dashboard-tittle" style="display: block; padding-left: 40px;">Grafik Pencapaian Kuantitas <!--{{date('F Y', strtotime(\Carbon\Carbon::now()))}}--></span>
                                </li>
                                <li class="list-group-item" style="color: #1A4066;">
                                  <div id="container_qty" class="height-chart"></div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        @elseif($target->target_type == 2)
                          <!--chart all sales nominal--->
                          <div class="col-md-12 mb-4" data-aos="fade-up">
                            <div class="box w-100">
                              <ul class="list-group w-100" style="box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);border-top-right-radius:20px;
                                border-top-left-radius:20px;">
                                <li class="list-group-item active" 
                                      style="background-color:#1A4066;
                                            border-top-right-radius:20px;
                                            border-top-left-radius:20px;
                                            border-color:#1A4066;
                                            color:#fff;">
                                  <i class="fal fa-chart-bar py-1 mr-2"
                                  style="border-radius:5px;float: left;padding-left:6px;padding-right:6px;"></i>
                                  <span class="font-weight-bold dashboard-tittle" style="display: block; padding-left: 40px;">Grafik Pencapaian Nominal <!--{{date('F Y', strtotime(\Carbon\Carbon::now()))}}--></span>
                                </li>
                                <li class="list-group-item" style="color: #1A4066;">
                                  <div id="container" class="height-chart"></div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        @elseif($target->target_type == 3)
                          <!--chart all sales quantity--->
                          <div class="col-md-12 mb-4" data-aos="fade-up">
                            <div class="box w-100">
                              <ul class="list-group w-100" style="box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);border-top-right-radius:20px;
                                border-top-left-radius:20px;">
                                <li class="list-group-item active" 
                                      style="background-color:#1A4066;
                                            border-top-right-radius:20px;
                                            border-top-left-radius:20px;
                                            border-color:#1A4066;
                                            color:#fff;">
                                  <i class="fal fa-chart-bar py-1 mr-2"
                                  style="border-radius:5px;float: left;padding-left:6px;padding-right:6px;"></i>
                                  <span class="font-weight-bold dashboard-tittle" style="display: block; padding-left: 40px;">Grafik Pencapaian Kuantitas <!--{{date('F Y', strtotime(\Carbon\Carbon::now()))}}--></span>
                                </li>
                                <li class="list-group-item" style="color: #1A4066;">
                                  <div id="container_qty" class="height-chart"></div>
                                </li>
                              </ul>
                            </div>
                          </div>
                          
                          <!--chart all sales nominal--->
                          <div class="col-md-12 mb-4" data-aos="fade-up">
                            <div class="box w-100">
                              <ul class="list-group w-100" style="box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);border-top-right-radius:20px;
                                border-top-left-radius:20px;">
                                <li class="list-group-item active" 
                                      style="background-color:#1A4066;
                                            border-top-right-radius:20px;
                                            border-top-left-radius:20px;
                                            border-color:#1A4066;
                                            color:#fff;">
                                  <i class="fal fa-chart-bar py-1 mr-2"
                                  style="border-radius:5px;float: left;padding-left:6px;padding-right:6px;"></i>
                                  <span class="font-weight-bold dashboard-tittle" style="display: block; padding-left: 40px;">Grafik Pencapaian Nominal <!--{{date('F Y', strtotime(\Carbon\Carbon::now()))}}--></span>
                                </li>
                                <li class="list-group-item" style="color: #1A4066;">
                                  <div id="container" class="height-chart"></div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        @endif
                      </div>
                    </div>
                  <!--</section>-->
            </div>
          </div>
        @endif
    </div>

    @include('sweetalert::alert')
@endsection
@section('footer-scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <!--
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    -->
    <script type="text/javascript">
        //Popover
        $('.popoverData').popover();

        // Init AOS
        AOS.init({
          duration: 1400,
        })

        if ($(window).width() < 995) {
            $('#nav-no-have-order-tab, #nav-have-order-tab, #nav-no-have-process-tab').addClass('mb-2');
        }
        
        if ($(window).width() < 769) {
            $('.modal-dialog-paket').removeClass('modal-lg');
            $('.modal-dialog-paket').addClass('modal-dialog-full-width');
            $('.modal-content-paket').addClass('modal-content-full-width');
            $('#container').removeClass('height-chart');
        }

        if ($(window).width() <= 600) {
            //$('#prf-brd').removeClass('mt-1');
            //$('.col-list-order'). removeClass('col-9').addClass('col-12');
            //$('.col-src-order'). removeClass('col-9').addClass('col-12').addClass('mt-n3').removeClass('px-0');
            $('.col-badge-order'). removeClass('col-9').addClass('col-12');
            $('.txt-reset'). removeClass('ml-2');
            //$('#prf-brd').addClass('mt-2');
        } 
        if ($(window).width() <= 411) {
            $('.col-list-order').addClass('ml-n3');
            $('.btn-preview-cancel').addClass('btn-block').addClass('mt-5');
            //$('.contact-row').addClass('mt-5');
        }
      
      function flip() {
          $('.flip-container').toggleClass('hover');
          setTimeout(function(){
            // toggle back after 1 second
            $('.flip-container').toggleClass('hover');  
          },5000)
      }
      function flipSalesTotal() {
          $('.target-sales-total').toggleClass('hover');
          setTimeout(function(){
            // toggle back after 1 second
            $('.target-sales-total').toggleClass('hover');  
          },5000)
      }
      function flipAchPareto() {
          $('.target-pareto-total').toggleClass('hover');
          setTimeout(function(){
            $('.target-pareto-total').toggleClass('hover');  
          },5000)
      }
      function flipPredCapai() {
          $('.prediksi-pencapaian').toggleClass('hover');
          
          setTimeout(function(){
            $('.prediksi-pencapaian').toggleClass('hover');  
          },5000)
      }
      function flipAverDaily() {
         $('.average-daily').toggleClass('hover');
         setTimeout(function(){
            $('.average-daily').toggleClass('hover');  
          },5000)
      }

      
              
      //all sales chart
      $(function () {
        var achievement = <?php echo $percent ?>;
        var achievement_qty = <?php echo $percent_qty ?>;
        var sales = <?php echo $users_display ?>;
        var red_line = <?php echo $red_line ?>;
        var param_line = <?php echo $param_line ?>;
       
        let d = new Date(); // 2020-06-21
        let longMonth = d.toLocaleString('en-us', { month: 'long' });
        let longYear = d.getFullYear();
        //var colors1 = ['#1A4066'];
        //var colors2 = ['#08f3ff'];

        if ($(window).width() <= 600) {
          var type_ = 'bar';
          var plot = {
                bar: {
                    zones: [{
                        value: param_line, // Values up to 10 (not including) ...
                          color:  '#08b1ff'// ... have the color blue.
                      },{
                        color: '#1A4066' // Values from 10 (including) and up have the color red
                      }]
                  }
            }
        }else if($(window).width() > 600){
          var type_ = 'column';
          var plot = {
                column: {
                    zones: [{
                        value: param_line, // Values up to 10 (not including) ...
                          color:  '#08b1ff'// ... have the color blue.
                      },{
                        color: '#1A4066' // Values from 10 (including) and up have the color red
                      }]
                  }
            }
        }
        
        //all sales chart nominal
        $('#container').highcharts({
          chart: {
            type: type_,
            /*type: 'bar'*/
          },
          title: {
            text: 'Pencapaian '+longMonth+'  '+longYear
          },
          xAxis: {
            categories: sales
          },
          yAxis: {
            max: 150,
              title: {
                text: 'Persentase'
            },
            labels: {
              formatter: function() {
                var pcnt = Highcharts.numberFormat((this.value / 100 * 100), 0, '.');
                return pcnt + '%';
              }
            },
            plotLines: [{
              value: param_line,
              color: 'red',
              dashStyle: 'shortdash',
              width: 2,
              label: {
                text: ''
              }
            }]
          },
          //colors:colors,
          plotOptions:plot,
          series: [/*{
            name: 'Target',
            data: target
          },*/{
            name: 'Pencapaian (%)',
            data: achievement,
          }
          ]
        });

        //all sales chart quantity
        $('#container_qty').highcharts({
          chart: {
            type: type_,
            /*type: 'bar'*/
          },
          title: {
            text: 'Pencapaian '+longMonth+'  '+longYear
          },
          xAxis: {
            categories: sales
          },
          yAxis: {
            max: 150,
              title: {
                text: 'Persentase'
            },
            labels: {
              formatter: function() {
                var pcnt = Highcharts.numberFormat((this.value / 100 * 100), 0, '.');
                return pcnt + '%';
              }
            },
            plotLines: [{
              value: param_line,
              color: 'red',
              dashStyle: 'shortdash',
              width: 2,
              label: {
                text: ''
              }
            }]
          },
          //colors:colors,
          plotOptions: plot,
          series: [/*{
            name: 'Target',
            data: target
          },*/{
            name: 'Pencapaian (%)',
            data: achievement_qty,
          }
          ]
        });

      /*daily max chart
      Highcharts.chart('container_daily', {
          chart: {
              type: 'column'
          },
          title: {
              text: 'Daily Max '+longMonth+'  '+longYear
          },
          
          xAxis: {
              categories: [
                  'Daily max' , 
                  'Hari ini',
              ],
              crosshair: true
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Capaian (Rp)'
              },
              labels: {
                formatter: function () {
                    return Highcharts.numberFormat(this.value,0);
                }
            },
            
          },
          
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0
              },
              
          },
          series: [{
            showInLegend: false,             
            name: 'Capaian (Rp)',
              data: [{
                  y: max_daily,
                  color: '#8CC63F'
              }, {
                  y: today,
                  color: '#286699'
              }]
          }]
          /*series: [
            {
              data:[max_daily,today]
            }
            
          ]*==/
      });*/

      });
    </script> 
@endsection
