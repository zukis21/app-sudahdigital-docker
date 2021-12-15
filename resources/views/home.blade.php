@extends('layouts.master')
@section('title') {{Gate::check('isSpv') ? 'Dashboard' : 'Home'}} @endsection
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
        <style>
            .profile-card .profile-header {
                background-color: #3F51B5;
                padding: 42px 0;
            }
            .tab-pane ul{
                margin-left: -10px;
            }
        </style>
    @elseif(Gate::check('isOwner'))
    <style>
        .profile-card .profile-header {
            background-color: #FFC107;
            padding: 42px 0;
        }
        .tab-pane ul{
            margin-left: -10px;
        }
    </style>
    @endif
    <!--
    Hi <strong>{{ auth()->user()->name }}</strong>,
    {{ __('You are logged in as') }}
    @can('isSuperadmin')
        <span class="badge bg-green">Superadmin</span>
    @elsecan('isAdmin')
        <span class="badge bg-green">Admin</span>
    @elsecan('isSpv')
        <span class="badge bg-green">Supervisor</span>
    @endcan
    -->
    @can('isSpv')
    <style>
        
        .flex-nowrap {
            -webkit-flex-wrap: nowrap!important;
            -ms-flex-wrap: nowrap!important;
            flex-wrap: nowrap!important;
        }
        .flex-row {
            display:flex;
            -webkit-box-orient: horizontal!important;
            -webkit-box-direction: normal!important;
            -webkit-flex-direction: row!important;
            -ms-flex-direction: row!important;
            flex-direction: row!important;
        }

        .flex-row > .col-xs-3 {
            display:flex;
            flex: 0 0 25%;
            max-width: 25%
        }

        .well {
            padding:5px;
        }

        .flip-box {
            position: relative;
            background-color: transparent;
            width: 100%;
        }

        .flip-box-inner {
            width: 100%;
            height: 100%;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }

        .flip-box.hover .flip-box-inner {
            transform: rotateY(180deg);
        }

        .flip-box-front, .flip-box-back {
            position:absolute;
            width: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .flip-box-back {
            transform: rotateY(180deg);
        }

        .nav-tabs li a:hover {
            background-color: #F8F8F8 !important; 
        }

        .nav-tabs li a {
            background-color: transparent !important; 
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }

        input:invalid {
            border: solid red 3px;
        }

    </style>
        <!--Hi <strong>{{ auth()->user()->name }}</strong>,
        {{ __('You are logged in as') }}
        <span class="badge bg-green">Supervisor</span>-->
        <?php
            $date_now = $date_now;
            $month = $month;
            $year = $year;
            $period_sales = App\Http\Controllers\DashboardController::periodSalesTarget($client->id);
            $param_typeAll = App\Http\Controllers\DashboardController::paramTypeAll($client->id,date('Y-m-01',strtotime($date_now)));
            $sales= App\Http\Controllers\DashboardController::salesList(Auth::user()->id);
            function singkat_angka($n, $presisi=1) {
            if ($n < 900) {
                $format_angka = number_format($n, $presisi);
                $simbol = '';
                } else if ($n < 900000) {
                $format_angka = number_format($n / 1000, $presisi);
                $simbol = ' k';
                } else if ($n < 900000000) {
                $format_angka = number_format($n / 1000000, $presisi);
                $simbol = ' M';
                } else if ($n < 900000000000) {
                $format_angka = number_format($n / 1000000000, $presisi);
                $simbol = ' B';
                } else {
                $format_angka = number_format($n / 1000000000000, $presisi);
                $simbol = ' Tr';
                }
            
                if ( $presisi > 0 ) {
                $pisah = '.' . str_repeat( '0', $presisi );
                $format_angka = str_replace( $pisah, '', $format_angka );
                }
                
                return $format_angka . $simbol;
            }
        ?>
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <h2>Dashboard {{$period_info}}</h2>
                </div>
            </div>
            <div class="row">
                <form id="form_validation" action="{{route('home_admin',[$vendor])}}" method="POST">
                    @csrf 
                    <input type="hidden" name="_method" value="GET">
                    <div class="col-sm-6 m-t-10 p-l-0">
                        <div class="form-group">
                            <select name="period"  id="period_list" 
                                class="form-control" style="width:100%;" required>
                                <option></option>
                                @foreach($period_sales as $key => $psl)
                                    <option value="{{$psl->period}}" {{(\Route::currentRouteName() == 'home_admin') && ($period_info == date('F, Y', strtotime($psl->period))) ? 'selected' : ''}}>
                                        {{date('F Y', strtotime($psl->period))}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-primary waves-effect m-t-10" type="submit">Filter</button>
                        @if (\Route::currentRouteName() == 'home_admin' && $param_reset == 1)
                            <a href="{{route('home_admin',[$vendor])}}" class="btn btn-danger waves-effect m-t-10">Reset</a>
                        @endif
                        <!--
                        <a class="btn waves-effect btn-success pull-right m-t-10"
                            data-toggle="modal" data-target="#ExportModal">
                            <i class="fas fa-file-excel fa-1x"></i> 
                        </a>
                        -->
                    </div>
                </form>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row">
                <ul class="nav nav-tabs tab-nav-right nav-justified" role="tablist" style="border-bottom: none;margin-left:2px;">
                    <li role="presentation " class="active"><a href="#home" data-toggle="tab">PERFORMANCE</a></li>
                    <li role="presentation"><a href="#storeInfoOrder" data-toggle="tab">STORE ORDERING STATS</a></li>
                    <li role="presentation"><a href="#comingSoon" data-toggle="tab">CHART</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane animated fadeInRight active" id="home">
                        
                        <div class="flex-row flex-nowrap">
                            <div class="col-xs-3" style="padding-left:0;padding-right:5px;">
                                <div class="flip-box all-dash" @if($param_typeAll == 3) onclick="flipAll()" @endif>
                                    <div class="flip-box-inner">
                                        @if($param_typeAll == 1)
                                            <div class="flip-box-front">
                                                <div class="well">
                                                    @include('dashboardSpv')
                                                </div>
                                            </div>
                                        @elseif($param_typeAll == 2)
                                            <div class="flip-box-front">
                                                <div class="well">
                                                    @include('dashboardSpv-nml')
                                                </div>
                                            </div>
                                        @elseif($param_typeAll == 3)
                                            <div class="flip-box-front">
                                                <div class="well">
                                                    @include('dashboardSpv')
                                                </div>
                                            </div>
                                            <div class="flip-box-back">
                                                <div class="well">
                                                    @include('dashboardSpv-nml')
                                                </div>
                                            </div>
                                        @else
                                            <div class="well">
                                                <button class="btn bg-blue-grey waves-effect btn-block m-b-10">ALL</button>
                                                <div class="demo-color-box bg-red">
                                                    <div class="color-class-name">NO DATA</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @foreach($sales as $sls)
                                @php
                                    $type_targetSls = App\Http\Controllers\DashboardController::salesType($sls->sls_id,date('Y-m-01',strtotime($date_now)));
                                @endphp
                                
                                <div class="col-xs-3" style="padding-left:5px;padding-right:5px;">
                                    <div class="flip-box" id="dash{{$sls->sls_id}}"
                                        @if($type_targetSls && $type_targetSls->target_type == 3) 
                                            onclick="flipsls({{$sls->sls_id}})"
                                        @endif>
                                        <div class="flip-box-inner">
                                            @if($type_targetSls && $type_targetSls->target_type == 1)
                                                <div class="flip-box-front">
                                                    <div class="well">
                                                        @include('dashboardSpv-sales')
                                                    </div>
                                                </div>
                                        @elseif($type_targetSls && $type_targetSls->target_type == 2)
                                                <div class="flip-box-front">
                                                    <div class="well">
                                                        @include('dashboardSpv-sales-nml')
                                                    </div>
                                                </div>
                                            @elseif($type_targetSls && $type_targetSls->target_type == 3)
                                                <div class="flip-box-front">
                                                    <div class="well">
                                                        @include('dashboardSpv-sales')
                                                    </div>
                                                </div>
                                                <div class="flip-box-back">
                                                    <div class="well">
                                                        @include('dashboardSpv-sales-nml')
                                                    </div>
                                                </div>
                                            @else
                                                <div class="well">
                                                    <button class="btn bg-blue-grey waves-effect btn-block m-b-10">{{$sls->sales->name}}</button>
                                                    <div class="demo-color-box bg-red">
                                                        <div class="color-class-name">Target has not been created</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>    
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="storeInfoOrder">
                        <div class="card">
                            
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sales</th>
                                                <th>Store Hasn't Ordered (P)</th>
                                                <th>Store Has Ordered (P)</th>
                                                <th>
                                                    Orders Not Delivered > 
                                                        <input type="number" value="5" min="1"
                                                        class="input-sm" id="numberDay" 
                                                        style="text-align:center;
                                                               border:1px solid #ccc;
                                                               width:50px;
                                                               margin-bottom:-10px;">
                                                    Days
                                                </th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody id="body_table">
                                            
                                            @foreach($sales as $sls)
                                                <?php
                                                    [$cust_not_exists,$cust_exists,$order_overday] = App\Http\Controllers\DashboardController::storeNotOrder($sls->sls_id,$month,$year,$date_now);
                                                ?>
                                                
                                                <tr>
                                                    <td>
                                                        {{$sls->sales->name}}
                                                    </td> 
                                                    <td>
                                                        <a href="" data-toggle="modal" data-target="#notOrderModal{{$sls->sls_id}}">
                                                            <span class="badge bg-red">{{count($cust_not_exists)}}</span>
                                                        </a>
                                                        <div class="modal fade" id="notOrderModal{{$sls->sls_id}}" tabindex="-1" role="dialog" style="display: none;">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Store Hasn't Ordered Lists</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <ul class="list-group">
                                                                            @if(count($cust_not_exists) > 0 )
                                                                                <?php $last_orders = Array(); ?>
                                                                                @foreach ($cust_not_exists as $item)
                                                                                    @php
                                                                                    $last_order = App\Http\Controllers\DashboardController::lastOrder($item->id,$date_now);
                                                                                    array_push($last_orders, $last_order);
                                                                                    @endphp
                                                                                @endforeach
                                                                                @php 
                                                                                    arsort($last_orders);
                                                                                    $keys = array_keys($last_orders);
                                                                                @endphp
                                                                                @foreach($keys as $key)
                                                                                    <?php $cust_id = $cust_not_exists[$key]->id;?>
                                                                                    <li class="list-group-item">
                                                                                        <b>{{$cust_not_exists[$key]->store_code}} - {{$cust_not_exists[$key]->store_name}}</b>,
                                                                                        @if($last_orders[$key] != '')
                                                                                            <span class="badge bg-cyan popoverData" id="popoverData" data-trigger="hover" data-container="body" data-placement="top" 
                                                                                            data-content="{{$last_orders[$key] == '' ? '': 'Number of days hasn\'t ordered'}}">{{$last_orders[$key]}} Days</span> 
                                                                                        @endif   
                                                                                        <br><span>{{$cust_not_exists[$key]->address}}</span><br>
                                                                                        @php
                                                                                            [$visit_off,$visit_on] = App\Http\Controllers\DashboardController::visitNoOrder($cust_id,$month,$year);
                                                                                            $visit = $visit_off + $visit_on;
                                                                                        @endphp
                                                                                        @if($visit_off > 0 )
                                                                                            
                                                                                            <i class="fal fa-location-slash text-danger popoverData"  data-trigger="hover" data-container="body" data-placement="top" 
                                                                                            data-content="Checkout Without order & On Location."></i><b class="text-danger m-r-10">{{$visit_off}}</b>
                                                                                           
                                                                                        @endif
                                                                                        @if($visit_on > 0)
                                                                                            
                                                                                            <i class="fal fa-location text-danger popoverData" data-trigger="hover" data-container="body" data-placement="top" 
                                                                                            data-content="Checkout Without order & On Location."></i><b class="text-danger">{{$visit_on}}</b>
                                                                                            
                                                                                        @endif
                                                                                    </li>
                                                                                @endforeach
                                                                            @else
                                                                                <li class="list-group-item border-0" style="color: #1A4066;border-bottom-right-radius:0;
                                                                                border-bottom-left-radius:0;"><b>No store lists</b></li>
                                                                            @endif  
                                                                        </ul>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="" data-toggle="modal" data-target="#orderModal{{$sls->sls_id}}">
                                                            <span class="badge bg-green">{{count($cust_exists)}}</span>
                                                        </a>
                                                        <div class="modal fade" id="orderModal{{$sls->sls_id}}" tabindex="-1" role="dialog" style="display: none;">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Store Hasn't Ordered Lists</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <ul class="list-group">
                                                                            @if(count($cust_exists) > 0 )
                                                                                <?php $last_odrs = Array(); ?>
                                                                                @foreach ($cust_exists as $it)
                                                                                @php
                                                                                    $last_odr = App\Http\Controllers\DashboardController::lastOrder($it->id,$date_now);
                                                                                    array_push($last_odrs, $last_odr);
                                                                                @endphp
                                                                                @endforeach
                                                                                @php 
                                                                                asort($last_odrs);
                                                                                $keys_exists = array_keys($last_odrs);
                                                                                @endphp
                                                                                @foreach($keys_exists as $k)
                                                                                    <?php $cust_id_ex = $cust_exists[$k]->id;?>
                                                                                    <li class="list-group-item">
                                                                                        <b>{{$cust_exists[$k]->store_code}} - {{$cust_exists[$k]->store_name}}</b>,
                                                                                        @if($last_odrs[$k] != '')
                                                                                            <span class="badge bg-cyan popoverData" id="popoverData" data-trigger="hover" data-container="body" data-placement="top" 
                                                                                            data-content="{{$last_odrs[$k] == '' ? '': 'Number of days hasn\'t ordered'}}">{{$last_odrs[$k]}} Days</span> 
                                                                                        @endif   
                                                                                        <br><span>{{$cust_exists[$k]->address}}</span><br>
                                                                                        @php
                                                                                            [$NoOdrVisit_off,$NoOdrVisit_on] = App\Http\Controllers\DashboardController::visitNoOrder($cust_id_ex,$month,$year);
                                                                                            [$OdrVisit_off,$OdrVisit_on] = App\Http\Controllers\DashboardController::visitOrder($cust_id_ex,$month,$year);
                                                                                            $visit_noorder = $NoOdrVisit_off + $NoOdrVisit_on;
                                                                                            $order_visit = $OdrVisit_off + $OdrVisit_on;
                                                                                        @endphp
                                                                                        @if($NoOdrVisit_off > 0 )
                                                                                            
                                                                                            <i class="fal fa-location-slash text-danger popoverData"  
                                                                                            data-trigger="hover" data-container="body" data-placement="top" 
                                                                                            data-content="Checkout Without order & On Location."></i>
                                                                                            <b class="text-danger m-r-10">{{$NoOdrVisit_off}}</b>
                                                                                           
                                                                                        @endif
                                                                                        @if($NoOdrVisit_on > 0)
                                                                                            
                                                                                            <i class="fal fa-location text-danger popoverData" 
                                                                                            data-trigger="hover" data-container="body" data-placement="top" 
                                                                                            data-content="Checkout Without order & On Location."></i>
                                                                                            <b class="text-danger">{{$NoOdrVisit_on}}</b>
                                                                                            
                                                                                        @endif
                                                                                        @if($OdrVisit_off > 0 )
                                                                                            <br>
                                                                                            <i class="fal fa-location-slash popoverData" style="color:#3F51B5" 
                                                                                            data-trigger="hover" data-container="body" data-placement="top" 
                                                                                            data-content="Order Off Location."></i>
                                                                                            <b class="text-primary m-r-10" style="color:#3F51B5">{{$OdrVisit_off}}</b>
                                                                                        
                                                                                        @endif

                                                                                        @if($OdrVisit_on > 0)
                                                                                            <br>
                                                                                            <i class="fal fa-location popoverData"  style="color:#3F51B5"
                                                                                            data-trigger="hover" data-container="body" data-placement="top" 
                                                                                            data-content="Order On Location."></i>
                                                                                            <b class="text-primary" style="color:#3F51B5">{{$OdrVisit_on}}</b>
                                                                                        
                                                                                        @endif
                                                                                    </li>
                                                                                @endforeach
                                                                            @else
                                                                                <li class="list-group-item border-0" style="color: #1A4066;border-bottom-right-radius:0;
                                                                                border-bottom-left-radius:0;"><b>No store lists</b></li>
                                                                            @endif  
                                                                        </ul>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <div id="body_overday">
                                                        <td>
                                                        
                                                            <a href="" data-toggle="modal" data-target="#overdayModal{{$sls->sls_id}}">
                                                                <span class="badge bg-orange" id="overD{{$sls->sls_id}}">{{count($order_overday)}}</span>
                                                            </a>
                                                            <div class="modal fade" id="overdayModal{{$sls->sls_id}}" tabindex="-1" role="dialog" style="display: none;">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="defaultModalLabel">Orders Not Delivered > 5 Days</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <ul class="list-group">
                                                                                @if(count($order_overday) > 0 )
                                                                                    @foreach ($order_overday as $over)
                                                                                        <li class="list-group-item">
                                                                                            <b class="text-success">#{{$over->invoice_number}}</b><br>
                                                                                            <b>{{$over->customer_id ? $over->customers->store_name : ''}}</b>,
                                                                                            <br><span>{{$over->customer_id ? $over->customers->address :''}}</span><br>
                                                                                        </li>
                                                                                    @endforeach
                                                                                @else
                                                                                    <li class="list-group-item border-0" style="color: #1A4066;border-bottom-right-radius:0;
                                                                                    border-bottom-left-radius:0;"><b>No store lists</b></li>
                                                                                @endif  
                                                                            </ul>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                        </td>
                                                    </div>
                                                </tr>
                                            @endforeach
                                           
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane animated flash" id="comingSoon">
                        <h4 class="text-center">Coming Soon...</h4>
                    </div>
                </div>
            </div>
        </div>
        
    @endcan
    @if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-4">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <div class="profile-body">
                            <div class="image-area">
                                <img src="{{ asset('assets/image'.$client->client_image)}}" width="130" height="130" alt="image-logo" />
                            </div>
                            <div class="content-area">
                                <h3>{{$client->client_name}}</h3>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <!--<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Profile Details</a></li>-->
                                    <li role="presentation"  class="{{$msgs ? '' : 'active'}}">
                                        <a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">Profile Detail</a>
                                    </li>
                                    <li role="presentation" class="{{$msgs ? 'active' : ''}}">
                                        <a href="#wa_setting" aria-controls="settings" role="tab" data-toggle="tab">WA Ordering Tittle Setting</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <!--
                                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                                        <ul>
                                            <li>
                                                <label class="form-label">Name</label>
                                            </li>
                                            <small class="text-muted">{{$client->client_name}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Shop/Company Name</label>
                                            </li>
                                            <small class="text-muted">{{$client->company_name ? "$client->company_name" : '-'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Email</label>
                                            </li>
                                            <small class="text-muted">{{$client->email ? "$client->email" : 'No Email'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Address</label>
                                            </li>
                                            <small class="text-muted">{{$client->client_address ? "$client->client_address" : 'No Address'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Phone</label>
                                            </li>
                                            <small><i class="fas fa-chevron-right text-danger"></i><b> Whatsapp :</b> {{$client->phone_whatsapp ? "$client->phone_whatsapp" : '-'}}</small><br>
                                            <small><i class="fas fa-chevron-right text-danger"></i><b> Office :</b> {{$client->phone ? "$client->phone" : '-'}}</small><br>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Facebook URL</label>
                                            </li>
                                            <small class="text-muted">{{$client->fb_url ? "$client->fb_url" : '-'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Instagram URL</label>
                                            </li>
                                            <small class="text-muted">{{$client->inst_url ? "$client->inst_url" : '-'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Youtube URL</label>
                                            </li>
                                            <small class="text-muted">{{$client->ytb_url ? "$client->ytb_url" : '-'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Twitter URL</label>
                                            </li>
                                            <small class="text-muted">{{$client->twt_url ? "$client->twt_url" : '-'}}</small>
                                        </ul>
                                    </div>
                                     -->
                                     <!--profil setting-->
                                    <div role="tabpanel" class="tab-pane fade in {{$msgs ? '' : 'active'}}" id="profile_settings">
                                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{route('profile.client.update',[$vendor,$client->id])}}">
                                            @csrf
                                            <input type="hidden" name="_method" value="PUT">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-3 control-label">Name</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="name" name="client_name" placeholder="Name" value="{{$client->client_name}}" required readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="company_name" class="col-sm-3 control-label">Shop/Company Name</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="company_name" name="company_name" 
                                                        placeholder="Shop/Company Name" value="{{old('company_name') ? old('company_name') : $client->company_name}}" 
                                                        required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-3 control-label">Email</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="email" class="form-control" id="email" name="email" 
                                                        placeholder="Email" value="{{old('email') ? old('email') : $client->email}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="phone_whatsapp" class="col-sm-3 control-label">Whatsapp</label>

                                                <div class="col-sm-9">
                                                    <div class="form-line" style="padding-bottom:-1rem;">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">+62</span>
                                                            <input id="phone_whatsapp" type="text" class="form-control" placeholder="Whatsapp" 
                                                            name="phone_whatsapp" onkeypress="return isNumberKey(event)" 
                                                            value="{{old('phone_whatsapp') ? old('phone_whatsapp') : $client->phone_whatsapp}}" utocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="phone" class="col-sm-3 control-label">Office Phone</label>

                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input id="phone" value="{{old('phone') ? old('phone') : $client->phone}}" class="form-control" 
                                                        onkeypress="return isNumberKey(event)" 
                                                        type="text" name="phone" autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="client_address" class="col-sm-3 control-label">Address</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <textarea id="client_address" name="client_address" class="form-control" 
                                                            placeholder="Address" required>{{old('client_address') ? old('client_address') : $client->client_address}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="fb_url" class="col-sm-3 control-label">Facebook URL</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="url" class="form-control" id="fb_url" name="fb_url" 
                                                        placeholder="Your Facebook URL" value="{{old('fb_url') ? old('fb_url') : $client->fb_url}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inst_url" class="col-sm-3 control-label">Instagram URL</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="url" class="form-control" id="inst_url" name="inst_url" 
                                                        placeholder="Your Instagram URL" value="{{old('inst_url') ? old('inst_url') : $client->inst_url}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="ytb_url" class="col-sm-3 control-label">Youtube URL</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="url" class="form-control" id="ytb_url" name="ytb_url" 
                                                        placeholder="Your Youtube URL" value="{{old('ytb_url') ? old('ytb_url') : $client->ytb_url}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="twt_url" class="col-sm-3 control-label">Twitter URL</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="url" class="form-control" id="twt_url" name="twt_url" 
                                                        placeholder="Your Twitter URL" value="{{old('twt_url') ? old('twt_url') : $client->twt_url}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="client_image" class="col-sm-3 control-label">Image Logo</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        @if($client->client_image)
                                                        <img src="{{asset('assets/image'.$client->client_image)}}" width="120px"/>
                                                        @else
                                                        No Image Logo
                                                        @endif
                                                        <input type="file" name="client_image" class="form-control" id="client_image" autocomplete="off">
                                                        <small
                                                            class="text-muted">Leave it blank if you don't want to change your image
                                                        </small>
                                                    </div>
                                                    <label id="name-error" class="error" for="client_image">{{ $errors->first('client_image') }}</label>
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">SUBMIT</button>
                                                </div>
                                            </div>
                                            -->
                                            <div class="form-group">
                                                <div class="col-sm-offset-1 col-sm-11">
                                                    <button type="submit" class="btn btn-success">UPDATE</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!--Wa setting-->
                                    <div role="tabpanel" class="tab-pane fade in {{$msgs ? 'active' : ''}}" id="wa_setting">
                                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" 
                                            action="{{$message ? route('message.client.update',[$vendor,$message->id]) : route('message.client.store',[$vendor])}}">
                                            @csrf
                                            @if ($message)
                                                <input type="hidden" name="_method" value="PUT">
                                            @endif
                                            
                                            <div class="form-group">
                                                <label for="m_tittle" class="col-sm-3 control-label">Message Tittle</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="m_tittle" name="m_tittle" placeholder="Message Tittle" value="{{ $message ? $message->m_tittle : ''}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="s_tittle" class="col-sm-3 control-label">Sales Detail Tittle</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="s_tittle" name="s_tittle" 
                                                        placeholder="Sales detail tittle" value="{{$message ? $message->s_tittle : ''}}" 
                                                        required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="c_tittle" class="col-sm-3 control-label">Customer Detail Tittle</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="c_tittle" name="c_tittle" 
                                                        placeholder="Customer detail tittle" value="{{$message ? $message->c_tittle : ''}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="o_tittle" class="col-sm-3 control-label">Order Detail Tittle</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="o_tittle" name="o_tittle" 
                                                        placeholder="Order detail tittle" value="{{$message ? $message->o_tittle : ''}}" 
                                                        required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-1 col-sm-11">
                                                    <button type="submit" value="{{$message ? 'UPDATE' : 'SAVE'}}" class="btn btn-success">{{$message ? 'UPDATE' : 'SAVE'}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(Gate::check('isOwner'))
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-sm-offset-3 col-xs-12 col-sm-6">
                    <div class="card profile-card">
                        <div class="profile-header text-center">
                            <div class="image-area">
                                <img src="{{ asset('assets/image'.$client->client_image)}}" alt="image logo" />
                            </div>
                        </div>
                        <div class="profile-body">
                            
                            <div class="content-area">
                                <h3>Wellcome</h3>
                                <h3>{{Auth::user()->name}}</h3>
                                <p>{{Auth::user()->email}}</p>
                                <p>Administrator</p>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

    <script>
        $('.popoverData').popover();
        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
            return false;
            return true;
        }

        function flipAll() {
          $('.all-dash').toggleClass('hover');
        }

        function flipsls(id) {
          $('#dash'+id).toggleClass('hover');
        }

        $('#period_list').select2({
            placeholder: 'Select Period',
        }); 

        $('document').ready(function(){
            $('#numberDay').on('keyup', function(){
            var token = $('meta[name="csrf-token"]').attr('content');
            var num = $('#numberDay').val();
            var date_now = <?php echo json_encode($date_now); ?>;
            var month = <?php echo json_encode($month); ?>;
            var year = <?php echo json_encode($year); ?>;
                $.ajax({
                    url: '{{URL::to('/ajax/deliveryDaySales')}}',
                    type:'POST',
                    data:{
                        day : num,
                        month : month,
                        year : year,
                        date_now : date_now,
                        _token: token
                    },
                    success: function(data){
                        $('#body_table').html(data);
                        $('.popoverData').popover();
                        //console.log(response);
                        //console.log($('#table_body_list').html(response));
                        /*var len = 0;
                        if(response['data'] != null){
                            len = response['data'].length;
                        }

                        if(len > 0){
                            
                            for(var i=0; i<len; i++){
                                var sls_id = response['data'][i].sls_id;
                                var token = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    url: '{{URL::to('/ajax/deliveryDaySales')}}',
                                    type:'POST',
                                    data:{
                                        day : num,
                                        sls_id : sls_id,
                                        date_now : date_now,
                                        _token: token
                                    },
                                    success: function(data){
                                      $('#overD'+sls_id).text(data); 
                                      console.log(len); 
                                    }
                                });
                            }
                            //$("#modal_validasi").modal('show');
                        }*/ 
                    }
                });
            });
        });
    </script>
@endsection
