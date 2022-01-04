@extends('layouts.master')
@section('title') Volume Discount List @endsection
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
<form action="{{route('products.index',[$vendor])}}">
	<div class="row">
		<div class="col-md-12">
			<a href="{{route('vDiscount.create',[$vendor])}}" class="btn bg-cyan pull-right">Create</a>
		</div>
	</div>
</form>	
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>Name</th>
				<th>Type</th>
				<th>Min Order</th>
				<th>Max Order</th>
				<th width="18%">Product Amount</th>
				<th>Status</th>
				<th>#</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($vDiscounts as $v)
			<?php $no++;?>
			<tr>
				<td>{{$v->name}}</td>
				<td>
					@if ($v->type == 1)
					Combine
					@elseif($v->type == 2)
					Item
					@endif
				</td>
				<td>
					{{$v->min_order}}
				</td>
				<td>
					{{$v->max_order == 0 ? '~' : $v->max_order}}
				</td>
				<td>
					{{$v->TotalItem}} Item
				</td>
				<td>
					@if($v->status=="ACTIVE")
						<span class="badge bg-green text-white">{{$v->status}}</span>
					@elseif($v->status=="INACTIVE")
						<span class="badge bg-red">{{$v->status}}</span>
					@endif
				</td>
				<td>
					<div class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
							<i class="material-icons" >apps</i>
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								
								<a href="{{route('ProductDiscVolume.create',[$vendor,Crypt::encrypt($v->id)])}}" 
								class=" waves-effect waves-block">
									Edit & Details
								</a>
								
							</li>
							<li>
								@if($v->status=="ACTIVE")
									<a href="{{route('vDiscount.status',[$vendor,$v->id,'INACTIVE'])}}" 
									class=" waves-effect waves-block">
										Inactivates
									</a>
								@else
									<a 
										href="{{$v->TotalItem < 1 ? '#' : route('vDiscount.status',[$vendor,$v->id,'ACTIVE'])}}" 
										class=" waves-effect waves-block">
											Activates
									</a>
								@endif
							</li>
						</ul>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</div>

@endsection
