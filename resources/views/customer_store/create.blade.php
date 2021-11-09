@extends('layouts.master')
@section('title') Create Customer @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('customers.store',[$vendor])}}">
    	@csrf
        <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
        <div class="form-group form-float">
            <div class="form-line" id="code_">
                <input type="text" value="{{old('store_code')}}" class="form-control" id="code"  name="store_code" autocomplete="off" required>
                <label class="form-label">Customer Code / Search Key</label>
            </div>
            <label id="name-error" class=""></label>
            <small class=""></small>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{old('store_name')}}" class="form-control" name="store_name" autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>

        <p>
            <b>Customer Type</b>
        </p>
        <select name="cust_type"  id="cust_type" class="form-control">
            <option></option>
            @foreach($type as $ty)
                <option value="{{$ty->id}}">{{$ty->name}}</option>
            @endforeach
        </select>

        <div class="form-group form-float m-t-30">
            <div class="form-line">
                <input type="email" class="form-control" value="{{old('email')}}" name="email" autocomplete="off">
                <label class="form-label">Email</label>
            </div>
        </div>
        
        <h2 class="card-inside-title" >City</h2>
            <select name="city"  id="city_id" class="form-control"></select>
            <small id="name-error" class="error merah" for="city_id">{{ $errors->first('city') }}</small>
        <br>
        <br>

        <div class="form-group">
            <div class="form-line">
                <textarea name="address" rows="4" class="form-control no-resize" placeholder="Address" autocomplete="off" required>{{old('address')}}</textarea>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" id="latlng" class="form-control" value="{{old('latlng')}}"
                name="latlng">
                <label class="form-label">Coordinate</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input id="txtNumber" value="{{old('phone')}}" class="form-control" onkeypress="return isNumberKey(event)"  type="text" name="phone" minlength="10" maxlength="13" autocomplete="off">
                <label class="form-label">Whatsapp Number</label>
            </div>
            <div class="help-info">Min.10, Max. 13 Characters</div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{old('phone_owner')}}" id="txtNumber" class="form-control" onkeypress="return isNumberKey(event)" name="phone_owner"  autocomplete="off" >
                <label class="form-label">Owner Phone</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{old('phone_store')}}" id="txtNumber" class="form-control" onkeypress="return isNumberKey(event)" name="phone_store"  autocomplete="off" >
                <label class="form-label">Office/Shop Phone</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{old('name')}}" class="form-control" name="name" autocomplete="off" required>
                <label class="form-label">Contact Person</label>
            </div>
        </div>
        <!--
        <h2 class="card-inside-title">Payment Term</h2>
            <select name="payment_term"  id="payment_term" class="form-control" required>
                <option></option>
                <option value="7 Days">7 Days</option>
                <option value="45 Days">45 Days</option>
                <option value="60 Days">60 Days</option>
            </select>
        <br>
        -->
        <h2 class="card-inside-title">Term Of Payment</h2>
            <div class="col-sm-2" style="padding-left:0;padding-right:0;">
                <div class="form-group">
                    <input class="form-control {{$errors->first('payment_term') ? "is-invalid" : "" }}" 
                        type="radio" name="payment_term" id="cash" value="Cash" required onclick="checkstate()"
                        {{old('payment_term')== 'Cash' ? 'checked' : ''}} > 
                    <label for="cash">Cash</label>
                    &nbsp;&nbsp;
                    <input class="form-control {{$errors->first('payment_term') ? "is-invalid" : "" }}" 
                        type="radio" name="payment_term" id="top" value="TOP" onclick="checkstate()"
                        {{{old('payment_term')== 'TOP' ? 'checked' : ''}}}> 
                    <label for="top">TOP</label>
                </div>
            </div>
            
            <div class="col-sm-10" style="padding-left:0;">
                <div class="input-group">
                    <div class="form-line">
                        <input type="number" min="0" class="form-control"
                        id="pay_cust" name="pay_cust" value="{{old('pay_cust')}}" 
                        autocomplete="off" required placeholder="Net d Days">
                    </div>
                    <span class="input-group-addon">Days</span>
                </div>
            </div>
        <!--
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="payment_term" autocomplete="off" required>
                <label class="form-label">Payment Term</label>
            </div>
        </div>
        -->
        <div class="col-sm-12" style="padding:0;">
            <h2 class="card-inside-title">Pareto Code</h2>
            <select name="pareto_id"  id="pareto_id" class="form-control">
                <option></option>
                @foreach($pareto as $ty)
                    <option value="{{$ty->id}}" >{{$ty->pareto_code}}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div class="col-sm-12" style="padding:0;">
            <h2 class="card-inside-title">Sales Representative</h2>
            <select name="user"  id="user" class="form-control">
            </select>
            <small id="name-error" class="error merah" for="user">{{ $errors->first('user')}}</small>
        </div>
        <br>

        <!--
        <h2 class="card-inside-title">Registered Points</h2>
        <div class="form-group">
            <input type="radio" value="Y" name="reg_point" id="Y" >
            <label for="Y">Y</label>
                            &nbsp;
            <input type="radio" value="N" name="reg_point" id="N" checked>
            <label for="N">N</label>
        </div>
        -->
        <button id="save" class="btn btn-primary waves-effect" name="save_action" value="SAVE" type="submit" style="margin-top: 20px;">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $('#cust_type').select2({
        placeholder: 'Select a Customer Type',
    });
    $('#pareto_id').select2({
        placeholder: 'Select a Pareto Code',
    });
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
    $('#payment_term').select2({
        placeholder: 'Select a Payment Term'
    });

    $('#user').select2({
      placeholder: 'Select a Sales Representative',
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
    });

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
                    $('#code_').addClass("focused error");
                    $('#code_').siblings("label").addClass("error").text('Sorry... Code Already Exists');
                    $('#code_').siblings("small").text('');
                    $('#save').prop('disabled', true);
                    }else if (response == 'not_taken' && code !="") {
                    $('#code_').addClass("");
                    $('#code_').siblings("small").addClass("text-primary").text('Code Available');
                    $('#code_').siblings("label").text('');
                    $('#save').prop('disabled', false);
                    }
                    else if(response == 'not_taken' && code ==""){
                        $('#code_').siblings("label").text('');
                        $('#code_').siblings("small").text('');
                    }
                }
            });
        });
    });
</script>

@endsection