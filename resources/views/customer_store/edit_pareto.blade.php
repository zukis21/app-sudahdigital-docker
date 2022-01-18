@extends('layouts.master')
@section('title') Edit Pareto Code @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
   
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('pareto_customers.update',[$vendor,$pareto->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" id="old_code" name="old_code" value="{{$pareto->id}}">
        <div class="form-group form-float">
            <div class="form-line" id="code_" class="code_">
                <input type="text" value="{{old('pareto_code',$pareto->pareto_code)}}" class="form-control" id="code"  
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
<script>
    $('document').ready(function(){
        $('#code, .btn').on('keyup blur', function(){
        var code = $('#code').val();
        var old_code =$('#old_code').val();
            $.ajax({
                url: '{{URL::to('/ajax/pareto_code/search')}}',
                type: 'get',
                data: {
                    'code' : code,
                    'old_code' : old_code
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