@extends('layouts.master')
@section('title') Product List @endsection
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
		<!--
		<div class="col-md-3">
			<div class="input-group input-group-sm">
        		<div class="form-line">
	            	<input type="text" class="form-control" name="keyword" value="{{Request::get('keyword')}}" placeholder="Filter by product name" autocomplete="off" />
	    		</div>
	        </div>
		</div>
		<div class="col-md-2">
			<input type="submit" class="btn bg-blue pull-left" value="Filter">
		</div>
		-->
		<div class="col-md-12">
			<ul class="nav nav-tabs tab-col-pink pull-left" role="tablist">
				<li role="presentation" class="{{Request::get('status') == NULL && Request::path() == 'products' ? 'active' : ''}}">
					<a href="{{route('products.index',[$vendor])}}" aria-expanded="true" >All</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'publish' ?'active' : '' }}">
					<a href="{{route('products.index', [$vendor,'status' =>'publish'])}}" >PUBLISH</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'draft' ?'active' : '' }}">
					<a href="{{route('products.index', [$vendor,'status' =>'draft'])}}">DRAFT</a>
				</li>
				@if($stock_status)
					@if($stock_status->stock_status == 'ON')
					<li role="presentation" class="">
						<a href="{{route('products.low_stock',[$vendor])}}">STOCK TRESHOLD</a>
					</li>
					@endif
				@endif
				<li role="presentation" class="{{Request::get('status') == 'inactive' ?'active' : '' }}">
					<a href="{{route('products.index', [$vendor,'status' =>'inactive'])}}">INACTIVE</a>
				</li>
				<li role="presentation" class="active">
					<a href="{{route('products.trash',[$vendor])}}">TRASH</a>
				</li>
			</ul>
		</div>
		<div class="col-md-12">
			<div class="demo-switch">
				<a href="{{route('products.import_products',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-0x "></i> Import</a>&nbsp;
				<a href="{{route('products.export_all',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-0x "></i> Export</a>&nbsp;
				<a href="{{route('products.create',[$vendor])}}" class="btn bg-cyan" style="padding:8px;">Create Product</a> &nbsp;
				<span class="label label-warning" style="padding:10px;"><label>ON / OFF STOCK</label>
					<div class="switch">
						<label>OFF<input id="check_onoff_stock" type="checkbox" {{$stock_status && $stock_status->stock_status == 'ON' ? 'checked' : ''}}><span class="lever"></span>ON</label>
					</div>
				</span>
			</div>
		</div>
	</div>
</form>	
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<!--<th>No</th>-->
				<!--
				<th>Product Image</th>
				<th>Product Code</th>
				<th>Product Name</th>
				-->
				<th>Product</th>
				<th>Category</th>
				@if($stock_status && $stock_status->stock_status == 'ON')
					<th>Inv. Stock</th>
					<th>Avail. for Sale</th>
					<th>Treshold</th>
				@endif
				<th>Price</th>
				<th>Status</th>
				<th >#</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($products as $p)
			<?php $no++;?>
			<tr>
				<!--<td>{{$no}}</td>-->
				<td>@if($p->image)
						<img src="{{asset('storage/'.$p->image)}}" width="50px" height="50px" />
					@else
						<b>Image</b> : N/A
					@endif
					<br>
					<b>Code</b> : {{$p->product_code}}<br>
					<b>Name</b> : {{$p->Product_name}}
				</td>
				<!--
				<td>{{$p->product_code}}</td>
				<td>{{$p->Product_name}}</td>
				-->
				<td>
					@foreach($p->categories as $category)
						{{$category->name}}
					@endforeach
					
				</td>
				@if($stock_status->stock_status == 'ON')
					<td>
						{{$p->stock}}
					</td>
					<td>
						@php
							$totalOrder = App\Http\Controllers\CustomerKeranjangController::stockInfo($p->id);//total order
							$orderFinish = App\Http\Controllers\CustomerKeranjangController::TotalQtyFinish($p->id);//finish order
						@endphp
						{{($p->stock+$orderFinish)-$totalOrder}}
					</td>
					<td>
						{{$p->low_stock_treshold}}
					</td>
				@endif
				<td>
					@if($p->discount > 0)
					<del>{{number_format($p->price)}}</del><br>
					{{number_format($p->price_promo)}}
					@else
					{{number_format($p->price)}}
					@endif
				</td>
				<td>
					@if($p->status=="DRAFT")
						<span class="badge bg-dark text-white">{{$p->status}}</span>
					@elseif($p->status=="INACTIVE")
						<span class="badge bg-red">{{$p->status}}</span>
					@else
						<span class="badge bg-green">{{$p->status}}</span>	
					@endif

					@if($p->top_product==1)
					<span class="badge bg-purple text-white">Top Product</span>
					@else
					@endif

					@if($p->discount > 0)
					<span class="badge bg-orange text-white">{{$p->discount}}% OFF</span>
					@else
					@endif
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
					<!--
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$p->id}}"><i class="material-icons">delete</i></button>&nbsp;
					<button type="button" class="btn bg-grey waves-effect" data-toggle="modal" data-target="#restoreModal{{$p->id}}">Restore</button>
					-->
					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$p->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Product</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete permanently this product ..? 
		                        </div>
		                        <div class="modal-footer">
		                        	<form action="{{route('products.delete-permanent',[$vendor,$p->id])}}" method="POST">
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
									<h4 class="modal-title" id="restoreModalLabel">Restore Product</h4>
								</div>
								<div class="modal-body">
								Restore this product ..? 
								</div>
								<div class="modal-footer">
									
										<a href="{{route('products.restore', [$vendor,$p->id])}}" class="btn bg-deep-orange">Restore</a>
										<button type="button" class="btn bg-deep-orange" data-dismiss="modal">Close</button>
									
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		$("#check_onoff_stock").change(function() {
		if(this.checked) {
			var status = 'ON';
			$.ajax({
                url: '{{URL::to('/products/change_status_stock')}}',
                type: 'get',
                data: {
                    'status' : status,
                },
                success: function(){
                    Swal.fire({
						//title: 'Apakah anda yakin ?',
						text: "All Product Stock is ON",
						type: 'success',
						showCancelButton: false,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ok',
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						},
						hideClass: {
							popup: 'animate__animated animate__fadeOutUp'
						}
					}).then(function(){ 
							location.reload();
						})
                }
            });
		}
	else
		{
			var status = 'OFF';
			$.ajax({
                url: '{{URL::to('/products/change_status_stock')}}',
                type: 'get',
                data: {
                    'status' : status,
                },
                success: function(){
                    Swal.fire({
						//title: 'Apakah anda yakin ?',
						text: "All Product Stock is OFF",
						type: 'success',
						showCancelButton: false,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ok',
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						},
						hideClass: {
							popup: 'animate__animated animate__fadeOutUp'
						}
					}).then(function(){ 
							location.reload();
						})
                }
            });
		
		}
	});
	</script>
@endsection