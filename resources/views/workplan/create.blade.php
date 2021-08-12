@extends('layouts.master')

    @section('title') Create Holiday Plans @endsection
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
        <form id="form_validation" class="form_spv" method="POST" enctype="multipart/form-data" action="{{route('workplan.store',[$vendor])}}">
            @csrf
            <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id" id="client_id">
            
            <h2 class="card-inside-title">Period</h2>
            <div class="input-group">
                <span class="input-group-addon" style="display:none;" id="resetdate">
                    <button type="button" onclick='reloadDIV ();' class="btn-sm btn bg-red waves-effect">
                    Reset
                    </button>
                </span>
                <div class="form-line" id="bs_datepicker_container">
                    <input type="text" id="datepicker" name="period" class="date-picker form-control" 
                     placeholder="Please choose a date..." autocomplete="off" required readonly>
                </div>
            </div>
            <div class="form-group form-float">
                <small class="err_exist"></small>
            </div>

            <input type="hidden" id="param_date" name="param_date" value="">
            <div class="form-group"  style="display:none" id="selectday">
                <h2 class="card-inside-title">Holiday Date</h2>
                
                    <div class="form-line" id="here">
                        <input type="text" id="holidays" name="holidays" class="date-picker_day form-control" 
                        placeholder="Please choose a date..." autocomplete="off" required readonly>
                    </div>
                
            </div>
            <button id="btnSubmit" class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
            
        </form>
        <!-- #END#  -->		

    @endsection
    @section('footer-scripts')
        <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
        
        <script type="text/javascript">
            function reloadDIV()
            { 
                $( "#here" ).load(window.location.href + " #here" );
                $("#datepicker").prop('disabled', false); //enable
                $( " #param_date" ).val('');
                $( "#datepicker" ).val('').datepicker("update");
                $('#resetdate,#selectday').hide();
                //$('#datepicker')..datepicker("refresh");
            }

            $("#datepicker").datepicker( {
                format: "yyyy-mm",
                startView: "months", 
                minViewMode: "months",
                
                //clearBtn: true
            }).on('changeMonth', function (e) {
                $(".datepicker").hide();
                
            });

            $('document').ready(function(){
                $('#datepicker').on('change', function(){
                    //$('#holidays').val('');
                    //$( "#here" ).load(window.location.href + " #here" );
                    $("#datepicker").prop('disabled', true); //disable 
                    var par = $('.date-picker').val();
                    $('#param_date').val(par);
                    var myStr = $('#param_date').val();
                    var arr = myStr.split("-");
                    var year = arr[0];
                    var date = arr[1];
                    //console.log(date);
                    var day = new Date(year,date,0).getDate();
                    var startDate = new Date(year,date-1,1);
                    var endDate = new Date(year,date-1,day);
                    
                    $('.date-picker_day').datepicker({
                        multidate: true,
                        format: 'yyyy-mm-dd',
                        startDate: startDate,
                        endDate: endDate
                    });

                });
            });

            $('#datepicker').change(function() {
                // If value is not empty
                if ($(this).val().length == 0) {
                    // Hide the element
                    $('#resetdate, #selectday').hide();
                } else {
                    // Otherwise show it
                    $('#resetdate, #selectday').show();
                    var date = $(this).val();
                    var client_id = $('#client_id').val();
                    $.ajax({
                        url: '{{URL::to('/ajax/workplan/search')}}',
                        type: 'get',
                        data: {
                            'client_id' : client_id,
                            'date' : date
                        },
                        success: function(response){
                            if (response == 'taken') {
                            $('.err_exist').addClass("small").addClass('merah').text('Month & Year already exists...');
                            $('#btnSubmit').prop('disabled', true);
                            }else if (response == 'not_taken') {
                            $('.err_exist').addClass("text-primary").removeClass('merah').text('');
                            $('#btnSubmit').prop('disabled', false);
                            }
                        }
                    });
                }
            }).change();
        </script> 
    @endsection
