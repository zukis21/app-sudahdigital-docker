@extends('layouts.master')
@section('title') Details Point @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form class="needs-validation" novalidate method="POST"  action="{{route('points.update',[$vendor,$PointPeriod->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line" >
                <input type="text" class="form-control" name="name"
                value="{{old('name',$PointPeriod->name)}}" autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>
        <div class="input-daterange input-group" id="">
            <div class="form-line">
                <input type="text"  name="starts_at" value="{{old('starts_at',date('Y-m-d', strtotime($PointPeriod->starts_at)))}}"
                class="start_date form-control" 
                readonly required placeholder="Date start...">
            </div>
            <span class="input-group-addon">to</span>
            <div class="form-line">
                <input type="text" name="expires_at" value="{{old('expires_at',date('Y-m-d', strtotime($PointPeriod->expires_at)))}}"
                class="expires_date form-control" 
                readonly required placeholder="Date end...">
            </div>
        </div>

        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>Point Rules</th>
                    <th>Bonus Amount</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody id="TextBoxContainer">
             @foreach ($PointPeriod->point_reward as $point)
             <tr>
                <td>
                    <input type="hidden" name="id[]" value="{{$point->id}}">
                    <div class="">
                        <div class="form-line only-number">
                            <input type="text" class="form-control number"
                            value="{{$point->point_rule}}" 
                            name="point_rule[]" autocomplete="off" required>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="">
                        <div class="form-line">
                            <input type="text" class="form-control currency-field" name="bonus_amount[]"
                            value="{{number_format($point->bonus_amount)}}" 
                            data-type="currency" autocomplete="off" required>
                        </div>
                    </div>
                </td>
                
                <td>
                    @if(count($PointPeriod->point_reward) > 1)
                    <button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$point->id}}"><i class="material-icons">delete</i></button>
                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteModal{{$point->id}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content modal-col-red">
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete Item</h4>
                                </div>
                                <div class="modal-body">
                                    Delete this item ?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{route('points.delete-permanent',[$vendor,$point->id,$PointPeriod->id])}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        
                                        <button type="submit" name="save_action" value="DELETE_ITEM" class="btn-link waves-effect">Delete</button>
                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </td>
              </tr> 
             @endforeach   
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

        <button id="save" class="btn btn-success waves-effect" name="save_action" value="SAVE" type="submit">UPDATE</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script>
    var start_date = <?php echo json_encode($start_date); ?>;
    var end_date = <?php echo json_encode($end_date); ?>;
    if(start_date != '' && end_date != ''){
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            startDate: new Date(start_date),
            endDate: new Date(end_date),
            autoclose: true,
        });
    }else if(start_date == '' && end_date != ''){
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            //startDate: new Date(start_date),
            endDate: new Date(end_date),
            autoclose: true,
        });
    }else if(start_date != '' && end_date == ''){
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            startDate: new Date(start_date),
            //endDate: new Date(end_date),
            autoclose: true,
        });
    }else{
        $('.input-daterange').datepicker({
            autoclose: true,
        });
    }

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
                        <input type="hidden" name="id[]" value="0">\
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
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                //input_val = "$" + input_val;
                
                // final formatting
                /*if (blur === "blur") {
                input_val += ".00";
                }*/
            }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
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