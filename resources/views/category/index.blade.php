@extends('layouts.master')
@section('title') Categories List @endsection
@section('content')

@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif

<form action="{{route('categories.index',[$vendor])}}">
	<div class="row">
		<!--
		<div class="col-md-4">
			<div class="input-group input-group-sm">
        		<div class="form-line">
				<input type="text" class="form-control" name="name" value="{{Request::get('name')}}"  placeholder="Filter berdasarkan nama" autocomplete="off" />
	    		</div>
				<span class="input-group-addon">
					<input type="submit" class="btn bg-blue" value="Filter">
				</span>
			</div>
		</div>
		
		<div class="col-md-12">
			<ul class="nav nav-tabs tab-col-pink pull-left" >
				<li role="presentation" class="active">
					<a href="{{route('categories.index',[$vendor])}}" aria-expanded="true" >All</a>
				</li>
				<li role="presentation" class="">
					<a href="{{route('categories.trash',[$vendor])}}" >TRASH</a>
				</li>
			</ul>
		</div>
		-->		
		<div class="col-md-12">
			<a href="{{route('categories.export',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-0x "></i> Export</a>&nbsp;
			<a href="{{route('categories.create',[$vendor])}}" class="btn bg-cyan">Create Category</a>
		</div>
	</div>
</form>
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>No</th>
				<th>Cat ID</th>
				<th>Name</th>
				<th>Parent Category</th>
				<th>Image</th>
				<th width="">Actions</th>
			</tr>
		</thead>
		<tbody>
			@if(isset($categories))
			<?php $_SESSION['i'] = 0; ?>
				@foreach($categories as $c)
					<?php $_SESSION['i']=$_SESSION['i']+1; ?>
					<tr>
						<?php $dash=''; ?>
						<td>{{$_SESSION['i']}}</td>
						<td>{{$c->id}}</td>
						<td>{{$c->name}}</td>
						<td>
							@if($c->parent_id)
								{{$c->subcategory->name}}
							@else
								None
							@endif
						</td>
						<td>@if($c->image_category)
							<img src="{{asset('storage/'.$c->image_category)}}" width="50px" height="50px" />
							@else
							N/A
							@endif
						</td>
						<td>
							<a class="btn btn-info btn-xs" href="{{route('categories.edit',[$vendor,Crypt::encrypt($c->id)])}}"><i class="material-icons">edit</i></a>&nbsp;
							<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$c->id}}"><i class="material-icons">delete</i></button>&nbsp;
							<!--
							<button type="button" class="btn bg-grey waves-effect" data-toggle="modal" data-target="#detailModal{{$c->id}}">Detail</button>
							-->
							<!-- Modal Delete -->
							<div class="modal fade" id="deleteModal{{$c->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-sm" role="document">
									<div class="modal-content modal-col-red">
										<div class="modal-header">
											<h4 class="modal-title" id="deleteModalLabel">Delete Category Permanent</h4>
										</div>
										<div class="modal-body">
											Delete permanent this category ..? 
										</div>
										<div class="modal-footer">
											<form action="{{route('categories.delete-permanent',[$vendor,$c->id])}}" method="POST">
												@csrf
												<input type="hidden" name="_method" value="DELETE">
												<button type="submit" class="btn btn-link waves-effect">Delete</button>
												<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
											</form>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Modal Detail 
							<div class="modal fade" id="detailModal{{$c->id}}" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content modal-col-indigo">
										<div class="modal-header">
											<h4 class="modal-title" id="detailModalLabel">Detail Category</h4>
										</div>
										<div class="modal-body">
										<b>Category Name:</b>
										<br/>
										{{$c->name}}
										<br/>
										<br/>
										@if($c->image_category)
										<img src="{{asset('storage/'.$c->image_category)}}" width="128px"/>
										@else
										No Image
										@endif
										
										<br/>
										<br/>
										<b>Category Slug:</b>
										<br/>
										{{$c->slug}}
										
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
										</div>
										
									</div>
								</div>
							</div>
							-->
						</td>
					</tr>
					@if(count($c->subcategory))
						@include('category.sub-category-list',['subcategories' => $c->subcategory])
					@endif
				@endforeach
				<?php unset($_SESSION['i']); ?>
			@endif
		</tbody>
	</table>
	
	
</div>
@endsection