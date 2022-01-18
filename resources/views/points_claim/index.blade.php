@extends('layouts.master')
@section('title')Points Claim Lists @endsection
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
	<div class="col-md-12">
		<ul class="nav nav-tabs tab-col-pink pull-left" >
			<li role="presentation" class="{{Request::get('status') == NULL && Request::path() == $vendor.'/points-claim' ? 'active' : ''}}">
				<a href="{{route('ClaimPoints.index',[$vendor])}}" aria-expanded="true" >All</a>
			</li>
			<li role="presentation" class="{{Request::get('status') == 'submit' ?'active' : '' }}">
				<a href="{{route('ClaimPoints.index', [$vendor,'status' =>'submit'])}}" >SUBMIT</a>
			</li>
			
			<li role="presentation" class="{{Request::get('status') == 'finish' ?'active' : '' }}">
				<a href="{{route('ClaimPoints.index', [$vendor,'status' =>'finish'])}}">FINISH</a>
			</li>
		</ul>

		<a class="btn btn-success pull-right" href="" data-toggle="modal" data-target="#exportOrderModal">
			<i class="fas fa-file-excel fa-0x "></i> Export
		</a>
		<div class="modal fade" id="exportOrderModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<form id="form_validation" method="post" action="{{route('claim.Export',[$vendor]) }}">
						@csrf
						<div class="modal-body">
							
								<h2 class="card-inside-title">Period</h2>
								<div class="form-group">
									<select name="period"  id="period_list" 
										class="form-control" style="width:100%;" required>
										<option></option>
										@foreach($period_list as $pl)
											<option value="{{$pl->id}}">
												{{$pl->name}}
											</option>
										@endforeach
									</select>
								</div>
								
							
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-sm btn-success waves-effect">Export</button>
							<button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</div>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover claim-table">
		<thead>
			<tr>
				<th>Customer</th>
				<th>Points Claim</th>
				<th>Bonus Amount</th>
				<th>Claim Date</th>
				<th>Status</th>
				@if(\Auth::user()->roles == 'ADMIN' || \Auth::user()->roles == 'SUPERADMIN')
					<th>#</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach($claim as $c)
				<tr>
					<td>
						{{$c->store_name ? "$c->store_name" : $c->id}}
					</td>
					<td>
						{{$c->point_rule}}
					</td>
					<td>
						{{number_format($c->bonus_amount,2)}}
					</td>
					<td>
						{{$c->created_at}}	
					</td>
					<td>
						@if($c->status == "SUBMIT")
							<span class="badge bg-orange text-light">{{$c->status}}</span>
						@elseif($c->status == "FINISH")
							<span class="badge bg-green text-light">{{$c->status}}</span>
						@endif
					</td>
					@if(\Auth::user()->roles == 'ADMIN' || \Auth::user()->roles == 'SUPERADMIN')
						<td>
							
							@if ($c->status == 'SUBMIT')
								@if(Request::get('status') == NULL && Request::path() == $vendor.'/points-claim')
									<?php $status = null;?>
								@elseif(Request::get('status') == 'submit')
									<?php $status = 'SUBMIT';?>
								@endif
								<a href="{{route('claim.finish',[$vendor,$c->id,'status'=>$status])}}">
									<i class="material-icons">check_circle</i>
								</a>
							@endif	
						</td>
					@endif
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
	$(document).ready(function() {
		$('.claim-table').DataTable( {
			"order": [[ 3, "desc" ]]
		});
	});

	$('#period_list').select2({
        placeholder: 'Select Period',
    });
</script>
@endsection