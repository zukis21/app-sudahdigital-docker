@extends('layouts.master')
@section('title') Customer Type List @endsection
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
		<a href="{{route('type_customers.export',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-1x"></i> Export</a>&nbsp;
		<a href="{{route('type_customers.create',[$vendor])}}" class="btn bg-cyan">Create Type</a>
	</div>
</div>

<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th width="1%">No</th>
				<th>Name</th>
				<th width="13%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($customers_type as $c)
			<?php $no++;?>
			<tr>
				<td>{{$no}}</td>
				<td>
					{{$c->name}}
				</td>
				
				<td>
					<a class="btn btn-info btn-xs" href="{{route('type_customers.edit',[$vendor,Crypt::encrypt($c->id)])}}"><i class="material-icons">edit</i></a>
					
					&nbsp;
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$c->id}}"><i class="material-icons">delete</i></button>&nbsp;
					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$c->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Type</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete this type ..? 
		                        </div>
		                        <div class="modal-footer">
		                        	<form action="{{route('type_customers.delete-permanent',[$vendor,$c->id])}}" method="POST">
										@csrf
										<input type="hidden" name="_method" value="DELETE">
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

@endsection