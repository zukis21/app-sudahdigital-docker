@extends('layouts.master')
@section('title') Edit Points Products @endsection
@section('content')
    <style>
        .table tr { line-height: 14px; }
        .select2-selection__rendered {
            line-height: 31px !important;
        }
        .select2-container .select2-selection--single {
            height: 33.5px !important;
        }
        .select2-selection__arrow {
            height: 32px !important;
        }
    </style>
    @php
        function fill_product_select($products)
        { 
            $output = '';
            foreach($products as $row)
                {
                $output .= '<option value="'.$row->id.'">'.$row->product_code.' - '.$row->Product_name.'</option>';
                }
            return $output;
        }
    @endphp

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
    <form class="needs-validation" novalidate method="POST"  action="{{route('pr_points.update',[$vendor,$point->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th width="50%">Product</th>
                    <th>Qty Rule</th>
                    <th>Point Val</th>
                </tr>
            </thead>
            <tbody id="TextBoxContainer">
                <tr>
                    <td width="50%">
                        <div class="form-group form-float">
                            <select name="product_id" class="form-control prd_id">
                                <option></option>
                                @foreach($products as $prd)
                                    <option value="{{$prd->id}}" {{$prd->id == $point->product_id ? 'selected' : ''}}>{{$prd->product_code}} - {{$prd->Product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="">
                            <div class="form-line" id="only-number">
                                <input type="number" min="1" class="form-control" value="{{$point->quantity_rule}}" 
                                name="quantity_rule" autocomplete="off" required>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="">
                            <div class="form-line" id="only-number">
                                <input type="number" min="1" class="form-control" value="{{$point->prod_point_val}}"
                                name="prod_point_val" autocomplete="off" required>
                            </div>
                        </div>
                    </td>
                </tr>   
            </tbody>
            
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
    $('.prd_id').select2({
        placeholder: 'Select an item',
    });
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