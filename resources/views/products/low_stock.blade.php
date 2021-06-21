@extends('layouts.master')
@section('title') Product List @endsection
@section('content')
@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
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
		<div class="col-md-6">
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
				<li role="presentation" class="active">
					<a href="{{route('products.low_stock',[$vendor])}}">LOW STOCK</a>
				</li>
				<li role="presentation">
					<a href="{{route('products.trash',[$vendor])}}">TRASH</a>
				</li>
			</ul>
		</div>
		<div class="col-md-6">
			&nbsp;
		</div>
		<div class="col-md-12">
			<div class="demo-switch">
				<a href="{{route('products.import_products',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-0x "></i> Import</a>&nbsp;
				<a href="{{route('products.export_lowstock',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-0x "></i> Export</a>&nbsp;
				<a href="{{route('products.edit_stock',[$vendor])}}" class="btn bg-cyan" style="padding:8px;">Update Stock</a> &nbsp;
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
				<th>No</th>
				<th>Product Image</th>
				<th>Product Name</th>
				<th>Descritption</th>
				<th>Category</th>
				<th>Stock</th>
				<th>Low Stock Treshold</th>
				<th>Price</th>
				<th>Status</th>
				<th width="5%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($products as $p)
			<?php $no++;?>
			<tr>
				<td>{{$no}}</td>
				<td>@if($p->image)
					<img src="{{asset('storage/'.$p->image)}}" width="50px" height="50px" />
					@else
					N/A
					@endif
				</td>
				<td>{{$p->Product_name}}</td>
				<td>{{$p->description}}</td>
				<td>
					@foreach($p->categories as $category)
						{{$category->name}}
					@endforeach
					
				</td>
				<td>
					{{$p->stock}}
				</td>
				<td>
					{{$p->low_stock_treshold}}
				</td>
				<td>
					{{$p->price}}
				</td>
				<td>
					@if($p->status=="DRAFT")
					<span class="badge bg-dark text-white">{{$p->status}}</span>
						@else
					<span class="badge bg-green">{{$p->status}}</span>
					@endif
				</td>
				<td>
					<a class="btn btn-info btn-xs" href="{{route('products.edit',[$vendor, Crypt::encrypt($p->id)])}}"><i class="material-icons">edit</i></a>
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