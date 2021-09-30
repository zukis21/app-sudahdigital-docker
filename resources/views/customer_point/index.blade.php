@extends('layouts.master')
@section('title') Customer Points Lists @endsection
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
<div class="row">
	<form id="form_validation" action="{{route('periodpoint.postfilter',[$vendor])}}" method="POST">
		@csrf 
		
		<div class="col-sm-6 m-t-10">
			<div class="form-group">
				<select name="period"  id="period_list" 
					class="form-control" style="width:100%;" required>
					<option></option>
					@foreach($period_list as $pl)
						<option value="{{$pl->id}}" {{(\Route::currentRouteName() == 'periodpoint.getfilter') && ($period == $pl->id) ? 'selected' : ''}}>
							{{$pl->name}}
						</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6">
			<button class="btn btn-primary waves-effect m-t-10" type="submit">Filter</button>
			@if (\Route::currentRouteName() == 'periodpoint.getfilter')
				<a href="{{route('customers_points.index',[$vendor])}}" class="btn btn-danger waves-effect m-t-10">Reset</a>
			@endif
			<!--
			<a class="btn waves-effect btn-success pull-right m-t-10"
				data-toggle="modal" data-target="#ExportModal">
				<i class="fas fa-file-excel fa-1x"></i> 
			</a>
			-->
		</div>
	</form>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>Customer</th>
				<th>Sales</th>
				<th>Total Point</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach($customers as $c)
			
			<tr>
				<td>
					{{$c->store_name ? "$c->store_name" : '-'}}
				</td>
				<td>
					{{$c->sales_name}}
				</td>
				<td>
					{{number_format($c->totalpoint,2)}}	
		        </td>
			</tr>
			@endforeach
		</tbody>
	</table>

</div>

@endsection
@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
	$('#period_list').select2({
        placeholder: 'Select Period',
    }); 
</script>
@endsection