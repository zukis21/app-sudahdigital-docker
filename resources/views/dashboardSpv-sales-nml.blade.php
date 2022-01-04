@php
    $sls_id = $sls->sls_id;
    $pareto = App\Http\Controllers\DashboardController::paretoStore($client->id);
    $target = App\Http\Controllers\DashboardController::salesTargetperSales($sls_id,$month,$year);
    $order_ach = App\Http\Controllers\DashboardController::OrderAchperSales($sls_id,$month,$year);
    [$cust_total,$order]= App\Http\Controllers\DashboardController::totalStoreOrderPerSales($sls_id,$month,$year);
    $period_par = App\Http\Controllers\DashboardController::paramPeriod($date_now);
    
    
    

    if($target){
        $total_ach_ppn = 0;
        foreach($order_ach as $p){
            $PriceTotal = App\Http\Controllers\OrderController::cekDiscountVolume($p->id);
            $total_ach_ppn += $PriceTotal;
            //$total_ach_ppn += $p->total_price;
        }
        $total_ach = $total_ach_ppn/1.1;
        /*if($target->ppn == 1){
            $total_ach = $total_ach_ppn/1.1;
        }else{
            $total_ach = $total_ach_ppn;
        }*/
    }
@endphp

<button class="btn bg-blue-grey waves-effect btn-block m-b-10">{{$sls->sales->name}} (Nml)</button>
<!--total toko order--->
<div class="" style="padding-left:0;padding-right:0;">
    <div class="info-box bg-indigo hover-zoom-effect">
        <!--
        <div class="icon">
            <i class="fal fa-store" style="font-size:32px;"></i>
        </div>
        -->
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
            <div class="text" style="font-size: 10px;">Total Toko Order 
                <span class="pull-right">{{$cust_total == 0 ?  '0' : round((($order/$cust_total) * 100),2)}}%</span></div>
            <div class="progress" style="height: 7px;">
                <div class="progress-bar progress-bar-info progress-bar-striped active" 
                    role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                    style="width: {{$cust_total == 0 ?  '0' : round((($order/$cust_total) * 100),2)}}%;">
                    <span class="sr-only">{{$cust_total == 0 ?  '0' : round((($order/$cust_total) * 100),2)}}% Complete</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!--total toko pareto--->
@if($pareto)
    @foreach($pareto as $prt)
    @php
        //jumlah toko pareto
        $cust_total_p = App\Http\Controllers\DashboardController::total_paretoPerSales($client->id,$sls_id,$prt->id,$date_now);

        $cust_exists_p = App\Http\Controllers\DashboardController::amountParetoOrderPerSales($client->id,$sls_id,$month,$year,$date_now,$prt->id);
    @endphp

    <!--Total toko pareto-->
    <div class="" style="padding-left:0;padding-right:0;margin-top:-20px">
        <div class="info-box bg-indigo hover-zoom-effect">
            <!--
            <div class="icon">
                <i class="fad fa-store" style="font-size:32px;"></i>
            </div>
            -->
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
                <div class="text" style="font-size: 10px;">Total Toko Pareto ({{$prt->pareto_code}}) 
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
<div class="" style="padding-left:0;padding-right:0;margin-top:-20px">
    @if($target)
      @php
        $ach_quantity = App\Http\Controllers\DashboardController::achQuantityPerSales($sls_id,$month,$year);
      @endphp
    @endif
    @if($target)
      <div class="info-box bg-light-green hover-zoom-effect">
        <!--
        <div class="icon">
            <i class="fal fa-bullseye-arrow" aria-hidden="true" style="font-size:32px;"></i>
        </div>
        -->
        <div class="content" style="width:100%;">
            <div class="text-right">
                <span class="font-weight-bold h4" 
                    style="border:1px solid #fff; 
                        border-radius: 5px;
                        position:absolute;
                        right:10px;
                        top:0;
                        padding:2px;">
                {{$target ? singkat_angka($total_ach) : '0'}} / {{$target ? singkat_angka($target->target_values) : '0'}}
                </span>
                <p class="m-t-10 text-truncate">&nbsp;</p>
            </div>
            <div class="text" style="font-size: 10px;">Target Sales Total 
                <span class="pull-right">
                    @if($target)
                        {{ $target->target_values == 0 ?  '0' : round((($total_ach/$target->target_values) * 100) ,2)}}%
                    @else
                     {{0}}%
                    @endif
                </span>
            </div>
            <div class="progress" style="height: 7px;">
                <div class="progress-bar progress-bar-info progress-bar-striped active" 
                    role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                    @if($target) style="width: {{ $target->target_values == 0 ?  '0' : round((($total_ach/$target->target_values) * 100) ,2)}}%;"
                    @else style="width: {{0}}%;"
                    @endif>
                    <span class="sr-only">
                        @if($target) {{ $target->target_values == 0 ?  '0' : round((($total_ach/$target->target_values) * 100) ,2)}}% Complete
                        @else 
                        {{0}}% Complete
                        @endif
                    </span>
                </div>
            </div>
        </div>
      </div>
    @else
      <div class="info-box bg-light-green hover-zoom-effect">
        <!--
        <div class="icon">
            <i class="fal fa-bullseye-arrow" aria-hidden="true" style="font-size:32px;"></i>
        </div>
        -->
        <div class="content" style="width:100%;">
            <div class="text-right">
                <span class="font-weight-bold h4" 
                    style="border:1px solid #fff; 
                        border-radius: 5px;
                        position:absolute;
                        right:10px;
                        top:0;
                        padding:2px;">
                0 / 0
                </span>
                <p class="m-t-10 text-truncate">&nbsp;</p>
            </div>
            <div class="text" style="font-size: 10px;">Target Sales Total 
                <span class="pull-right">
                    @if($target)
                        {{ $target->target_quantity == 0 ?  '0' : round((($ach_quantity/$target->target_quantity) * 100) ,2)}}%
                    @else
                     {{0}}%
                    @endif
                </span>
            </div>
            <div class="progress" style="height: 7px;">
                <div class="progress-bar progress-bar-info progress-bar-striped active" 
                    role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                    @if($target) style="width: {{ $target->target_quantity == 0 ?  '0' : round((($ach_quantity/$target->target_quantity) * 100) ,2)}}%;"
                    @else style="width: {{0}}%;"
                    @endif>
                    <span class="sr-only">
                        @if($target) {{ $target->target_quantity == 0 ?  '0' : round((($ach_quantity/$target->target_quantity) * 100) ,2)}}% Complete
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
                $target_str = App\Http\Controllers\DashboardController::TrgValParetoPerSales($sls_id,$period_par,$pr);
                //$total_tp = json_decode($target_str,JSON_NUMERIC_CHECK);
                //$total_target = $total_tp[0];
                $total_target = $target_str;
                
                //target qty pareto
                $target_tqp = App\Http\Controllers\DashboardController::TrgQtyParetoPerSales($sls_id,$period_par,$pr);
                //$total_tqp = json_decode($target_tqp,JSON_NUMERIC_CHECK);
                $total_trgqp = $target_tqp;
                    
                //ach pareto nominal values
                $ach_p = App\Http\Controllers\DashboardController::achUserParetoPerSales($sls_id,$month,$year,$pr,$period_par);

                //ach pareto qty values
                $ach_qty_p = App\Http\Controllers\DashboardController::achUsrTgQtyParetoPerSales($sls_id,$month,$year,$pr,$period_par);
                
                $per_par_type = App\Http\Controllers\DashboardController::PeriodType($period_par);
                
                $total_ach_pareto = $ach_p;

                /*$total_ap = json_decode($ach_p,JSON_NUMERIC_CHECK);
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
        <div class="" style="padding-left:0;padding-right:0;margin-top:-20px">
            <div class="info-box bg-light-green hover-zoom-effect">
                <!--
                <div class="icon">
                    <i class="fad fa-bullseye-arrow" aria-hidden="true" style="font-size:32px;"></i>
                </div>
                -->
                <div class="content" style="width:100%;">
                    <div class="text-right">
                        <span class="font-weight-bold h4" 
                            style="border:1px solid #fff; 
                                border-radius: 5px;
                                position:absolute;
                                right:10px;
                                top:0;
                                padding:2px;">
                        {{$period_par ? singkat_angka($total_ach_pareto) : '0'}} / {{$period_par ? singkat_angka($total_target) : '0'}}
                        </span>
                        <p class="m-t-10 text-truncate">&nbsp;</p>
                    </div>
                    <div class="text" style="font-size: 10px;">Target Sales Pareto ({{$prt->pareto_code}})
                        <span class="pull-right">
                            {{($period_par && $total_target) ? round((($total_ach_pareto/$total_target)  * 100) ,2) : '0'}}%
                        </span>
                    </div>
                    <div class="progress" style="height: 7px;">
                        <div class="progress-bar progress-bar-info progress-bar-striped active" 
                            role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                            style="width: {{$period_par && $total_target ? round((($total_ach_pareto/$total_target)  * 100),2): '0'}}%">
                            <span class="sr-only">
                                {{$period_par && $total_target ? round((($total_ach_pareto/$total_target)  * 100),2): '0'}}% Complete
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endif


<!--prediksi pencapaian-->
<div class="" style="padding-left:0;padding-right:0;margin-top:-20px">
    <div class="info-box bg-red hover-zoom-effect">
        <!--
        <div class="icon">
            <i class="fal fa-analytics " aria-hidden="true" style="font-size:32px;"></i>
        </div>
        -->
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
                    //$current_day = date('d');
                    $hari_berjalan = ((int)$current_day) - $day_off;
                    $hari_kerja = $work_plan->working_days;
                    $prediksi = ($total_ach/$hari_berjalan) * $hari_kerja;
                    @endphp
                @endif
                {{($target && $work_plan) ? singkat_angka($prediksi) : '0'}} / {{$target ? singkat_angka($target->target_values) : '0'}}
                </span>
                <p class="m-t-20 text-truncate">&nbsp;</p>
              </div>
            <div class="text" style="font-size: 10px;">
                Prediksi Pencapaian
                <span class="pull-right" style="font-size: 10px;">
                    @if($target && $work_plan)
                        {{ $target->target_values == 0 ?  '0' : round((($prediksi/$target->target_values) * 100) ,2)}}%
                    @else
                    {{0}}%
                    @endif
                </span> 
            </div>
            
        </div>
    </div>
</div>

<!--Average Daily-->
@php
  $max_av_qty = App\Http\Controllers\DashboardController::MaxYearQuantityPerSales($sls_id,$year);
  $max_av = App\Http\Controllers\DashboardController::MaxYearNominalPerSales($sls_id,$year);
@endphp
<div class="" style="padding-left:0;padding-right:0;margin-top:-20px; margin-bottom:-30px">
    <div class="info-box bg-red hover-zoom-effect">
         
        <div class="icon bg-red">
            <!--
            <i class="fas fa-tachometer-average " aria-hidden="true" style="font-size:32px;"></i>
            -->
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
                {{($target && $work_plan) ? singkat_angka($total_ach/$hari_berjalan) : '0'}} / {{singkat_angka($max_av)}}
                </span>
                <p class="m-t-20 text-truncate">&nbsp;</p>
            </div>
            <div class="text m-l--55 m-r-55" style="font-size: 10px;width:100%;">Avg Daily / Avg Max Daily </div>
              
        </div>
        
    </div>
</div>


