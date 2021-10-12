@extends('layouts.master')


	@section('title')Point Period Lists @endsection
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
					<th>Cash Back Point</th>
					<th>Customer Point</th>
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
						{{$p->point_reward()->count()}}
					</td>
					<td>
						{{$p->point_customers()->count()}}
					</td>
					
					<td>
						
						<div class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
								<i class="material-icons" >apps</i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="{{route('points_periods.edit',[$vendor,Crypt::encrypt($p->id)])}}" 
									class=" waves-effect waves-block">
										Edit Period
									</a>
								</li>
								<li>
									@if($p->point_reward()->count() > 0)
										<a href="{{route('points.details',[$vendor,Crypt::encrypt($p->id)])}}" 
											class=" waves-effect waves-block">
											Cash Back Lists
										</a>
									@else
										<a href="{{route('points.create',[$vendor,Crypt::encrypt($p->id)])}}" 
											class=" waves-effect waves-block">
											Create Point Cash Back
										</a>
									@endif
								</li>
								<li>
									@if($p->point_customers()->count() > 0)
										<a href="{{route('CustomerPoints.details',[$vendor,Crypt::encrypt($p->id)])}}" 
										class=" waves-effect waves-block">
											Customer Lists
										</a>
									@else
										<a href="{{route('CustomerPoints.create',[$vendor,Crypt::encrypt($p->id)])}}" 
										class=" waves-effect waves-block">
											Create Customer Points
										</a>
									@endif
								</li>
							</ul>
						</div>
						<!--
							<a href="{{route('points_periods.edit',[$vendor,Crypt::encrypt($p->id)])}}" 
							class="btn btn-xs btn-info waves-effect">
								<i class="material-icons">edit</i>
							</a>
						-->
					</td>			
						
				</tr>
				@endforeach
			</tbody>
		</table>
		
		
	</div>



@endsection