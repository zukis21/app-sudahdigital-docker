@extends('layouts.master')

    @section('title') Edit Sales Target @endsection
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
        <form id="form_validation" class="form_spv" method="POST" enctype="multipart/form-data" action="{{route('sales.update_target',[$vendor])}}">
            @csrf
            <input type="hidden" value="{{$target->id}}" name="target_id">
            <h2 class="card-inside-title">Period Of Time</h2>
            <div class="form-group">
                <div class="form-line" id="bs_datepicker_container">
                    <input type="text" id="datepicker" name="period" class="date-picker form-control" 
                     placeholder="Please choose a date..." autocomplete="off" required value="{{date('Y-m', strtotime($target->period))}}">
                </div>
            </div>
            <input type="hidden" id="param_user" name="param_user" value="">
            <input type="hidden" id="p_dt" name="p_dt" value="{{$target->period}}">
            <input type="hidden" id="user_id_select" value="{{$target->user_id}}">

            <div class="form-group" id="selectUser">
                <h2 class="card-inside-title">Sales</h2>
                <select onchange="getval(this);" name="user_id"  id="user_id" 
                    class="form-control" style="width:100%;" required>
                    
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    
                </select>
                <div class="form-group form-float">
                    <small class="err_exist"></small>
                </div>
            </div>
            <br>
            
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="number" class="form-control" name="target_value" value="{{$target->target_values}}" 
                        autocomplete="off" required>
                    <label class="form-label">Monthly Target Value (IDR)</label>
                </div>
            </div>

            <button id="btnSubmit" class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
        </form>
        <!-- #END#  -->		

    @endsection
    @section('footer-scripts')
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript">

        $('#user_id').select2({
            placeholder: 'Select a Sales',
        });

        function getval(sel)
        {
            $( '#user_id_select' ).val(sel.value);
            var date =  $('#param_user' ).val();
            //var data = $("#user_id option:selected").text();
            //var user_id = sel.value;
            //console.log(date+user_id);
            $.ajax({
                url: '{{URL::to('/ajax/exist_user/search')}}',
                type: 'get',
                data: {
                    'user_id' : sel.value,
                    'date' : date
                },
                success: function(response){
                    if (response == 'taken') {
                    $('.email_').addClass("focused error");
                    $('.err_exist').addClass("small").addClass('merah').text('Sales already exists in this month...');
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
                    $("input[name='param_user']").val(dateText);
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
                $('#param_user').val(par);
            });
        });
        
        $('#datepicker').change(function() {
  
            
                // Otherwise show it
                //$('#selectUser').show();
                var user_id = $( '#user_id_select' ).val();
                var date = $(this).val();
                var p_dt = $( '#p_dt' ).val();
                $.ajax({
                    url: '{{URL::to('/ajax/exist_user_edit/search')}}',
                    type: 'get',
                    data: {
                        'user_id' : user_id,
                        'date' : date,
                        'p_dt' : p_dt
                    },
                    success: function(response){
                        if (response == 'taken') {
                        $('.email_').addClass("focused error");
                        $('.err_exist').addClass("small").addClass('merah').text('Sales already exists in this month...');
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
            
        }).change();
    </script> 
    @endsection
