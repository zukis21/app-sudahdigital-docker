@extends('layouts.master')


	@section('title')Point Period Lists @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<div class="row">
		
		<div class="col-md-12">
			<a href="{{route('points_periods.create',[$vendor])}}" class="btn bg-cyan ">Create</a>
		</div>
	</div>
		
	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<!--<th>No</th>-->
					<th>Name</th>
					<th>Starts Date</th>
					<th>End Date</th>
					<th>Created At</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($PointsPeriods as $p)
				<?php $no++;?>
				<tr>
					<!--<td>{{$no}}</td>-->
					<td>
						{{$p->name}}
					</td>
					<td>
						{{date('Y-M-d', strtotime($p->starts_at))}}
					</td>
					<td>
						{{date('Y-M-d', strtotime($p->expires_at))}}
					</td>
					<td>
						{{date('Y-M-d', strtotime($p->created_at))}}
					</td>
					
					<td>
						
						<a href="{{route('points_periods.edit',[$vendor,Crypt::encrypt($p->id)])}}" 
						class="btn btn-xs btn-info waves-effect">
							<i class="material-icons">edit</i>
						</a>
					</td>			
						
				</tr>
				@endforeach
			</tbody>
		</table>
		
		
	</div>



@endsection