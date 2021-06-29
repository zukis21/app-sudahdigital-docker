@extends('layouts.master')
@section('title') Edit Type @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
   
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('type_customers.update',[$vendor,$cust->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" id="old_type_name" name="old_name" value="{{$cust->id}}">
        <div class="form-group form-float">
            <div class="form-line" id="name_">
                <input type="text" value="{{old('name',$cust->name)}}" class="form-control" id="name"  
                name="name" autocomplete="off" required style="text-transform:uppercase">
                <label class="form-label">Name</label>
            </div>
            <label id="name-error" class=""></label>
            <small class=""></small>
        </div>
        <button id="save" class="btn btn-primary waves-effect" name="save_action" value="SAVE" type="submit" style="margin-top: 20px;">SAVE</button>
    </form>
    <!-- #END#  -->
    		
    
@endsection

@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script>
    $('document').ready(function(){
        $('#name, .btn').on('keyup blur', function(){
        var name = $('#name').val();
        var old_name =$('#old_type_name').val();
            $.ajax({
                url: '{{URL::to('/ajax/type_customers/search')}}',
                type: 'get',
                data: {
                    'name' : name,
                    'old_name' : old_name
                },
                success: function(response){
                    if (response == 'taken' && name !="" ) {
                    $('#name_').addClass("focused error");
                    $('#name_').siblings("label").addClass("error").text('Sorry... Name Already Exists');
                    $('#name_').siblings("small").text('');
                    $('#save').prop('disabled', true);
                    }else if (response == 'not_taken' && name !="") {
                    $('#name_').addClass("");
                    $('#name_').siblings("small").addClass("text-primary").text('Name Available');
                    $('#name_').siblings("label").text('');
                    $('#save').prop('disabled', false);
                    }
                    else if(response == 'not_taken' && name ==""){
                        $('#name_').siblings("label").text('');
                        $('#name_').siblings("small").text('');
                    }
                }
            });
        });
    });
</script>

@endsection