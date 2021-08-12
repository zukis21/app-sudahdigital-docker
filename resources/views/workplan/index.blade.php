@extends('layouts.master')


	@section('title') Work Plan List @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif

	<div class="row">
		<div class="col-md-12">
			<a href="{{route('workplan.create',[$vendor])}}" class="btn bg-cyan ">Create Plan Holidays</a>
		</div>
	</div>
		
	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<!--<th>No</th>-->
					<th>Period</th>
					<th>Working Days</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($workplan as $u)
				<?php $no++;?>
				<tr>
					<!--<td>{{$no}}</td>-->
					<td>
						
							{{date('F Y', strtotime($u->work_period))}}
						
					</td>
					
					<td>
						{{$u->working_days}}
					</td>
					<td>
						<a class="btn btn-info btn-xs" href="{{route('workplan.edit',[$vendor,Crypt::encrypt($u->id)])}}"><i class="material-icons">edit</i></a>

						<a class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#detailModal{{$u->id}}"><i class="material-icons">list</i></a>
						<!-- Modal Detail -->
						<div class="modal fade" id="detailModal{{$u->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="detailModalLabel">{{date('F  Y', strtotime($u->work_period))}}</h5>
										
										<h5 class="modal-title" id="detailModalLabel">
											{{$u->working_days}} working days
										</h5>
									</div>
									<div class="modal-body">
										
										<ul class="list-group">
											<li class="list-group-item active">Haolidays</li>
											@foreach($u->holidays as $hd)
												<li class="list-group-item">{{date('Y F d', strtotime($hd->date_holiday))}}</li>
											@endforeach
										</ul>
									</div>
									<div class="modal-footer">
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
		
		
	</div>



@endsection