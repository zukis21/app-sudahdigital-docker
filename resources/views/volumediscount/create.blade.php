@extends('layouts.master')
@section('title') Create Volume Discount @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('vDiscount.store',[$vendor])}}">
    	@csrf
        
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" id="code" name="name" 
                autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>

        <h2 class="card-inside-title">Type</h2>
            <div class="form-group">
                <input class="form-control" type="radio" 
                    name="type" id="1" value="1" required
                    @if($vDiscounts)
                        @if($vDiscounts->type == 1)
                            {{'checked'}}
                        @else
                            {{'disabled'}}
                        @endif
                    @endif
                > 
                <label for="1">Combine</label>
                <input class="form-control" type="radio" 
                    name="type" id="2" value="2"
                    @if($vDiscounts){
                        @if($vDiscounts->type == 2)
                            {{'checked'}}
                        @else
                            {{'disabled'}}
                        @endif
                    @endif
                > 
                <label for="2">Item</label>
                <div class="invalid-feedback">
                    {{$errors->first('type')}}
                </div>
            </div>
        
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" onKeyUp="test_fn(this.value)" 
                    onchange="document.getElementById('maxOrder').min = Number(1) + Number(this.value)"
                    class="form-control" id="min_order" name="min_order" 
                    min="{{$vDiscounts && $vDiscounts->max_order > 0 ? $vDiscounts->max_order + 1 : 1}}" 
                    autocomplete="off" maxlength="9" required 
                    {{$vDiscounts && $vDiscounts->max_order > 0 ? 'max='.($vDiscounts->max_order + 1).'' : 'max=1'}}
                    {{$vDiscounts && $vDiscounts->max_order == 0 ? 'readonly' : ''}}>
                <label class="form-label">Min. Order</label>
            </div>
        </div>

        <div class="form-group">
            <div class="form-line">
                <input type="checkbox" name="usemaxcheck" id="useMaxOrder" disabled>
                <label for="useMaxOrder">Use Max. Order</label>
            
                <input type="number" onKeyUp="test_fn_1(this.value)" 
                    class="form-control" id="maxOrder" name="max_order"
                    autocomplete="off" maxlength="9" required disabled>
                
            </div>
            <input type="hidden" name="hideMaxOrder" id="hideMaxOrder">
        </div>
        

       <button class="btn btn-primary" name="save_action" id="save" value="SAVE" type="submit" style="margin-top:20px;">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection
@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script>

    function test_fn(test_value){
        var test_value = test_value.replace(/[^0-9]+/g, "");
        var checker = document.getElementById('useMaxOrder');
        var inputnum = document.getElementById('maxOrder');
        if(test_value != '' && test_value > 0){
            checker.disabled = false;
        }else{
            checker.disabled = true;
            checker.checked = false;
            inputnum.disabled = true;
            $('#maxOrder').val('');
            $('#hideMaxOrder').val('');
        }
    }

    function test_fn_1(test_value){
        var test_value = test_value.replace(/[^0-9]+/g, "");
       
    }

    var checker = document.getElementById('useMaxOrder');
    var inputnum = document.getElementById('maxOrder');
    // when unchecked or checked, run the function
    checker.onchange = function(){
        if(this.checked){
            inputnum.disabled = false;
        } else {
            inputnum.disabled = true;
            $('#maxOrder').val('');
            $('#hideMaxOrder').val('');
        }

    }

    $('#maxOrder').on('keyup change', function() {
        $('#hideMaxOrder').val(this.value);
    });

</script>

@endsection