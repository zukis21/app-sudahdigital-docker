@extends('layouts.master')


	@section('title') Customer Target List @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif

	<div class="row">
		<div class="col-md-12">
			<a href="{{route('customers.create_target',[$vendor])}}" class="btn bg-cyan ">Create Target</a>
		</div>
	</div>
		
	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<!--<th>No</th>-->
					<th>Customers</th>
					<th>Cat</th>
					<th>Target Values (IDR)</th>
					<th>Period</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($targets as $u)
				<?php $no++;?>
				<tr>
					<!--<td>{{$no}}</td>-->
					<td>
						{{$u->customers->store_code}} | {{$u->customers->store_name}}
					</td>
					<td>
						@php
							$pareto = \App\CatPareto::where('id',$u->customers->pareto_id)->first();
						@endphp
						{{$pareto->pareto_code}}
					</td>
					<td>
						{{number_format($u->target_values)}}
					</td>
					<td>
						{{date('M-Y', strtotime($u->period))}}
					</td>
					<td>
						<a class="btn btn-info btn-xs" href="{{route('customers.edit_target',[$vendor,Crypt::encrypt($u->id)])}}"><i class="material-icons">edit</i></a>&nbsp;
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		
		
	</div>



@endsection