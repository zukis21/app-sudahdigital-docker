@extends('layouts.master')

@if(Route::is('users.index'))
	@section('title') Admin List @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif

	<form action="{{route('users.index',[$vendor])}}">
		<div class="row">
			<!--
			<div class="col-md-4">
				<div class="input-group input-group-sm">
					<div class="form-line">
						<input type="text" class="form-control" name="keyword" value="{{Request::get('keyword')}}" placeholder="Filter berdasarkan email" autocomplete="off" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<input {{Request::get('status')=='ACTIVE' ? 'checked' : ''}} class="form-control" value="ACTIVE" name="status" type="radio" id="active"><label for="active">ACTIVE</label>
					&nbsp;&nbsp;
				<input {{Request::get('status')=='INACTIVE' ? 'checked' : ''}} class="form-control" value="INACTIVE" name="status" type="radio" id="inactive"><label for="inactive">INACTIVE</label>
					&nbsp;&nbsp;
				<input type="submit" class="btn bg-blue" value="Filter">
			</div>
			-->
			<div class="col-md-12">
				<a href="{{route('users.create',[$vendor])}}" class="btn btn-success pull-right">Create Admin</a>
			</div>
		</div>
	</form>	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Email</th>
					<th>Avatar</th>
					<th>Status</th>
					<th width="20%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($users as $u)
				<?php $no++;?>
				<tr>
					<td>{{$no}}</td>
					<td>{{$u->name}}</td>
					
					<td>{{$u->email}}</td>
					<td>
						<img src="{{ asset('storage/'.(($u->avatar !='') ? $u->avatar : 'image-noprofile.png').'') }}" width="50px" height="50px" />
					</td>
					<td>
						@if(($u->status)=='ACTIVE')
							<span class="badge bg-green">{{$u->status}}</span>
						@else
							<span class="badge bg-red">{{$u->status}}</span>	
						@endif
					</td>
					<td>
						<a class="btn btn-info btn-xs" href="{{route('users.edit',[$vendor,Crypt::encrypt($u->id)])}}"><i class="material-icons">edit</i></a>&nbsp;
						<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$u->id}}" {{Auth::user()->id == $u->id ? 'disabled' : ''}}>
							<i class="material-icons">delete</i>
						</button>&nbsp;
						<button type="button" class="btn bg-grey waves-effect" data-toggle="modal" data-target="#detailModal{{$u->id}}">Detail</button>

						<!-- Modal Delete -->
						<div class="modal fade" id="deleteModal{{$u->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content modal-col-red">
									<div class="modal-header">
										<h4 class="modal-title" id="deleteModalLabel">Delete User</h4>
									</div>
									<div class="modal-body">
									Delete this user permananetly..? 
									</div>
									<div class="modal-footer">
										<form action="{{route('users.destroy',[$vendor,$u->id])}}" method="POST">
											@csrf
											<input type="hidden" name="_method" value="GET">
											<button type="submit" class="btn btn-link waves-effect">Delete</button>
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
										</form>
									</div>
								</div>
							</div>
						</div>

						<!-- Modal Detail -->
						<div class="modal fade" id="detailModal{{$u->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog" role="document">
								<div class="modal-content modal-col-indigo">
									<div class="modal-header">
										<h4 class="modal-title" id="detailModalLabel">Detail User</h4>
									</div>
									<div class="modal-body">
									<b>Name:</b>
									<br/>
									{{$u->name}}
									<br/>
									<br/>
									
									<img src="{{ asset('storage/'.(($u->avatar !='') ? $u->avatar : 'image-noprofile.png').'') }}" width="128px"/>
									
									<br/>
									<br/>
									<b>UserName:</b>
									<br/>
									{{$u->email}}
									<br/>
									<br/>
									<b>Phone Number:</b>
									<br/>
									{{$u->phone}}
									<br/>
									<br/>
									<b>Address:</b>
									<br/>
									{{$u->address}}
									<br/>
									<br/>
									<b>Roles:</b>
									<br/>
									{{$u->roles}}
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
@endif

@if(Route::is('sales.index'))
	@section('title') Sales List @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif

	<form action="{{route('sales.index',[$vendor])}}">
		<div class="row">
			<!--
			<div class="col-md-4">
				<div class="input-group input-group-sm">
					<div class="form-line">
						<input type="text" class="form-control" name="keyword" value="{{Request::get('keyword')}}" placeholder="Filter berdasarkan email" autocomplete="off" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<input {{Request::get('status')=='ACTIVE' ? 'checked' : ''}} class="form-control" value="ACTIVE" name="status" type="radio" id="active"><label for="active">ACTIVE</label>
					&nbsp;&nbsp;
				<input {{Request::get('status')=='INACTIVE' ? 'checked' : ''}} class="form-control" value="INACTIVE" name="status" type="radio" id="inactive"><label for="inactive">INACTIVE</label>
					&nbsp;&nbsp;
				<input type="submit" class="btn bg-blue" value="Filter">
			</div>
			-->
			<div class="col-md-12">
				<a href="{{route('sales.export',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-1x"></i> Export</a>&nbsp;
				<a href="{{route('sales.create',[$vendor])}}" class="btn bg-cyan ">Create Sales</a>
			</div>
		</div>
	</form>	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Email</th>
					<th>Image Profile</th>
					<th>Sales Area</th>
					<th>Status</th>
					<th width="20%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($users as $u)
				<?php $no++;?>
				<tr>
					<td>{{$no}}</td>
					<td>{{$u->name}}</td>
					
					<td>{{$u->email}}</td>
					<td>
						<img src="{{ asset('storage/'.(($u->avatar !='') ? $u->avatar : 'image-noprofile.png').'') }}" width="50px" height="50px" />
					</td>
					
					<td>
						{{$u->sales_area}}
					</td>
					<td>
						@if(($u->status)=='ACTIVE')
							<span class="badge bg-green">{{$u->status}}</span>
						@else
							<span class="badge bg-red">{{$u->status}}</span>	
						@endif
					</td>
					<td>
						<a class="btn btn-info btn-xs" href="{{route('sales.edit',[$vendor,Crypt::encrypt($u->id)])}}"><i class="material-icons">edit</i></a>&nbsp;
						<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$u->id}}"><i class="material-icons">delete</i></button>&nbsp;
						<button type="button" class="btn bg-grey waves-effect" data-toggle="modal" data-target="#detailModal{{$u->id}}">Detail</button>

						<!-- Modal Delete -->
						<div class="modal fade" id="deleteModal{{$u->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content modal-col-red">
									<div class="modal-header">
										<h4 class="modal-title" id="deleteModalLabel">Delete Sales</h4>
									</div>
									<div class="modal-body">
									Delete this sales permananetly..? 
									</div>
									<div class="modal-footer">
										<form action="{{route('sales.destroy',[$vendor,$u->id])}}" method="POST">
											@csrf
											<input type="hidden" name="_method" value="GET">
											<button type="submit" class="btn btn-link waves-effect">Delete</button>
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
										</form>
									</div>
								</div>
							</div>
						</div>

						<!-- Modal Detail -->
						<div class="modal fade" id="detailModal{{$u->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content  modal-col-cyan">
									<div class="modal-header">
										<h5 class="modal-title">Detail Sales</h5>
									</div>
									<div class="modal-body">
										<div class="col-md-4" style="margin-top: 20px;">
											<img src="{{ asset('storage/'.(($u->avatar !='') ? $u->avatar : 'image-noprofile.png').'') }}" width="128px"/>
										</div>
										
										<div class="col-md-8" style="margin-top: 30px;">
											<b><small>Name:</small></b>
											<br>
											{{$u->name}}
											<br/>
											<br/>
											<b><small>Email:</small></b>
											<br/>
											{{$u->email}}
											<br/>
											<br/>
											<b><small>Phone Number:</small></b>
											<br/>
											{{$u->phone}}
											<br/>
											<br/>
											<b><small>Address:</small></b>
											<br/>
											{{$u->address}}
											<br/>
											<br/>
											<b><small>Sales Area:</small></b>
											<br/>
											{{$u->sales_area}}
											<br/>
											<br/>
											<b><small>Profil Description:</small></b>
											<br/>
											@if($u->profil_desc)
												{{$u->profil_desc}}
											@else
											N/A
											@endif
										</div>
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
@endif

@if(Route::is('spv.index'))
	@section('title') Supervisor List @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif

	<form action="{{route('spv.index',[$vendor])}}">
		<div class="row">
			<!--
			<div class="col-md-4">
				<div class="input-group input-group-sm">
					<div class="form-line">
						<input type="text" class="form-control" name="keyword" value="{{Request::get('keyword')}}" placeholder="Filter berdasarkan email" autocomplete="off" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<input {{Request::get('status')=='ACTIVE' ? 'checked' : ''}} class="form-control" value="ACTIVE" name="status" type="radio" id="active"><label for="active">ACTIVE</label>
					&nbsp;&nbsp;
				<input {{Request::get('status')=='INACTIVE' ? 'checked' : ''}} class="form-control" value="INACTIVE" name="status" type="radio" id="inactive"><label for="inactive">INACTIVE</label>
					&nbsp;&nbsp;
				<input type="submit" class="btn bg-blue" value="Filter">
			</div>
			
			<div class="col-md-12">
				<a href="{{route('sales.export',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-1x"></i> Export</a>&nbsp;
				<a href="{{route('sales.create',[$vendor])}}" class="btn bg-cyan ">Create Sales</a>
			</div>
			-->
			<div class="col-md-12">
				<a href="{{route('spv.create',[$vendor])}}" class="btn btn-success pull-right">Create SPV</a>
			</div>
		</div>
	</form>	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Email</th>
					<th>Image Profile</th>
					<th>Sales Team</th>
					<th>Status</th>
					<th width="20%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($users as $u)
				<?php $no++;?>
				<tr>
					<td>{{$no}}</td>
					<td>{{$u->name}}</td>
					
					<td>{{$u->email}}</td>
					<td>@if($u->avatar)
						<img src="{{asset('storage/'.$u->avatar)}}" width="50px" height="50px" />
						@else
						<img src="{{asset('assets/image/image-noprofile.png')}}" width="50px" height="50px" />
						@endif
					</td>
					
					<td>
						@if($u->spv->count() > 0)
							@foreach($u->spv as $spv)
								@php
									$name = \App\User::where('id',$spv->sls_id)->first();
								@endphp
									<li><small>{{$name->name}}</small></li>
							@endforeach
						@else
							--No member active--
						@endif
					</td>
					<td>
						@if(($u->status)=='ACTIVE')
							<span class="badge bg-green">{{$u->status}}</span>
						@else
							<span class="badge bg-red">{{$u->status}}</span>	
						@endif
					</td>
					<td>
						<a class="btn btn-info btn-xs" href="{{route('spv.edit',[$vendor,Crypt::encrypt($u->id)])}}"><i class="material-icons">edit</i></a>&nbsp;
						<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$u->id}}"><i class="material-icons">delete</i></button>&nbsp;
						
						<!-- Modal Delete -->
						<div class="modal fade" id="deleteModal{{$u->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content modal-col-red">
									<div class="modal-header">
										<h4 class="modal-title" id="deleteModalLabel">Delete Supervisor</h4>
									</div>
									<div class="modal-body">
									Delete this supervisor permananetly..? 
									</div>
									<div class="modal-footer">
										<form action="{{route('spv.destroy',[$vendor,$u->id])}}" method="POST">
											@csrf
											<input type="hidden" name="_method" value="GET">
											<input type="hidden" name="del_id" value="{{$u->id}}">
											<button type="submit" class="btn btn-link waves-effect">Delete</button>
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
										</form>
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
@endif
@endsection