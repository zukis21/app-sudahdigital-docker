@extends('layouts.master')


	@section('title') Customer Point Lists @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<div class="row">
		
		<div class="col-md-12">
			<a href="{{route('CustomerPoints.create',[$vendor])}}" class="btn bg-cyan ">Create Customer Point</a>
		</div>
	</div>
		
	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover order-table">
			<thead>
				<tr>
					<!--<th>No</th>-->
					<th>Name</th>
					<th>Starts Date</th>
					<th>End Date</th>
					<th>Customer Total</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($period as $p)
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
						{{$p->point_customers()->count()}} 
						
					</td>
					<td>
						<div class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
								<i class="material-icons" >apps</i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="{{route('CustomerPoints.details',[$vendor,Crypt::encrypt($p->id)])}}" 
									class=" waves-effect waves-block">
										Details
									</a>
								</li>
								<!--
								<li><a href="javascript:void(0);" class=" waves-effect waves-block" 
									data-toggle="modal" data-target="#deleteModal{{$p->id}}">
										Trash
									</a>
								</li>
								-->
							</ul>
						</div>
						<!-- Modal Delete 
						<div class="modal fade" id="deleteModal{{$p->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content modal-col-red">
									<div class="modal-header">
										<h4 class="modal-title" id="deleteModalLabel">Points Move to Trash</h4>
									</div>
									<div class="modal-body">
									   Move to trash this point ..? 
									</div>
									<div class="modal-footer">
										<form action="{{route('points.destroy',[$vendor,$p->id])}}" method="POST">
											@csrf
											<input type="hidden" name="_method" value="DELETE">
											
											<button type="submit" class="btn btn-link waves-effect">Trash</button>
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						-->
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		
		
	</div>
@endsection
@section('footer-scripts')
<script>
	$(document).ready(function() {
		$('.order-table').DataTable( {
			"order": [[ 0, "desc" ]]
		});
	});
</script>
@endsection
