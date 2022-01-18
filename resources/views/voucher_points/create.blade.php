@extends('layouts.master')
@section('title') Create Point @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
    @if(session('error'))
		<div class="alert alert-danger">
			{{session('error')}}
		</div>
	@endif
	<!-- Form Create -->
    <form class="needs-validation" novalidate method="POST"  action="{{route('points.store',[$vendor])}}">
    	@csrf
        
        
        <div class="form-group form-float">
            <div class="form-line" >
                <input type="text" class="form-control" name="name" 
                value="{{old('name',$get_date->name)}}"
                autocomplete="off" required readonly>
                <label class="form-label">Name</label>
            </div>
        </div>

        <div class="input-daterange input-group" id="">
            <div class="form-line">
                <input type="text"  name="starts_at" value="{{old('starts_at',date('Y-m-d', strtotime($get_date->starts_at)))}}"
                class="start_date form-control" 
                readonly required placeholder="Date start..." readonly>
            </div>
            <span class="input-group-addon">to</span>
            <div class="form-line">
                <input type="text" name="expires_at" value="{{old('expires_at',date('Y-m-d', strtotime($get_date->expires_at)))}}"
                class="expires_date form-control" 
                readonly required placeholder="Date end..." readonly>
            </div>
        </div>
        <input type="hidden" value="{{$get_date->id}}" name="period_id">
        
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>Point Rules (Points)</th>
                    <th>Bonus Amount (IDR)</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody id="TextBoxContainer">
                
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">
                        <button id="btnAdd" type="button" class="btn btn-xs btn-primary waves-effect" data-toggle="tooltip" data-original-title="Add more controls">
                            <i class="material-icons">add_circle_outline</i></button>
                    </th>
                </tr>
            </tfoot>
        </table>

        <button id="save" class="btn btn-success waves-effect" name="save_action" value="SAVE" type="submit">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    

    $(function () {
        $("#btnAdd").bind("click", function () {
            var div = $("<tr></tr>");
            div.html(GetDynamicTextBox(""));
            $("#TextBoxContainer").append(div);

            $(function() {
                $('.only-number').on('keydown', '.number', function(e){
                    -1!==$
                    .inArray(e.keyCode,[46,8,9,27,13,110,190]) || /65|67|86|88/
                    .test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey)
                    || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey|| 48 > e.keyCode || 57 < e.keyCode)
                    && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
                });
            });

            $("input[data-type='currency']").on({
                keyup: function() {
                formatCurrency($(this));
                },
                blur: function() { 
                formatCurrency($(this), "blur");
                }
            });
        });
    
        $("body").on("click", ".remove", function () {
            $(this).closest("tr").remove();
        });
    
        $("body").on("click", ".add", function () {
            // code to call the ajax and insert
            var row = returnValues();
            $(this).closest("tr").html(row);
        });
    });

    function GetDynamicTextBox() {
        
        var fied1 = '<td>\
                        <div class="">\
                            <div class="form-line only-number">\
                                <input type="text" class="form-control number" name="point_rule[]" autocomplete="off" required>\
                            </div>\
                        </div>\
                    </td>';
                    
        var fied2 = '<td>\
                        <div class="">\
                            <div class="form-line">\
                                <input type="text" class="form-control currency-field" name="bonus_amount[]" \
                                data-type="currency" autocomplete="off" required>\
                            </div>\
                        </div>\
                    </td>';
        var del = '<td><button type="button" class="btn btn-xs btn-danger waves-effect remove"><i class="material-icons">remove_circle_outline</i></button></td>'
       
        return fied1 + fied2 + del;
        
    }

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
            input_val = formatNumber(input_val);
        }

        input.val(input_val);

        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    (function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
    })();
</script>

@endsection