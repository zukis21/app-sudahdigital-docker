@extends('layouts.master')
@section('title') Create Customer Point @endsection
@section('content')
    <style>
        .show-dc-table {
            display: none;
            width: 100%;
        }
    </style>
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
    @php
        function fill_customer_select($customers)
        { 
            $output = '';
            foreach($customers as $row)
                {
                    $store_name = str_replace("'", "", $row->store_name);
                    $output .= '<option value="'.$row->id.'">'.$row->store_code.' - '.$store_name.'</option>';
                }
            return $output;
        }
    @endphp
	<!-- Form Create -->
    <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST"  action="{{route('CustomerPoints.store',[$vendor])}}">
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
        
        <div class="form-group form-radio">
            <input type="radio" class="form-check-inline" value="customer_select" 
                name="sel_input" id="cust_select" onclick='showTable();' required>
            <label for="cust_select">Choose Customers</label>
            &nbsp;
            <input type="radio" class="form-check-inline" value="all_customer" 
                name="sel_input" id="all_cust" onclick='hideTable();'>
            <label for="all_cust">All Customers</label>
            &nbsp;
            <input type="radio" class="form-check-inline" value="customer_pareto" 
                name="sel_input" id="pareto_cust" onclick='hideTable();'>
            <label for="pareto_cust">Pareto Customers Only</label>
        </div>

        <table class="table table-responsive table-striped show-dc-table showTable">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>File</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody id="TextBoxContainer" >
                <tr>
                    <td style="width: 50%">
                        <div class=" form-float">
                            <select name="customer_id[]" class="form-control customers" style="width: 100%">
                                <option></option>
                                <?php echo fill_customer_select($customers); ?>
                            </select>
                        </div>
                    </td>
                    <td >
                        <div class=" form-float">
                            <input type="file" name="file_name[]" accept=".pdf,.jpg,.jpeg,.png" placeholder="File">
                        </div>
                    </td> 
                    <td>

                    </td>
                </tr>  
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
    function showTable()
    {
        var x = document.getElementsByClassName('showTable');
        x[0].style.display = 'table';
        $('.customers').prop('required',true);
        $('.customer_id').prop('required',true);
    }
    function hideTable()
    {
        var x = document.getElementsByClassName('showTable');
        $('.customers').prop('required',false);
        $('.customer_id').prop('required',false);
        x[0].style.display = 'none';

    }

    $('.periods').select2({
        placeholder: 'Select period',
    });
    $('.customers').select2({
        placeholder: 'Select customers',
    });

    $(function () {
        $("#btnAdd").bind("click", function () {
            var div = $("<tr/>");
            div.html(GetDynamicTextBox(""));
            $("#TextBoxContainer").append(div);

            $('.customer_id').select2({
                placeholder: 'Select an item',
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
                        <div class="form-float">\
                            <select name="customer_id[]" class="form-control customer_id" required>\
                                <option></option>\
                                <?php echo fill_customer_select($customers); ?>\
                            </select>\
                        </div>\
                    </td>';
                    
        var fied2 = '<td>\
                        <div class="">\
                            <div class="form-line">\
                                <input type="file" name="file_name[]" accept=".pdf,.jpg,.jpeg,.png" placeholder="File">\
                            </div>\
                        </div>\
                    </td>';
        var del = '<td><button type="button" class="btn btn-xs btn-danger waves-effect remove"><i class="material-icons">remove_circle_outline</i></button></td>'
       
        return fied1 + fied2 + del;
        
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