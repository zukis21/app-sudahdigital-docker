@extends('layouts.master')
@section('title') Product List @endsection
@section('content')
@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif
<style>
	/* Scrollbar Styling 
	::-webkit-scrollbar {
		width: 5px;
	}
	
	::-webkit-scrollbar-track {
		background-color: #ebebeb;
		-webkit-border-radius: 10px;
		border-radius: 10px;
	}

	::-webkit-scrollbar-thumb {
		-webkit-border-radius: 10px;
		border-radius: 10px;
		background: #ebebeb; 
	}
	*/
</style>
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
			<ul class="nav nav-tabs tab-col-pink pull-left" >
				<li role="presentation" class="{{Request::get('status') == NULL && Request::path() == $vendor.'/products' ? 'active' : ''}}">
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
				@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
					<li role="presentation" class="">
						<a href="{{route('products.trash',[$vendor])}}" >TRASH</a>
					</li>
				@endif
			</ul>
		</div>
		@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
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
		@elseif(Gate::check('isSpv'))
			<div class="col-md-12">
				<div class="demo-switch">
					<a href="{{route('products.export_all',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-0x "></i> Export</a>&nbsp;
				</div>
			</div>
		@endif
	</div>
</form>	
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example" style="width:100%">
		<thead>
			<tr>
				<!--<th>No</th>-->
				<!--
				<th>Product Image</th>
				<th>Product Code</th>
				<th>Product Name</th>
				-->
				<th>Product</th>
				<!--<th>Descritption</th>-->
				<th>Category</th>
				@if($stock_status && $stock_status->stock_status == 'ON')
					<th>Inv. Stock</th>
					<th>Avail. for Sale</th>
					<th>Treshold</th>
				@endif
				<th>Price</th>
				<th>Status</th>
				@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
					<th>#</th>
				@endif
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
				@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
					<td>
						<div class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
								<i class="material-icons" >apps</i>
							</a>
							<ul class="dropdown-menu pull-right">
								
								@if($p->status == 'PUBLISH')
								<li>
									<a href="javascript:void(0);" class=" waves-effect waves-block"
									data-toggle="modal" data-target="#activeModal{{$p->id}}">Deactivate</a>
								</li>
								@elseif($p->status == 'INACTIVE')
								<li>
									<a href="javascript:void(0);" class=" waves-effect waves-block"
									data-toggle="modal" data-target="#activeModal{{$p->id}}">Activate</a>
								</li>
								@endif
								<li>
									<a href="{{route('products.edit',[$vendor,Crypt::encrypt($p->id)])}}" 
									class=" waves-effect waves-block">
										Edit
									</a>
								</li>
								<li><a href="javascript:void(0);" class=" waves-effect waves-block" 
									data-toggle="modal" data-target="#deleteModal{{$p->id}}">
									Delete
									</a>
								</li>
								<li><a href="javascript:void(0);" class=" waves-effect waves-block" 
									data-toggle="modal" data-target="#detailModal{{$p->id}}">
									Detail
									</a>
								</li>
							</ul>
						</div>
						
						<!--
						<a class="btn btn-info btn-xs " href="{{route('products.edit',[$vendor,Crypt::encrypt($p->id)])}}"><i class="material-icons">edit</i></a>
						<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$p->id}}"><i class="material-icons">delete</i></button>
						<button type="button" class="btn bg-grey waves-effect btn-xs" data-toggle="modal" data-target="#detailModal{{$p->id}}" ><i class="material-icons">list</i></button>
						-->

						<!-- Modal Delete -->
						<div class="modal fade" id="deleteModal{{$p->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content modal-col-red">
									<div class="modal-header">
										<h4 class="modal-title" id="deleteModalLabel">Delete Product</h4>
									</div>
									<div class="modal-body">
									Delete this product ..? 
									</div>
									<div class="modal-footer">
										<form action="{{route('products.destroy',[$vendor,$p->id])}}" method="POST">
											@csrf
											<input type="hidden" name="_method" value="DELETE">
											@if(Request::get('status') == NULL && Request::path() == $vendor.'/products')
												<input type="hidden" name="status_page" value="">
											@elseif(Request::get('status') == 'publish')
												<input type="hidden" name="status_page" value="publish">
											@elseif(Request::get('status') == 'inactive')
												<input type="hidden" name="status_page" value="inactive">
											@elseif(Request::get('status') == 'draft')
												<input type="hidden" name="status_page" value="draft">	
											@endif
											<button type="submit" class="btn btn-link waves-effect">Delete</button>
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
										</form>
									</div>
								</div>
							</div>
						</div>

						<!-- Modal Detail -->
						<div class="modal fade" id="detailModal{{$p->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="detailModalLabel">Detail Product</h4>
									</div>
									<div class="modal-body">
										@if($p->image)
										<img src="{{asset('storage/'.$p->image)}}" width="128px"/>
										@else
										No Image
										@endif
										<br/><br/>
										<b>Product Code:</b>
										<br/>
										{{$p->product_code}}
									<br/><br/>
									<b>Product Name:</b>
									<br/>
									{{$p->Product_name}}
									<br/><br/>
									<b>Product Description:</b>
									<br/>
									{{$p->description}}
									<br/><br/>
									<b>Category:</b>
									<br/>
									@foreach($p->categories as $category)
									
											{{$category->name}}
									
										@endforeach
									<br/><br/>
									@if($stock_status->stock_status == 'ON')
										<b>Stock:</b>
										<br/>
										{{$p->stock}}
										<br/><br/>
										<b>Low Stock Treshold:</b>
										<br/>
										{{$p->low_stock_treshold}}
										<br/><br/>
									@endif
									<b>Price:</b>
									<br/>
									{{number_format($p->price)}}
									<br/><br/>
									<b>Status</b>
									<br/>
										@if($p->status=="DRAFT")
											<span class="badge bg-dark text-white">{{$p->status}}</span>
										@else
											<span class="badge bg-green text-white">{{$p->status}}</span>
										@endif
										<br/><br/>
										@if($p->top_product == 1)
											<input disabled type="checkbox" name="top_product" id="top_product" value="1"  checked >
											<label for="top_product">Top Product</label>
											<br/><br/>
									@endif
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
									</div>
									
								</div>
							</div>
						</div>

						<!-- Modal deactivate -->
						<div class="modal fade" id="activeModal{{$p->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content modal-col-{{$p->status == 'PUBLISH' ? 'orange' : 'cyan'}}">
									<div class="modal-header">
										<h4 class="modal-title">{{$p->status == 'PUBLISH' ? 'Deactivate Product' : 'Activate Product'}}</h4>
									</div>
									<div class="modal-body">
										{{$p->status == 'PUBLISH' ? 'Deactivate this product ?' : 'Activate this product ?'}}
									</div>
									<div class="modal-footer">
										<form action="{{route('products.actorderact',[$vendor,$p->id])}}" method="POST">
											@csrf
											<input type="hidden" name="_method" value="PUT">
											@if(Request::get('status') == NULL && Request::path() == $vendor.'/products')
												<input type="hidden" name="status_page" value="">
											@elseif(Request::get('status') == 'publish')
												<input type="hidden" name="status_page" value="publish">
											@elseif(Request::get('status') == 'inactive')
												<input type="hidden" name="status_page" value="inactive">
											@endif
											<input type="hidden" name="status" value="{{$p->status == 'PUBLISH' ? 'INACTIVE' : 'PUBLISH'}}">
											<button type="submit" name="save" value="{{$p->status == 'PUBLISH' ? 'DEACTIVATE' : 'ACTIVATE'}}" class="btn btn-link waves-effect">{{$p->status == 'PUBLISH' ? 'Deactivate' : 'Activate'}}</button>
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</td>
				@endif
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