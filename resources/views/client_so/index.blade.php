@extends('layouts.master')
@section('title') Client List @endsection
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

<form action="{{route('customers.index',[$vendor])}}">
	<div class="row">
		<div class="col-md-12">
			<a href="{{route('client_so.create',[$vendor])}}" class="btn bg-cyan">Create Client</a>
		</div>
	</div>
</form>	
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>No</th>
				<th>Client Name</th>
				<th>Email / Phone</th>
				<th width="10%">Shop/Company Name</th>
				<th >Login Email</th>
				<th>Status</th>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($client_list as $c)
			<?php $no++;?>
			<tr>
				<td>{{$no}}</td>
				<td>
					{{$c->client_name}}
				</td>
				<td>
					{{$c->email}}<br>
					<small class="text-primary"><b> Wa : </b>{{$c->phone_whatsapp != NULL ? "$c->phone_whatsapp" : '-'}}</small><br>
					<small class="text-danger"><b> Office : </b>{{$c->phone != NULL ? "$c->phone" : '-'}}</small>
				</td>
				<td>
					{{$c->company_name}}
				</td>
				<td>
					@foreach($c->users as $users)
						@if($users->created_at == $c->created_at && $users->roles == 'SUPERADMIN')
							{{$users->email}}<br>
							<small class="text-success"><b> Role : </b>{{$users->roles}}</small>
						@endif
					@endforeach
				</td>
				<td>
					@if($c->status=="INACTIVE")
					<span class="badge bg-red text-white">{{$c->status}}</span>
						@else
					<span class="badge bg-green">{{$c->status}}</span>
					@endif

				</td>
				<td>
					<button type="button" class="btn bg-{{$c->status == 'ACTIVE' ? 'orange' : 'cyan'}} btn-xs" 
						data-toggle="modal" data-target="#activeModal{{$c->id}}">
						<small>{{$c->status == 'ACTIVE' ? 'DEACTIVATE' : 'ACTIVATE'}}</small>
					</button>
					<!-- Modal deactivate -->
					<div class="modal fade" id="activeModal{{$c->id}}" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content modal-col-{{$c->status == 'ACTIVE' ? 'orange' : 'cyan'}}">
								<div class="modal-header">
									<h4 class="modal-title">{{$c->status == 'ACTIVE' ? 'Deactivate Client' : 'Activate Client'}}</h4>
								</div>
								<div class="modal-body">
									{{$c->status == 'ACTIVE' ? 'Deactivate this client ?' : 'Activate this client ?'}}
								</div>
								<div class="modal-footer">
									<form action="{{route('client_so.update',[$vendor])}}" method="POST">
										@csrf
										<input type="hidden" name="{{$c->status == 'ACTIVE' ? 'deactivate_id' : 'activate_id'}}" value="{{$c->id}}">
										<button type="submit" name="save_action" value="{{$c->status == 'ACTIVE' ? 'DEACTIVATE' : 'ACTIVATE'}}" class="btn btn-link waves-effect">{{$c->status == 'ACTIVE' ? 'Deactivate' : 'Activate'}}</button>
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

@endsection