@extends('layouts.master')


	@section('title') User Login List @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif

	<div class="row">
        <form id="form_validation" action="{{route('sales_log.postfilter',[$vendor])}}" method="POST">
            @csrf 
            <div class="col-sm-3">
                <div class="form-group">
                    <div class="form-line" id="bs_datepicker_container">
                        <input type="text" id="datepicker" name="period" class="date-picker form-control" 
                            value="{{\Route::currentRouteName() == 'sales_log.getfilter' ? $period : ''}}" 
                            placeholder="Please choose a date..." autocomplete="off" required readonly>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 m-t-10">
                <div class="form-group">
                    <select name="user_id"  id="user_id" 
                        class="form-control" style="width:100%;" required>
                        <option></option>
                        @foreach($users as $u)
                            <option value="{{$u->id}}" {{(\Route::currentRouteName() == 'sales_log.getfilter') && ($user_id == $u->id) ? 'selected' : ''}}>
                                {{$u->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <button class="btn btn-primary waves-effect m-t-10" type="submit">Filter</button>
                @if (\Route::currentRouteName() == 'sales_log.getfilter')
                    <a href="{{route('sales_login.index',[$vendor])}}" class="btn btn-danger waves-effect m-t-10">Reset</a>
                @endif
                <a class="btn waves-effect btn-success pull-right m-t-10"
                    data-toggle="modal" data-target="#ExportModal">
                    <i class="fas fa-file-excel fa-1x"></i> 
                </a>
                
            </div>
        </form>
    </div>
	<!-- Modal export -->
    <div class="modal fade" id="ExportModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel">Select Period</h4>
                </div>
                <div class="modal-body">
                    <form id="form_validation" action="{{route('sales_login.export',[$vendor])}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="form-line" id="bs_datepicker_container">
                                <input type="text" id="datepicker_export" name="period" class="date-picker form-control" 
                                    placeholder="Please choose a date..." autocomplete="off" required readonly>
                            </div>
                        </div>
                        <button type="submit" id="btnexport" class="btn waves-effect bg-blue">Export</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<!--<th>No</th>-->
                    <th>Sales Name</th>
					<th>Date</th>
					<th>First Logged In</th>
					<th>Last Logged Out</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($saleslogin as $sl)
				<?php $no++;?>
				<tr>
					<!--<td>{{$no}}</td>-->
                    <td>{{$sl->users->name}}</td>
					<td>
						{{date('d F Y', strtotime($sl->logged_in))}}
					</td>
                    <td>
						{{date('H:i:s', strtotime($sl->logged_in))}}
					</td>
					<td>
						{{$sl->logged_out ? date('H:i:s', strtotime($sl->logged_out)) : ''}}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		
		
	</div>
@endsection
@section('footer-scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $('#user_id').select2({
            placeholder: 'Select a Sales',
        });

        var dp=$("#datepicker, #datepicker_export").datepicker( {
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months",
            
        });

        dp.on('changeMonth', function (e) {
            //var dateObject = $("#datepicker").val();    
            //do something here
            $(".datepicker").hide();
            $('#btnexport').prop('disabled', false);
        });

        $('document').ready(function(){
            if($('#datepicker_export').val().length == 0){
                $('#btnexport').prop('disabled', true);
            }
        });

    </script>
@endsection