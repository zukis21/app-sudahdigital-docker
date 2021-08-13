@extends('customer.layouts.template-nocart')
@section('title') Dashboard @endsection
@section('content')
<style>
    .lead{
      font-weight: bold;
    }
    #modalNotesCancel .modal-dialog {
        -webkit-transform: translate(0,-50%);
        -o-transform: translate(0,-50%);
        transform: translate(0,-50%);
        top: 50%;
        margin: 5 auto;
    }

    .modal-dialog-full-width {
        position:absolute;
        right:0;
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        max-width:none !important;
    }

    .modal-content-full-width  {
        height: auto !important;
        min-height: 100% !important;
        border-radius: 0 !important;
    }

    .style-badge{
        padding:7px 10px; 
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-right-radius:0;
        border-bottom-left-radius:0;
    }

    #tbl_ tbody {
        display:block;
        height:380px;
        overflow:auto;
    }

    thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }

    thead {
        
    }

    .filter-badge{
        border:0.5px solid #1A4066;
    }
    
    .bg-link{
        background:#1A4066; 
    }

    .txt-reset{
        color:#1A4066;
        font-weight:600;
        font-size: 16px;
        padding-left:0;
        margin-top:10px;
    }

    .txt_dtl{
        line-height: 0;
    }

    .detail-list-order{
        margin-bottom:10px;
    }

    .detail-list-paket_table{
        margin-bottom:10px;
    }

    .p-btn-detil{
        padding-right:10px;
    }

    @media (max-width: 540px){
        .col-list-order{
            margin-left: -1.3rem;
        }

        /*tbody {
            height:320px;
        }*/

        .data-list-order{
            font-size:12px;
            
        }

        .status-order{
            font-size:8px;
        }

        .filter-badge{
            font-size: 10px;
        }

        .txt-reset{
            font-size: 12px;
        }

        .detail-list-order{
            margin-bottom:-3rem;
        }

        .bt-dtl-pesan{
            width: 100%;
        }
        
        .p-btn-detil{
            padding-left:10px;
            padding-right:10px;
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
                          <div class="content">
                            @if($target)
                            <h6><b>Dashboard {{Auth::user()->name}} {{date('F'.' Y', strtotime(\Carbon\Carbon::now()))}}</b></h6>
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

          $total_ach = 0;
          foreach($order_ach as $p){
            $total_ach += $p->total_price;
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
            <section class="info-box ">
              <div class="container">
                <div class="row">

                  <!--toko order-->
                  <div class="col-md-4 mb-3">
                    <div class="box">
                      <i class="fal fa-shopping-cart fa-fw bg-dark" aria-hidden="true"></i>
                      <div class="info">
                        <div class="media-body align-self-center">
                          <div class="text-right">
                              <h5 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{$order}} / {{$cust_total}}</span></h5>
                              <p class="mb-0 mt-1 text-truncate">Toko Order</p>
                          </div>
                      </div>
                      </div>
                      <div class="ml-1 mt-4" >
                        <h6 class="text-uppercase">Persentase <span class="float-right">{{round($order/$cust_total * 100,2)}}%</span></h6>
                        <div class="progress progress-sm m-0" style="height: 5px;">
                          
                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{$order/$cust_total * 100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$order/$cust_total * 100}}%">
                                <span class="sr-only">{{$order/$cust_total * 100}}% Complete</span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!--pencapaian-->
                  <div class="col-md-4 mb-3">
                    <div class="box">
                      <i class="fal fa-bullseye-arrow fa-fw bg-dark" aria-hidden="true"></i>
                      <div class="info">
                        <div class="media-body align-self-center">
                          <div class="text-right">
                              <h5 class="font-20 my-0 font-weight-bold">
                                <span data-plugin="counterup">
                                  {{$target ? singkat_angka($total_ach) : '0'}} / {{$target ? singkat_angka($target->target_values) : '0'}}
                                </span>
                              </h5>
                              <p class="mb-0 mt-1 text-truncate">Pencapaian</p>
                          </div>
                      </div>
                      </div>
                      <div class="ml-1 mt-4" >
                        <h6 class="text-uppercase">Persentase <span class="float-right">{{round($total_ach/$target->target_values * 100,2)}}%</span></h6>
                        <div class="progress progress-sm m-0" style="height: 5px;">
                          
                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{$total_ach/$target->target_values * 100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$total_ach/$target->target_values * 100}}%">
                                <span class="sr-only">{{$total_ach/$target->target_values * 100}}% Complete</span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!--pencapaian & target pareto-->
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
                        $cust_total_p = \App\Customer::where('user_id',$user_id)
                                      ->where('pareto_id',$prt->id)
                                      ->count();
                        
                        $cust_exists_p = \App\Customer::whereHas('orders', function($q) use($user_id,$month,$year)
                                      {
                                          return $q->where('user_id','=',"$user_id")
                                                  ->whereNotNull('customer_id')
                                                  ->whereMonth('created_at', '=', $month)
                                                  ->whereYear('created_at', '=', $year)
                                                  ->where('status','!=','CANCEL')
                                                  ->groupBy('customer_id');
                                      })
                                      ->where('pareto_id',$prt->id)
                                      ->get();
                        
                        //target/pencapaian pareto
                        if($period_par != null){
                            $pr = $prt->id;
                            $target_str = \App\Store_Targets::
                                        whereHas('customers', function($q) use($user_id,$pr)
                                        {
                                            return $q->where('pareto_id',$pr)
                                                      ->where('user_id',$user_id);
                                            
                                        })
                                        ->where('period',$period_par)
                                        ->selectRaw('sum(target_values) as sum')
                                        ->pluck('sum');

                            $total_tp = json_decode($target_str,JSON_NUMERIC_CHECK);
                            $total_target = $total_tp[0];
                          //dd($total_target);
                        
                          //ach pareto
                          $ach_p = \App\Order::whereHas('customers', function($q) use($user_id,$pr)
                                      {
                                          return $q->where('pareto_id',$pr);
                                      })
                                      ->where('user_id','=',"$user_id")
                                      ->whereNotNull('customer_id')
                                      ->whereMonth('created_at', '=', $month)
                                      ->whereYear('created_at', '=', $year)
                                      ->where('status','!=','CANCEL')
                                      ->selectRaw('sum(total_price) as sum')
                                      ->pluck('sum');
                          $total_ap = json_decode($ach_p,JSON_NUMERIC_CHECK);
                          $total_ach_pareto = $total_ap[0];
                        }
                      @endphp

                      <!--jumlah toko pareto-->
                      <div class="col-md-4 mb-3">
                        <div class="box">
                          <i class="fas fa-shopping-cart fa-fw bg-dark" aria-hidden="true"></i>
                          <div class="info">
                            <div class="media-body align-self-center">
                              <div class="text-right">
                                  <h5 class="font-20 my-0 font-weight-bold">
                                    <span data-plugin="counterup">
                                      {{$target ? count($cust_exists_p) : '0'}} / {{$target ? $cust_total_p : '0'}}
                                    </span>
                                  </h5>
                                  <p class="mb-0 mt-1 text-truncate">Pareto Order ({{$prt->pareto_code}}) </p>
                              </div>
                          </div>
                          </div>
                          <div class="ml-1 mt-4" >
                            <h6 class="text-uppercase">Persentase <span class="float-right">{{count($cust_exists_p) ? round(count($cust_exists_p)/$cust_total_p  * 100,2): '0'}}%</span></h6>
                            <div class="progress progress-sm m-0" style="height: 5px;">
                              
                                <div class="progress-bar bg-info" role="progressbar" 
                                    aria-valuenow="{{count($cust_exists_p) ? round(count($cust_exists_p)/$cust_total_p  * 100,2): '0'}}" 
                                    aria-valuemin="0" aria-valuemax="100" style="width: {{count($cust_exists_p) ? round(count($cust_exists_p)/$cust_total_p  * 100,2): '0'}}%">
                                    <span class="sr-only">{{count($cust_exists_p) ? round(count($cust_exists_p)/$cust_total_p  * 100,2): '0'}}% Complete</span>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!--target/pencapaian pareto-->
                      <div class="col-md-4 mb-3">
                        <div class="box">
                          <i class="fas fa-bullseye-arrow fa-fw bg-dark" aria-hidden="true"></i>
                          <div class="info">
                            <div class="media-body align-self-center">
                              <div class="text-right">
                                  <h5 class="font-20 my-0 font-weight-bold">
                                    <span data-plugin="counterup">
                                      {{$period_par ? singkat_angka($total_ach_pareto) : '0'}} / {{$period_par ? singkat_angka($total_target) : '0'}}
                                    </span>
                                  </h5>
                                  <p class="mb-0 mt-1 text-truncate">Pencapaian Pareto ({{$prt->pareto_code}}) </p>
                              </div>
                          </div>
                          </div>
                          <div class="ml-1 mt-4" >
                            <h6 class="text-uppercase">Persentase <span class="float-right">{{($period_par && $total_target) ? round(($total_ach_pareto/$total_target  * 100) ,2) : '0'}}%</span></h6>
                            <div class="progress progress-sm m-0" style="height: 5px;">
                              
                                <div class="progress-bar bg-info" role="progressbar" 
                                    aria-valuenow="{{$period_par && $total_target ? round($total_ach_pareto/$total_target  * 100): '0'}}" 
                                    aria-valuemin="0" aria-valuemax="100" style="width: {{$period_par && $total_target ? round($total_ach_pareto/$total_target  * 100): '0'}}%">
                                    <span class="sr-only">{{$period_par && $total_target ? round($total_ach_pareto/$total_target  * 100): '0'}}% Complete</span>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      
                    @endforeach
                  @endif

                  <!--prediksi pencapaian-->
                  <div class="col-md-4 mb-3" style="display:flex;">
                    <div class="box w-100">
                      <i class="fal fa-analytics fa-fw bg-dark" aria-hidden="true" style="align-items: center"></i>
                      <div class="info">
                        <div class="media-body align-self-center">
                          <div class="text-right">
                              <h5 class="font-20 my-0 font-weight-bold">
                                <span data-plugin="counterup">
                                  {{$target ? singkat_angka($total_ach) : '0'}} / {{$target ? singkat_angka($target->target_values) : '0'}}
                                </span>
                              </h5>
                              <p class="mb-0 mt-1 text-truncate">Prediksi Pencapaian</p>
                          </div>
                        </div>
                      </div>
                      <div class="ml-1 mt-4 text-right" >
                        <h5 class="font-20 my-0 font-weight-bold">@if($target && $work_plan)
                          @php
                              $current_day = date('d');
                              $hari_berjalan = $current_day - $day_off;
                              $hari_kerja = $work_plan->working_days;
                              $prediksi = ($total_ach/$hari_berjalan) * $hari_kerja;
                            @endphp
                          @endif
                          {{($target && $work_plan) ? number_format($prediksi) : '0'}}
                        </h5>
                        
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </section>
          </div>
          
        </div>

        <div class="row justify-content-center" style="">
            <div class="col-12" style="z-index: 2;">
                <section class="statistics">
                    <div class="container-fluid">
                      <div class="row">

                        <div class="col-md-6 mb-3 d-flex">
                          <div class="box w-100">
                            <ul class="list-group w-100">
                              <li class="list-group-item active" style="background-color: #313348;border-color:#313348;color:#CCC">
                                <b>Toko Pareto Belum Order {{date('F Y', strtotime(\Carbon\Carbon::now()))}}</b>
                              </li>
                              @if(count($cust_not_exists) > 0 )
                                @foreach ($cust_not_exists as $item)
                                  <li class="list-group-item"><b>{{$item->store_name}}</b>,<br>{{$item->address}}</li>
                                @endforeach
                              @else
                                <li class="list-group-item"><b>Nihil</b></li>
                              @endif  
                            </ul>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3 d-flex">
                          <div class="box w-100">
                            <ul class="list-group w-100">
                              <li class="list-group-item active" style="background-color: #313348;border-color:#313348;color:#CCC">
                                <b>Toko Pareto Sudah Order {{date('F Y', strtotime(\Carbon\Carbon::now()))}}</b>
                              </li>
                              @if(count($cust_exists) > 0 )
                                @foreach ($cust_exists as $it)
                                  <li class="list-group-item"><b>{{$it->store_name}}</b>,<br>{{$it->address}} 
                                    <!--<span class="badge badge-warning">{{$it->pareto->pareto_code}}</span>-->
                                  </li>
                                @endforeach
                              @else
                                <li class="list-group-item"><b>Nihil</b></li>
                              @endif  
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
            </div>
        </div>
        
        <div class="row justify-content-center" style="">
          <div class="col-12" style="z-index: 2;">
              <section class="statistics">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box">
                          
                            <span><b>Grafik Pencapaian Sales {{date('F Y', strtotime(\Carbon\Carbon::now()))}}</b></span>
                            <span class="float-right">
                              <i class="fas fa-chart-bar"></i>
                            </span>
                            <hr style="width: 100%;">
                            <div id="container"></div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
           </div>
        </div>
        @endif
    </div>

    @include('sweetalert::alert')
@endsection
@section('footer-scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">
    
        if ($(window).width() < 769) {
            $('.modal-dialog-paket').removeClass('modal-lg');
            $('.modal-dialog-paket').addClass('modal-dialog-full-width');
            $('.modal-content-paket').addClass('modal-content-full-width');
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

      $(function () {
        var achievement = <?php echo $percent ?>;
        
        var sales = <?php echo $users_display ?>;
        

        //var colors = ['#dc3545', '#6c757d'];

        var colors = ['#1A4066']

        if ($(window).width() <= 600) {
          var type = 'bar';
        }else if($(window).width() > 600){
          var type = 'column';
        }
        
        $('#container').highcharts({
          chart: {
            type: type
            /*type: 'bar'*/
          },
          title: {
            text: 'Persentase Pencapaian'
          },
          xAxis: {
            categories: sales
          },
          yAxis: {
              title: {
              text: 'Persentase'
            }
          },
          colors:colors,
          series: [/*{
            name: 'Target',
            data: target
          },*/{
            name: 'Pencapaian (%)',
            data: achievement,
          }]
        });
      });
    </script> 
@endsection
