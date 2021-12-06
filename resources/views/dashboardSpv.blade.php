@php
    [$cust_total,$order]= App\Http\Controllers\DashboardController::totalStoreOrder($client->id);
    $pareto = App\Http\Controllers\DashboardController::paretoStore($client->id);
    $target = App\Http\Controllers\DashboardController::salesTarget($client->id);
    $period_par = App\Http\Controllers\DashboardController::paramPeriod();
    $spv_id = Auth::user()->id;
    $month = date('m');
    $year = date('Y');
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

    //dd($target);
    /*$total_ach_ppn = 0;
    foreach($order_ach as $p){
        $total_ach_ppn += $p->total_price;
    }*/

    if($target){
        $trNmnlTotal = 0;
        $trQtyTotal = 0;
        foreach($target as $trSls){
            $trNmnlTotal += $trSls->target_values;
            $trQtyTotal += $trSls->target_quantity;
        }
    }
    /*
    if($target->ppn == 1){
        $total_ach = $total_ach_ppn/1.1;
    }else{
        $total_ach = $total_ach_ppn;
    }*/
@endphp


<!--total toko order--->
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="info-box bg-indigo hover-zoom-effect">
        <div class="icon">
            <i class="fal fa-store" style="font-size:32px;"></i>
        </div>
        <div class="content" style="width:100%;">
            <div class="text-right">
                <span class="font-weight-bold h4" 
                    style="border:1px solid #fff; 
                           border-radius: 5px;
                           position:absolute;
                           right:10px;
                           top:0;
                           padding:2px;">
                  {{$order}} / {{$cust_total}}
                </span>
                <p class="m-t-10 text-truncate">&nbsp;</p>
              </div>
            <div class="text">Total Toko Order <span class="pull-right">{{round((($order/$cust_total) * 100),2)}}%</span></div>
            <div class="progress" style="height: 7px;">
                <div class="progress-bar progress-bar-info progress-bar-striped active" 
                    role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                    style="width: {{($order/$cust_total) * 100}}%;">
                    <span class="sr-only">{{($order/$cust_total) * 100}}% Complete</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!--total toko pareto--->
@if($pareto)
    @php
    $date_now = date('Y-m-d');
    $month = date('m');
    $year = date('Y');
    @endphp
    @foreach($pareto as $prt)
    @php
        //jumlah toko pareto
        $cust_total_p = App\Http\Controllers\DashboardController::total_pareto($client->id,$prt->id);

        $cust_exists_p = App\Http\Controllers\DashboardController::amountParetoOrder($client->id,$month,$year,$prt->id);
    @endphp

    <!--Total toko pareto-->
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-indigo hover-zoom-effect">
            <div class="icon">
                <i class="fad fa-store" style="font-size:32px;"></i>
            </div>
            <div class="content" style="width:100%;">
                <div class="text-right">
                    <span class="font-weight-bold h4" 
                        style="border:1px solid #fff; 
                               border-radius: 5px;
                               position:absolute;
                               right:10px;
                               top:0;
                               padding:2px;">
                      {{count($cust_exists_p)}} / {{$cust_total_p }}
                    </span>
                    <p class="m-t-10 text-truncate">&nbsp;</p>
                  </div>
                <div class="text">Total Toko Pareto ({{$prt->pareto_code}}) 
                    <span class="pull-right">{{count($cust_exists_p) ? round(((count($cust_exists_p)/$cust_total_p)  * 100),2): '0'}}%</span>
                </div>
                <div class="progress" style="height: 7px;">
                    <div class="progress-bar progress-bar-info progress-bar-striped active" 
                        role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                        style="width:{{count($cust_exists_p) ? round(((count($cust_exists_p)/$cust_total_p)  * 100),2): '0'}}%;">
                        <span class="sr-only">{{count($cust_exists_p) ? round(((count($cust_exists_p)/$cust_total_p)  * 100),2): '0'}}% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @endforeach
@endif

<!--Target Sales Total-->
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" data-aos="zoom-in">
    @if($target)
      @php
        $ach_quantity = App\Http\Controllers\DashboardSalesController::achQuantity($client->id);
      @endphp
    @endif
    @if($target)
      <div class="info-box bg-light-green hover-zoom-effect">
        <div class="icon">
            <i class="fal fa-bullseye-arrow" aria-hidden="true" style="font-size:32px;"></i>
        </div>
        <div class="content" style="width:100%;">
            <div class="text-right">
                <span class="font-weight-bold h4" 
                    style="border:1px solid #fff; 
                        border-radius: 5px;
                        position:absolute;
                        right:10px;
                        top:0;
                        padding:2px;">
                {{$target ? $ach_quantity : '0'}} / {{$target ? $trQtyTotal : '0'}}
                </span>
                <p class="m-t-10 text-truncate">&nbsp;</p>
            </div>
            <div class="text">Target Sales Total 
                <span class="pull-right">
                    @if($target)
                        {{ $trQtyTotal == 0 ?  '0' : round((($ach_quantity/$trQtyTotal) * 100) ,2)}}%
                    @else
                     {{0}}%
                    @endif
                </span>
            </div>
            <div class="progress" style="height: 7px;">
                <div class="progress-bar progress-bar-info progress-bar-striped active" 
                    role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                    @if($target) style="width: {{ $trQtyTotal == 0 ?  '0' : round((($ach_quantity/$trQtyTotal) * 100) ,2)}}%;"
                    @else style="width: {{0}}%;"
                    @endif>
                    <span class="sr-only">
                        @if($target) {{ $trQtyTotal == 0 ?  '0' : round((($ach_quantity/$trQtyTotal) * 100) ,2)}}% Complete
                        @else 
                        {{0}}% Complete
                        @endif
                    </span>
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
            if($period_par){
               
                $pr = $prt->id;
            
                //target val pareto
                $target_str = App\Http\Controllers\DashboardController::TrgValPareto($spv_id,$period_par,$pr);
                //$total_tp = json_decode($target_str,JSON_NUMERIC_CHECK);
                //$total_target = $total_tp[0];
                $total_target = $target_str;
                
                //target qty pareto
                $target_tqp = App\Http\Controllers\DashboardController::TrgQtyPareto($spv_id,$period_par,$pr);
                //$total_tqp = json_decode($target_tqp,JSON_NUMERIC_CHECK);
                $total_trgqp = $target_tqp;
                    
                //ach pareto nominal values
                $ach_p = App\Http\Controllers\DashboardController::achUserPareto($spv_id,$month,$year,$pr,$period_par);

                //ach pareto qty values
                $ach_qty_p = App\Http\Controllers\DashboardController::achUsrTgQtyPareto($spv_id,$month,$year,$pr,$period_par);
                
                $per_par_type = App\Http\Controllers\DashboardController::PeriodType($period_par);
                
                $total_ap = json_decode($ach_p,JSON_NUMERIC_CHECK);
                $total_ach_pareto = $total_ap[0];
                /*$total_ach_pareto_ppn = $total_ap[0];
                if($target->ppn == 1){
                    $total_ach_pareto = $total_ach_pareto_ppn/1.1;
                }else{
                    $total_ach_pareto = $total_ach_pareto_ppn;
                }*/
            }
        @endphp
        <!--target/pencapaian pareto-->
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" data-aos="zoom-in">
            <div class="info-box bg-light-green hover-zoom-effect">
                <div class="icon">
                    <i class="fad fa-bullseye-arrow" aria-hidden="true" style="font-size:32px;"></i>
                </div>
                <div class="content" style="width:100%;">
                    <div class="text-right">
                        <span class="font-weight-bold h4" 
                            style="border:1px solid #fff; 
                                border-radius: 5px;
                                position:absolute;
                                right:10px;
                                top:0;
                                padding:2px;">
                        {{$period_par ? $ach_qty_p : '0'}} / {{$period_par ? $total_trgqp : '0'}}
                        </span>
                        <p class="m-t-10 text-truncate">&nbsp;</p>
                    </div>
                    <div class="text">Target Sales Pareto ({{$prt->pareto_code}})
                        <span class="pull-right">
                            {{($period_par && $total_trgqp) ? round((($ach_qty_p/$total_trgqp)  * 100) ,2) : '0'}}%
                        </span>
                    </div>
                    <div class="progress" style="height: 7px;">
                        <div class="progress-bar progress-bar-info progress-bar-striped active" 
                            role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                            style="width: {{$period_par && $total_trgqp ? round((($ach_qty_p/$total_trgqp)  * 100),2): '0'}}%">
                            <span class="sr-only">
                                {{$period_par && $total_trgqp ? round((($ach_qty_p/$total_trgqp)  * 100),2): '0'}}% Complete
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<!--prediksi pencapaian-->
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="info-box bg-red hover-zoom-effect">
        <div class="icon">
            <i class="fal fa-analytics " aria-hidden="true" style="font-size:32px;"></i>
        </div>
        <div class="content" style="width:100%;">
            <div class="text-right">
                <span class="font-weight-bold h4" 
                    style="border:1px solid #fff; 
                           border-radius: 5px;
                           position:absolute;
                           right:10px;
                           top:0;
                           padding:2px;">
                  @if($target && $work_plan)
                    @php
                    $current_day = date('d');
                    $hari_berjalan = ((int)$current_day) - $day_off;
                    $hari_kerja = $work_plan->working_days;
                    $prediksi_qty = ($ach_quantity/$hari_berjalan) * $hari_kerja;
                    @endphp
                @endif
                {{($target && $work_plan) ? $prediksi_qty : '0'}} / {{$target ? $trQtyTotal : '0'}}
                </span>
                <p class="m-t-10 text-truncate">&nbsp;</p>
              </div>
            <div class="text">Prediksi Pencapaian </div>
            
        </div>
    </div>
</div>

<!--Average Daily-->
@php
  $max_av_qty = App\Http\Controllers\DashboardSalesController::MaxYearQuantity();
@endphp
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="info-box bg-red hover-zoom-effect">
        <div class="icon">
            <i class="fas fa-tachometer-average " aria-hidden="true" style="font-size:32px;"></i>
        </div>
        <div class="content" style="width:100%;">
            <div class="text-right">
                <span class="font-weight-bold h4" 
                    style="border:1px solid #fff; 
                           border-radius: 5px;
                           position:absolute;
                           right:10px;
                           top:0;
                           padding:2px;">
                {{($target && $work_plan) ? $ach_quantity/$hari_berjalan : '0'}} / {{$max_av_qty}}
                </span>
                <p class="m-t-10 text-truncate">&nbsp;</p>
              </div>
            <div class="text">Average Daily / Average Max Daily </div>
            
        </div>
    </div>
</div>


