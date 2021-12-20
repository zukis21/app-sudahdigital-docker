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
	</div>
	
</div>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover claim-table">
		<thead>
			<tr>
				<th>Customer</th>
				<th>Claim Amount</th>
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
</script>
@endsection