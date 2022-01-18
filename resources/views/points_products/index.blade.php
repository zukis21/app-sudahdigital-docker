@extends('layouts.master')


	@section('title')Product Point Lists @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<div class="row">
		
		<div class="col-md-12">
			<a href="{{route('pr_points.create',[$vendor])}}" class="btn bg-cyan ">Create</a>
		</div>
	</div>
		
	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<!--<th>No</th>-->
					<th>Product Name</th>
					<th>Quantity Rule</th>
					<th>Point</th>
					<th>Created At</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($PointsProducts as $p)
				<?php $no++;?>
				<tr>
					<!--<td>{{$no}}</td>-->
					<td>
						{{$p->products->Product_name}}
					</td>
					<td>
						{{$p->quantity_rule}}
					</td>
					<td>
						{{$p->prod_point_val}}
					</td>
					<td>
						{{date('Y-M-d', strtotime($p->created_at))}}
					</td>
					
					<td>
						
						<div class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
								<i class="material-icons" >apps</i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="{{route('pr_points.edit',[$vendor,Crypt::encrypt($p->id)])}}" 
									class=" waves-effect waves-block">
										Edit
									</a>
								</li>
								<li>
									<a  
										data-toggle="modal" data-target="#deleteModal{{$p->id}}"
										class=" waves-effect waves-block">
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
										<h4 class="modal-title" id="deleteModalLabel">Delete Item</h4>
									</div>
									<div class="modal-body">
									Delete this item permananetly..? 
									</div>
									<div class="modal-footer">
										<form action="{{route('pr_points.destroy',[$vendor,$p->id])}}" method="POST">
											@csrf
											<input type="hidden" name="_method" value="DELETE">
											<button type="submit" class="btn btn-link waves-effect">Delete</button>
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
										</form>
									</div>
								</div>
							</div>
						</div>
				</tr>
				@endforeach
			</tbody>
		</table>
		
		
	</div>



@endsection