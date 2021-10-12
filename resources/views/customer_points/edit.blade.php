@extends('layouts.master')
@section('title') Customer Point Lists @endsection
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

        function view_customer($customer_id){
            $cust_name = \App\Customer::findOrFail($customer_id);
            $store_code = $cust_name->store_code ?? '';
            $store_name = $cust_name->store_name ?? '';
            $viewstore = $store_code. ' - ' .$store_name;
            return $viewstore;
        }
    @endphp
	<!-- Form Create -->
    <form class="needs-validation" novalidate  method="POST" enctype="multipart/form-data"  action="{{route('CustomerPoints.update',[$vendor,$get_date->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        
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

        <table class="table table-responsive table-striped dataTable js-basic-example">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>File</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
             @foreach ($get_date->point_customers as $point)
             <tr>
                <td width="50%">
                    <input type="hidden" name="id[]" value="{{$point->id}}">
                    <input type="hidden" name="customer_id[]" class="form-control"
                    value="{{$point->customer_id}}" >
                    {{view_customer($point->customer_id)}}
                </td>
                <td>
                    <div class=" form-float">
                       <input type="file" name="file_name[]" accept=".pdf,.jpg,.jpeg,.png" 
                        autocomplete="off">
                        <?php
                            $extension = pathinfo(asset('storage/'.(($point->file != null) ? $point->file : '').''), PATHINFO_EXTENSION);
                        ?>
                            @if($point->file && $extension == 'pdf')
                                <embed src="{{ asset('storage/'.(($point->file != null) ? $point->file : '').'') }}"
                                    frameborder="0" scrolling="no" class="m-t-5" frameBorder="0"
                                    width="50px" height="50px"/>
                            @elseif($point->file)
                                <img src="{{ asset('storage/'.(($point->file != null) ? $point->file : '').'') }}"
                                class="m-t-5" width="50px"/>
                            @endif
                        <small
                            class="text-muted">Leave it blank if you don't want to change your file
                        </small>
                    </div>
                </td>
                
                <td>
                    
                    <button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$point->id}}"><i class="material-icons">delete</i></button>
                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteModal{{$point->id}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content modal-col-red">
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete Customer</h4>
                                </div>
                                <div class="modal-body">
                                    Delete this customer ?
                                </div>
                                <div class="modal-footer">
                                    
                                    <a href="{{route('Customer_Points.delete-permanent',[$vendor,$point->id])}}" class="btn btn-link waves-effect">Delete</a>
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </td>
              </tr> 
             @endforeach   
            </tbody>
            
        </table>

        <table class="table table-responsive table-striped">
            
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

        <button id="save" class="btn btn-success waves-effect" name="save_action" value="SAVE" type="submit">UPDATE</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    

    $('.periods').select2({
        placeholder: 'Select period',
    });
    $('.customers').select2({
        placeholder: 'Select customers',
    });    

    $(function () {
        $("#btnAdd").bind("click", function () {
            var div = $("<tr></tr>");
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
                        <input type="hidden" name="id[]" value="0">\
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