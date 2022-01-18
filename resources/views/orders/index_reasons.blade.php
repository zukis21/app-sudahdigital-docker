@extends('layouts.master')
@section('title') Checkout Reason List @endsection
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
<form action="{{route('reasons.index',[$vendor])}}">
	<div class="row">
		<div class="col-md-12">
			<a href="{{route('reasons.create',[$vendor])}}" class="btn btn-success">Create Reasons</a>
		</div>
	</div>
</form>
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th width="1%">#</th>
				<th>Name</th>
				<th width="20%">Actions</th>
			</tr>
		</thead>
		<tbody id="tablecontents">
			<?php $no=0;?>
			@foreach($reasons as $r)
			<?php $no++;?>
			<tr class="row1" data-id="{{ $r->id }}">
				<td><i class="fa fa-sort"></i></td>
				<td>{{$r->reasons_name}}</td>
				<td>
					<a class="btn btn-info btn-xs" href="{{route('reasons.edit',[$vendor,Crypt::encrypt($r->id)])}}"><i class="material-icons">edit</i></a>&nbsp;
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$r->id}}"><i class="material-icons">delete</i></button>&nbsp;
					

					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$r->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Reasons</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete this Reasons ..? 
		                        </div>
		                        <div class="modal-footer">
		                        	<form action="{{route('reasons.delete_permanent',[$vendor,$r->id])}}" method="POST">
										@csrf
										<input type="hidden" name="_method" value="GET">
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
@section('footer-scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript">
		$(function () {
		$( "#tablecontents" ).sortable({
			items: "tr",
			cursor: 'move',
			opacity: 0.6,
			update: function() {
				sendOrderToServer();
			}
		});

		function sendOrderToServer() {
			var order = [];
			var token = $('meta[name="csrf-token"]').attr('content');
			$('tr.row1').each(function(index,element) {
			order.push({
				id: $(this).attr('data-id'),
				position: index+1
			});
			});

			$.ajax({
			type: "POST", 
			dataType: "json", 
			url: '{{URL::to('/ajax/post-sortable-reasons')}}',
				data: {
				posit: order,
				_token: token
			},
			success: function(response) {
				if (response.status == "success") {
					console.log(response);
					} else {
					console.log(response);
				}
				
			}
			});
		}
		});
	</script>
@endsection