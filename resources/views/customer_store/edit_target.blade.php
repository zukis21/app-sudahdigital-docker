@extends('layouts.master')

    @section('title') Edit Customer Target {{date('F Y', strtotime($period))}} @endsection
    @section('content')
    
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-success">
                {{session('error')}}
            </div>
        @endif
        <!-- Form Create -->
        @if(count($exist_store) > 0)
        <a class="btn bg-green waves-effect m-b-20" data-toggle="modal" data-target="#detailModal"
            id="popoverData" data-trigger="hover" data-container="body" data-placement="right" 
            data-content="Add new customer in this period.">
            + Add
        </a>

          
        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel"></h5>
                    </div>
                    <div class="modal-body">
                        <form id="form_validation" class="form_spv" method="POST" enctype="multipart/form-data" action="{{route('customers.store_target_add',[$vendor,$period])}}">
                            @csrf
                            <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
                            
                            <div class="">
                                <table class="table table-striped table-hover dataTable js-basic-example">
                                    <thead>
                                        <tr>
                                            <!--<th>No</th>-->
                                            <th>Customers</th>
                                            <th>Cat</th>
                                            <th>Target Values (IDR)</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=0;?>
                                        @foreach($exist_store as $u)
                                        <?php $no++;?>
                                        <tr>
                                            <!--<td>{{$no}}</td>-->
                                            <td>
                                                {{$u->store_code}} | {{$u->store_name}}
                                            </td>
                                            <td>
                                                {{$u->pareto->pareto_code}}
                                            </td>
                                            <td>
                                                <input type="hidden" name="customer_id[]" value="{{$u->id}}">
                                                <!--<input type="hidden" name="version_pareto[]" value="{{$u->pareto->id}}">-->
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        
                                                        <input type="text" class="form-control" name="target_value[]" id="currency-field" 
                                                        pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="{{old('target_value')}}" 
                                                        data-type="currency" placeholder="" autocomplete="off">
                                                    </div>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                
                            <button id="btnSubmit" class="btn btn-primary waves-effect" value="ADD" type="submit">SAVE</button>
                            <button type="button" class="btn waves-effect bg-red m-l-5" data-dismiss="modal">Close</button>
                        </form>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        @endif

        <form id="form_validation" class="form_spv" method="POST" enctype="multipart/form-data" action="{{route('customers.update_target',[$vendor,$period])}}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            
            <div class="">
                <table class="table table-striped table-hover dataTable js-basic-example">
                    <thead>
                        <tr>
                            <!--<th>No</th>-->
                            <th>Customers</th>
                            <th>Cat</th>
                            <th>Target Values (IDR)</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=0;?>
                        @foreach($target as $u)
                        <?php $no++;?>
                        <tr>
                            <!--<td>{{$no}}</td>-->
                            <td>
                                {{$u->customers->store_code}} | {{$u->customers->store_name}}
                                
                            </td>
                            <td>
                                @if($u->customers->pareto_id)
                                    @php
                                        $prt = \App\CatPareto::findorFail($u->customers->pareto_id);
                                    @endphp
                                {{$prt->pareto_code}}
                                @else
                                    Not Pareto
                                @endif
                            </td>
                            <td>
                                <input type="hidden" name="id[]" value="{{$u->id}}">
                                
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="target_value[]" id="currency-field" 
                                        value="{{old('target_value',number_format($u->target_values))}}" 
                                        data-type="currency" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            
            <button id="btnSubmit" class="btn btn-primary waves-effect" type="submit">UPDATE</button>
        </form>
        <!-- #END#  -->		

    @endsection
    @section('footer-scripts')
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $('#popoverData').popover();
        
        $("input[data-type='currency']").on({
            keyup: function() {
            formatCurrency($(this));
            },
            blur: function() { 
            formatCurrency($(this), "blur");
            }
        });

        function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        
        // get input value
        var input_val = input.val();
        
        // don't validate empty input
        if (input_val === "") { return; }
        
        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");
            
        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);
            
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
            right_side += "00";
            }
            
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            //input_val = "$" + left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            //input_val = "$" + input_val;
            
            // final formatting
            /*if (blur === "blur") {
            input_val += ".00";
            }*/
        }
        
        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
        }

        $('#customer_id').select2({
            placeholder: 'Select a Customer',
        });

        function getval(sel)
        {
            $( '#customer_id_select' ).val(sel.value);
            var date =  $('#param_customer' ).val();
            //var data = $("#user_id option:selected").text();
            //var user_id = sel.value;
            //console.log(date+user_id);
            $.ajax({
                url: '{{URL::to('/ajax/exist_customer/search')}}',
                type: 'get',
                data: {
                    'customer_id' : sel.value,
                    'date' : date
                },
                success: function(response){
                    if (response == 'taken') {
                    //$('.email_').addClass("focused error");
                    $('.err_exist').addClass("small").addClass('merah').text('Customer already exists in this month...');
                    $('#btnSubmit').prop('disabled', true);
                    }else if (response == 'not_taken') {
                    $('.err_exist').addClass("text-primary").removeClass('merah').text('');
                    $('#btnSubmit').prop('disabled', false);
                    }
                    /*
                    else if(response == 'not_taken' && email==""){
                        //$('#email_').siblings("label").text('');
                        $('.err_exist').text('');
                    }*/
                }
            });
        }

        

        var dp=$("#datepicker").datepicker( {
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months",
            onSelect: function(dateText, inst) {
                    $("input[name='param_customer']").val(dateText);
                }
        });

        dp.on('changeMonth', function (e) {
            //var dateObject = $("#datepicker").val();    
            //do something here
            $(".datepicker").hide();
        });

        $('document').ready(function(){
            $('.date-picker').on('keyup blur change', function(){
                var par = $('.date-picker').val();
                $('#param_customer').val(par);
            });
        });
        
        $('document').ready(function(){
            if ($('#datepicker').val().length == 0) {
                // Hide the element
                $('#selectCustomer').hide();
            } else {
                // Otherwise show it
                $('#selectCustomer').show();
            }
        });

        $('#datepicker').change(function() {
  
            // If value is not empty
            if ($(this).val().length == 0) {
                // Hide the element
                $('#selectCustomer').hide();
            } else {
                // Otherwise show it
                var date = $(this).val();
                $.ajax({
                    url: '{{URL::to('/ajax/exist_date/search')}}',
                    type: 'get',
                    data: {
                        'date' : date
                    },
                    success: function(response){
                        if (response == 'taken') {
                        //$('.email_').addClass("focused error");
                        $('.err_exist').addClass("small").addClass('merah').text('This Period already exists in target ...');
                        $('#btnSubmit').prop('disabled', true);
                        }else if (response == 'not_taken') {
                        $('.err_exist').addClass("text-primary").removeClass('merah').text('');
                        $('#btnSubmit').prop('disabled', false);
                        }
                        /*
                        else if(response == 'not_taken' && email==""){
                            //$('#email_').siblings("label").text('');
                            $('.err_exist').text('');
                        }*/
                    }
                });

                /*$.ajax({
                    url: '{{URL::to('/ajax/exist_customer/search')}}',
                    type: 'get',
                    data: {
                        'customer_id' : cust_id,
                        'date' : date
                    },
                    success: function(response){
                        if (response == 'taken') {
                        //$('.email_').addClass("focused error");
                        $('.err_exist').addClass("small").addClass('merah').text('Customer already exists in this month...');
                        $('#btnSubmit').prop('disabled', true);
                        }else if (response == 'not_taken') {
                        $('.err_exist').addClass("text-primary").removeClass('merah').text('');
                        $('#btnSubmit').prop('disabled', false);
                        }
                        /*
                        else if(response == 'not_taken' && email==""){
                            //$('#email_').siblings("label").text('');
                            $('.err_exist').text('');
                        }
                    }
                });*/
            }
        }).change();
    </script> 
    @endsection
