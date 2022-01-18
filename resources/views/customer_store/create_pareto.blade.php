@extends('layouts.master')
@section('title') Create Code @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('pareto_customers.store',[$vendor])}}">
    	@csrf
        <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
            
            <div class="form-group form-float">
                <div class="form-line" id="code_" class="code_">
                    <input type="text" value="{{old('pareto_code')}}" class="form-control" id="code"  
                        name="pareto_code" autocomplete="off" required style="text-transform:uppercase">
                    <label class="form-label">Pareto Code</label>
                </div>
                <small class="err_exist"></small>
            </div>
            
        
        <button id="save" class="btn btn-primary waves-effect" name="save_action" value="SAVE" type="submit" style="margin-top: 20px;">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $('document').ready(function(){
            $('#code, #save').on('keyup blur', function(){
            var code = $('#code').val();
                $.ajax({
                    url: '{{URL::to('/ajax/pareto_code/search')}}',
                    type: 'get',
                    data: {
                        'code' : code,
                    },
                    success: function(response){
                        if (response == 'taken' && code !="" ) {
                        $('.code_').addClass("focused error");
                        $('.err_exist').addClass("small").addClass('merah').text('Sorry... Pareto Code Already Exists');
                        $('#save').prop('disabled', true);
                        }else if (response == 'not_taken' && code !="") {
                        $('.code_').addClass("");
                        $('.err_exist').addClass("text-primary").removeClass('merah').text('Pareto Code Available');
                        $('#save').prop('disabled', false);
                        }
                        else if(response == 'not_taken' && code ==""){
                            //$('#email_').siblings("label").text('');
                            $('.err_exist').text('');
                        }
                    }
                });
            });
        });
</script>

@endsection