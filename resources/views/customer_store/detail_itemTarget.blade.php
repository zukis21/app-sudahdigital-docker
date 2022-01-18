@extends('layouts.master')

    @section('title') Target Details 
        {{$store_target->customers->store_name. ' '.date('F Y', strtotime($store_target->period))}} @endsection
    @section('content')
    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
        <div class="">
            <table class="table table-striped table-hover table-detail-target">
                <thead>
                    <tr>
                        <!--<th>No</th>-->
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Max Nominal Target(IDR)</th>
                        <th>Target Qty(BOX)</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=0;?>
                    @foreach($detailItem as $u)
                    <?php $no++;?>
                    <tr>
                        <!--<td>{{$no}}</td>-->
                        <td>
                            {{$u->products->product_code}}
                            
                        </td>
                        <td>
                            {{$u->products->Product_name}}
                        </td>
                        <td>
                            @if($store_target->target_type == 2 || $store_target->target_type == 3)
                                {{number_format($u->nominalValues)}}
                               
                            @endif 
                            
                        </td>
                        <td >
                            @if($store_target->target_type == 1 || $store_target->target_type == 3)
                                {{$u->quantityValues}}
                            @endif
                        </td>
                        <td>
                            <a  
								data-toggle="modal" data-target="#deleteModal{{$u->id}}"
								class="btn btn-xs btn-danger waves-effect">
								<i class="material-icons">delete</i>
							</a>
                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{$u->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content modal-col-red">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="deleteModalLabel">Delete Product</h4>
                                        </div>
                                        <div class="modal-body">
                                        Delete this product ..? 
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{route('targetItem.delete-permanent',[$vendor,$u->id,Crypt::encrypt($store_target->id)])}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-link waves-effect">Delete</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a class="btn btn-danger btn-xs" href="{{route('customers.edit_target',[$vendor,Crypt::encrypt($store_target->period)])}}">
            <i class="material-icons">arrow_back</i>
        </a>
        <!-- #END#  -->		
    @endsection
    @section('footer-scripts')
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.table-detail-target').DataTable( {
                
                "ordering": false,
            } );
        } );
        function showQty()
        {
            $('.target_quantity').prop('disabled',false);
            $('.target_quantity').prop('required',true);
            $('.target_nominal').prop('disabled',true);
        }
        function showNml()
        {
            $('.target_quantity').prop('disabled',true);
            $('.target_nominal').prop('disabled',false);
            $('.target_nominal').prop('required',true);
        }
        function showQtyNml()
        {
            $('.target_nominal,.target_quantity').prop('disabled',false);
            $('.target_quantity,.target_nominal').prop('required',true);
         }
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

        /*
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
                        }(*)/
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
                }); (*)///
            }
        }).change();*/
    </script> 
    @endsection
