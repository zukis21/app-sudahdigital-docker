@extends('customer.layouts.template-nocart')
@section('title') Orders @endsection
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

    <div class="container" style="">
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
                            <h6><b>Dashboard {{Auth::user()->name}} {{date('F'.' Y', strtotime(\Carbon\Carbon::now()))}}</b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" style="">
            <div class="col-12" style="z-index: 2;">
                <section class='statis text-center'>
                    <div class="container">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="box bg-primary">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <h3>{{$cust_total}}</h3>
                            <p class="lead">Customers / Toko</p>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="box bg-danger">
                            <i class="far fa-money-bill-alt"></i>
                            <h3>{{$target ? number_format($target->target_values) : '~'}}</h3>
                            <p class="lead">Target (Rp)</p>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="box bg-secondary">
                            <!--<i class="fa fa-shopping-cart"></i>-->
                            <i class="far fa-money-bill-alt"></i>
                            <h3>
                              @php
                              $total_ach = 0;
                              foreach($order_ach as $p){
                                  $total_ach += $p->total_price;
                              }
                              //return $total_ach;
                              echo $total_ach;
                              @endphp
                            </h3>
                            <p class="lead">Pencapaian (Rp)</p>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="box bg-success">
                            <i class="fa fa-handshake"></i>
                            <h3>{{$order}}</h3>
                            <p class="lead">Transaksi (Toko)</p>
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
                          <div class="box">
                            <ul class="list-group">
                              <li class="list-group-item active" style="background-color: #313348;border-color:#313348;color:#CCC">
                                <b>Toko Belum Order {{date('F-Y', strtotime(\Carbon\Carbon::now()))}}</b>
                              </li>
                              @foreach ($cust_not_exists as $item)
                                <li class="list-group-item"><b>{{$item->store_name}}</b>,<br>{{$item->address}}</li>
                              @endforeach  
                            </ul>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3 d-flex">
                          <div class="box w-100">
                            <ul class="list-group w-100">
                              <li class="list-group-item active" style="background-color: #313348;border-color:#313348;color:#CCC">
                                <b>Toko Sudah Order {{date('F-Y', strtotime(\Carbon\Carbon::now()))}}</b>
                              </li>
                              @foreach ($cust_exists as $it)
                                <li class="list-group-item"><b>{{$it->store_name}}</b>,<br>{{$it->address}}</li>
                              @endforeach  
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
            </div>
        </div>

        <!--
        <div class="row justify-content-center" style="">
          <div class="col-12" style="z-index: 2;">
              <section class="statistics">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <div class="box">
                          
                            <span>Garafik Pencapaian Th. {{date(' Y', strtotime(\Carbon\Carbon::now()))}}</span>
                            <hr style="width: 100%;">
                            <div id="container"></div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
           </div>
        </div>
        -->
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

        var Order = <?php echo $order_chart;?>;

        Highcharts.chart('container', {
            title: {
                text: 'New User Growth, 2020'
            },
            subtitle: {
                text: 'Source: positronx.io'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                    'Oct', 'Nov', 'Dec'
                ]
            },
            yAxis: {
                title: {
                    text: 'Number of New Users'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true
                }
            },
            series: [{
                name: 'New Users',
                data: Order
            }],
            responsive: {
                rules: [{
                    
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    </script> 
@endsection
