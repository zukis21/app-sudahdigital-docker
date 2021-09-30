@extends('layouts.master')


	@section('title') Point Lists @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-tabs tab-col-pink pull-left" >
				<li role="presentation" class="{{Request::path() == $vendor.'/point-vouchers' ? 'active' : ''}}">
					<a href="{{route('points.index',[$vendor])}}" aria-expanded="true" >All</a>
				</li>
				<li role="presentation" class="active">
					<a href="{{route('points.trash',[$vendor])}}" >TRASH</a>
				</li>
			</ul>
		</div>
		<div class="col-md-12">
			<a href="{{route('points.create',[$vendor])}}" class="btn bg-cyan ">Create Point</a>
		</div>
	</div>
		
	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<!--<th>No</th>-->
					<th>Name</th>
					<th>Point Rules</th>
					<th>Bonus Amount</th>
					<th>Start At</th>
					<th>Expires</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($pointlist as $p)
				<?php $no++;?>
				<tr>
					<!--<td>{{$no}}</td>-->
					<td>
						{{$p->name}}
					</td>
					<td>
						{{$p->point_rule}} Point
					</td>
					<td>
						{{number_format($p->bonus_amount)}}
					</td>
					<td>
						{{date('Y-M-d', strtotime($p->starts_at))}}
					</td>
					<td>
						{{date('Y-M-d', strtotime($p->expires_at))}}
					</td>
					<td>
						<div class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
								<i class="material-icons" >apps</i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li><a href="javascript:void(0);" class=" waves-effect waves-block" 
									data-toggle="modal" data-target="#restoreModal{{$p->id}}">
									Restore
									</a>
								</li>
								<li><a href="javascript:void(0);" class=" waves-effect waves-block" 
									data-toggle="modal" data-target="#deleteModal{{$p->id}}">
									Delete
									</a>
								</li>
							</ul>
						</div>
						<!-- Modal Delete -->
						<div class="modal fade" id="deleteModal{{$p->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content modal-col-red">
									<div class="modal-header">
										<h4 class="modal-title" id="deleteModalLabel">Delete Points</h4>
									</div>
									<div class="modal-body">
									   Delete permanently this point ..? 
									</div>
									<div class="modal-footer">
										<form action="{{route('points.delete-permanent',[$vendor,$p->id])}}" method="POST">
											@csrf
											<input type="hidden" name="_method" value="DELETE">
											<button type="submit" class="btn btn-link waves-effect">Delete</button>
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
										</form>
									</div>
								</div>
							</div>
						</div>
	
						   <!-- Modal Resotore -->
						   <div class="modal fade" id="restoreModal{{$p->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content modal-col-green">
									<div class="modal-header">
										<h4 class="modal-title" id="restoreModalLabel">Restore Points</h4>
									</div>
									<div class="modal-body">
									Restore this points ..? 
									</div>
									<div class="modal-footer">
										
											<a href="{{route('points.restore', [$vendor,$p->id])}}" class="btn bg-green">Restore</a>
											<button type="button" class="btn bg-green" data-dismiss="modal">Close</button>
										
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