@extends('layouts.master')
@section('title') 
    Add New Customer
@endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
   
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('orders.newcustomer.update',[$vendor,$cust->id])}}">
    	@csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
            <div class="form-group form-float">
                <div class="form-line" id="code_">
                    <input type="text" value="{{old('store_code')}}" class="form-control" id="code"  name="store_code" autocomplete="off" required>
                    <label class="form-label">Customer Code / Search Key</label>
                </div>
                <small class="err_exist"></small>
            </div>
            
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="store_name" value="{{old('store_name',$cust->store_name)}}" autocomplete="off" required>
                    <label class="form-label">Name</label>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="email" class="form-control" value="{{old('email',$cust->email)}}" name="email" autocomplete="off">
                    <label class="form-label">Email</label>
                </div>
            </div>
            
            <h2 class="card-inside-title">City</h2>
                <select name="city"  id="city_id" class="form-control"></select>
                <small id="name-error" class="error merah" for="city_id">{{ $errors->first('city') }}</small>
            <br>
            <br>
            <div class="form-group">
                <div class="form-line">
                    <textarea name="address" rows="4" class="form-control no-resize" 
                    placeholder="Address" autocomplete="off" required>{{old('address',$cust->address)}}</textarea>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input id="txtNumber" value="{{old('phone', $cust->phone)}}" class="form-control" onkeypress="return isNumberKey(event)"  type="text" name="phone" minlength="10" maxlength="13" autocomplete="off">
                    <label class="form-label">Whatsapp Number</label>
                </div>
                <div class="help-info">Min.10, Max. 13 Characters</div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" value="{{old('phone_owner',$cust->phone_owner)}}" id="txtNumber" class="form-control" onkeypress="return isNumberKey(event)" name="phone_owner"  autocomplete="off" >
                    <label class="form-label">Owner Phone</label>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" value="{{old('phone_store',$cust->phone_store)}}" id="txtNumber" class="form-control" onkeypress="return isNumberKey(event)" name="phone_store"  autocomplete="off" >
                    <label class="form-label">Office/Shop Phone</label>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="name" value="{{old('name',$cust->name)}}" autocomplete="off" required>
                    <label class="form-label">Contact Person</label>
                </div>
            </div>

            <h2 class="card-inside-title">Term Of Payment</h2>
            <div class="col-sm-2" style="padding-left:0;padding-right:0;">
                <div class="form-group">
                    <input class="form-control {{$errors->first('payment_term') ? "is-invalid" : "" }}" 
                        type="radio" name="payment_term" id="cash" value="Cash" required onclick="checkstate()"
                        {{old('payment_term',$payment)== 'Cash' ? 'checked' : ''}} > 
                    <label for="cash">Cash</label>
                    &nbsp;&nbsp;
                    <input class="form-control {{$errors->first('payment_term') ? "is-invalid" : "" }}" 
                        type="radio" name="payment_term" id="top" value="TOP" onclick="checkstate()"
                        {{{old('payment_term',$payment)== 'TOP' ? 'checked' : ''}}}> 
                    <label for="top">TOP</label>
                </div>
            </div>
            
            <div class="col-sm-10" style="padding-left:0;">
                <div class="input-group">
                    <div class="form-line">
                        <input type="number" min="0" class="form-control" 
                        id="pay_cust" name="pay_cust" value="{{old('pay_cust',preg_replace("/[^0-9]/","",$cust->payment_term))}}" 
                        autocomplete="off" required placeholder="Net d Days"
                        {{$payment == "Cash" ? 'disabled' : ''}}>
                    </div>
                    <span class="input-group-addon">Days</span>
                </div>
            </div>
            
            
            <!--
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="payment_term" value="{{$cust->payment_term}}" autocomplete="off" required>
                    <label class="form-label">Payment Term</label>
                </div>
            </div>
            -->
            <h2 class="card-inside-title">Sales Representative</h2>
                <select name="user_id"  id="user" class="form-control">
                    <option value="{{$sls->id}}">{{$sls->name}}</option>
                </select>
            <br>
            
            <!--
            <div class="form-group form-float" style="margin-top: 40px;">
                <div class="form-line">
                    <input type="text" class="form-control" name="user_id" value="{{$sls->name}}" autocomplete="off" required disabled>
                    <label class="form-label">Sales Representative</label>
                </div>
            </div>
            -->
        <button id="save"  class="btn btn-primary waves-effect" name="save_action" value="SAVE" type="submit" style="margin-top: 20px;">SAVE</button>
        
    </form>
    <!-- #END#  -->
@endsection

@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
     $('document').ready(function(){
        document.getElementById('pay_cust').disabled = document.getElementById('cash').checked;
     });
    function checkstate() {
        document.getElementById('pay_cust').disabled = document.getElementById('cash').checked;
    }
    
    function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
            return false;
            return true;
        }
    $('#cust_type, #user').select2(); 
    
    /*$('#user').select2({
      placeholder: 'Select an item',
      ajax: {
        url: '{{URL::to('/ajax/users/search')}}',
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                        id: item.id,
                        text: item.name
                      
                  }
              })
          };
        }
        
      }
    });*/

    /*var users = JSON.stringify([{!! $cust->users !!}]);
    users = JSON.parse(users);
    users.forEach(function(cust){
    var option = new Option(cust.name, cust.id, true, true);
    $('#user').append(option).trigger('change');
    });*/

    //city
    $('#city_id').select2({
        placeholder: 'Select a City',
        ajax: {
            url: '{{URL::to('/customer/ajax/city_search')}}',
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                            id: item.id,
                            text: item.city_name,
                            
                    }
                })
            };
            }
            
        }
    });

    

    var cities = JSON.stringify([{!! $cust->cities !!}]);
    cities = JSON.parse(cities);
    cities.forEach(function(cust_city){
        var option_city = new Option(cust_city.city_name, cust_city.id, true, true);
        $('#city_id').append(option_city).trigger('change');
    });

   

    $("#code").on({
        keydown: function(e) {
        if (e.which === 32)
            return false;
        },
        keyup: function(){
        this.value = this.value.toUpperCase();
        },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
            
        }
    });

    $('document').ready(function(){
        $('#code, .btn').on('keyup blur', function(){
        var code = $('#code').val();
            $.ajax({
                url: '{{URL::to('/ajax/code_cust/search')}}',
                type: 'get',
                data: {
                    'code' : code,
                },
                success: function(response){
                    if (response == 'taken' && code !="" ) {
                    $('#code_').addClass("error focused");
                    //$('#code_').siblings("label").addClass("error").text('Sorry... Code Already Exists');
                    $('.err_exist').addClass("small").addClass('merah').text('Sorry... Code Already Exists');
                    //$('#code_').siblings("small").text('');
                    $('#save').prop('disabled', true);
                    }else if (response == 'not_taken' && code !="") {
                    $('#code_').addClass("");
                    //$('#code_').siblings("small").addClass("text-primary").text('Code Available');
                    $('.err_exist').addClass("text-primary").removeClass('merah').text('Code Available');
                    //$('#code_').siblings("label").text('');
                    $('#save').prop('disabled', false);
                    }
                    else if(response == 'not_taken' && code ==""){
                        //$('#code_').siblings("label").text('');
                        //$('#code_').siblings("small").text('');
                        $('.err_exist').text('');
                    }
                }
            });
        });
    });

   
</script>

@endsection