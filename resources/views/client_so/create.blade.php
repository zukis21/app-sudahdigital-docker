@extends('layouts.master')
@section('title') Create Client @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('client_so.store',[$vendor])}}">
    	@csrf
        <div class="form-group form-float">
            <div class="form-line" id="code_" class="code_">
                <input type="text" class="form-control" id="code" value="{{old('client_name')}}" name="client_name" autocomplete="off" required>
                <label class="form-label">Client Name</label>
            </div>
            <label id="name-error" class=""></label>
            <small class=""></small>
        </div>

        <div class="form-group form-float">
            <div class="form-line" id="email_" class="email_">
                <input type="email" class="form-control" value="{{old('email')}}" id="email"  name="email" autocomplete="off" required>
                <label class="form-label">Client Email</label>
            </div>
            <small class="err_exist"></small>
        </div>

        <div class="form-group form-float">
            <div class="form-line" id="login_email_" class="login_email_">
                <input type="email" class="form-control" value="{{old('email')}}" id="login_email"  name="login_email" autocomplete="off" required>
                <label class="form-label">Add Login Email</label>
            </div>
            <small class="err_exist_login"></small>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{old('company_name')}}" class="form-control" name="company_name" autocomplete="off" required>
                <label class="form-label">Shop/Company Name</label>
            </div>
        </div>
        
        <div class="form-group form-float">
            <div class="form-line">
                <div class="input-group">
                    <span class="input-group-addon">+62</span>
                    <input id="phone_whatsapp" type="text" class="form-control" placeholder="Whatsapp  (Ex: 81211111111)" 
                    name="phone_whatsapp" onkeypress="return isNumberKey(event)" 
                    value="{{old('phone_whatsapp')}}" autocomplete="off" required>
                </div>
                
            </div>
            <div class="help-info">Min.10, Max. 13 Characters</div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" id="txtNumber" class="form-control" onkeypress="return isNumberKey(event)" 
                name="phone"  autocomplete="off" value="{{old('phone')}}">
                <label class="form-label">Office Phone</label>
            </div>
        </div>

        <div class="form-group">
            <div class="form-line">
                <textarea name="client_address" rows="4" 
                class="form-control no-resize" placeholder="Address" 
                autocomplete="off" required>{{old('client_address')}}</textarea>
            </div>
        </div>

        <button class="btn btn-primary waves-effect" id="save" name="save_action" value="SAVE" type="submit" style="margin-top: 20px;">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
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

    /*$("#code").on({
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
    });*/

    $('document').ready(function(){
        $('#code, .btn').on('keyup blur', function(){
        var code = $('#code').val();
            $.ajax({
                url: '{{URL::to('/ajax/name_client_so/search')}}',
                type: 'get',
                data: {
                    'code' : code,
                },
                success: function(response){
                    if (response == 'taken' && code !="" ) {
                    $('#code_').addClass("focused error");
                    $('#code_').siblings("label").addClass("error").text('Sorry... Name Already Exists');
                    $('#code_').siblings("small").text('');
                    $('#save').prop('disabled', true);
                    }else if (response == 'not_taken' && code !="") {
                    $('#code_').addClass("");
                    $('#code_').siblings("small").addClass("text-primary").text('Name Available');
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

    $('document').ready(function(){
            $('#email, .btn').on('keyup blur', function(){
            var email = $('#email').val();
                $.ajax({
                    url: '{{URL::to('/ajax/email_client_so/search')}}',
                    type: 'get',
                    data: {
                        'email' : email,
                    },
                    success: function(response){
                        if (response == 'taken' && email !="" ) {
                        $('.email_').addClass("focused error");
                        $('.err_exist').addClass("small").addClass('merah').text('Sorry... Email Already Exists');
                        $('#save').prop('disabled', true);
                        }else if (response == 'not_taken' && email !="") {
                        $('.email_').addClass("");
                        $('.err_exist').addClass("text-primary").removeClass('merah').text('Email Available');
                        $('#save').prop('disabled', false);
                        }
                        else if(response == 'not_taken' && email==""){
                            //$('#email_').siblings("label").text('');
                            $('.err_exist').text('');
                        }
                    }
                });
            });
    });

    $('document').ready(function(){
            $('#login_email, .btn').on('keyup blur', function(){
            var email = $('#login_email').val();
                $.ajax({
                    url: '{{URL::to('/ajax/users_email/search')}}',
                    type: 'get',
                    data: {
                        'email' : email,
                    },
                    success: function(response){
                        if (response == 'taken' && email !="" ) {
                        $('.login_email_').addClass("focused error");
                        $('.err_exist_login').addClass("small").addClass('merah').text('Sorry... Email Already Exists');
                        $('#save').prop('disabled', true);
                        }else if (response == 'not_taken' && email !="") {
                        $('.login_email_').addClass("");
                        $('.err_exist_login').addClass("text-primary").removeClass('merah').text('Email Available');
                        $('#save').prop('disabled', false);
                        }
                        else if(response == 'not_taken' && email==""){
                            //$('#email_').siblings("label").text('');
                            $('.err_exist_login').text('');
                        }
                    }
                });
            });
        });
</script>

@endsection