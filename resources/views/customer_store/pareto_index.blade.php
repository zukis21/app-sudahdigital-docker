@extends('layouts.master')
@section('title') Pareto Code List @endsection
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
		<!--<a href="{{route('type_customers.export',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-1x"></i> Export</a>&nbsp;-->
		<a href="{{route('pareto_customers.create',[$vendor])}}" class="btn bg-cyan">Create Pareto Code</a>
	</div>
</div>

<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th width="1%">#</th>
				<th>ID</th>
				<th>Pareto Code</th>
				<th>Position</th>
				<th width="13%">Action</th>
			</tr>
		</thead>
		<tbody id="tablecontents">
			<?php $no=0;?>
			@foreach($pareto as $c)
			<?php $no++;?>
			<tr class="row1" data-id="{{ $c->id }}">
				<td><i class="fa fa-sort"></i></td>
				<td>
					{{$c->id}}
				</td>
				<td>
					{{$c->pareto_code}}
				</td>
				<td>
					{{$c->position}}
				</td>
				<td>
					<a class="btn btn-info btn-xs" href="{{route('pareto_customers.edit',[$vendor,Crypt::encrypt($c->id)])}}"><i class="material-icons">edit</i></a>
					
					&nbsp;
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$c->id}}"><i class="material-icons">delete</i></button>&nbsp;
					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$c->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Pareto Code</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete this code ..? 
		                        </div>
		                        <div class="modal-footer">
		                        	<form action="{{route('pareto_customers.delete-permanent',[$vendor,$c->id])}}" method="POST">
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
			url: '{{URL::to('/ajax/post-sortable-pareto')}}',
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

	$(document).ajaxStop(function(){
    	window.location.reload();
	});
		
	</script>
@endsection