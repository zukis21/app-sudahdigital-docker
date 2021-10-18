@extends('layouts.master')
@section('title') Order List @endsection
@section('content')
@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif

<form action="{{route('products.index',[$vendor])}}">
	<div class="row">
		<div class="col-md-8">
			<ul class="nav nav-tabs tab-col-pink pull-left" >
				<li role="presentation" class="{{Request::get('status') == NULL && Request::path() == $vendor.'/orders' ? 'active' : ''}}">
					<a href="{{route('orders.index',[$vendor])}}" aria-expanded="true" >All</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'submit' ?'active' : '' }}">
					<a href="{{route('orders.index', [$vendor,'status' =>'submit'])}}" >SUBMIT</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'process' ?'active' : '' }}">
					<a href="{{route('orders.index', [$vendor,'status' =>'process'])}}">PROCESS</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'finish' ?'active' : '' }}">
					<a href="{{route('orders.index', [$vendor,'status' =>'finish'])}}">FINISH</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'cancel' ?'active' : '' }}">
					<a href="{{route('orders.index', [$vendor,'status' =>'cancel'])}}">CANCEL</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'no-order' ?'active' : '' }}">
					<a href="{{route('orders.index', [$vendor,'status' =>'no-order'])}}">NO-ORDER</a>
				</li>
			</ul>
		</div>
		<div class="col-md-4">
			<a href="{{route('orders.export_mapping',[$vendor]) }}" 
				class="btn btn-success pull-right {{\Auth::user()->roles == 'SUPERVISOR' ? 'disabled' : ''}}">
				<i class="fas fa-file-excel fa-0x "></i> Export
			</a>
		</div>
	</div>
</form>	
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover order-table">
		<thead>
			
			<tr>
				<th>#Order</th>
				<th>Status</th>
				<th >Customer</th>
				<!--<th width="15%">Order Product</th>-->
				<th>Total quantity</th>
				<th>Order date</th>
				<th>Total price</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach($orders as $order)
			
			<tr>
				<td>{{$order->invoice_number}}</td>
				<td>
					@if($order->status == "SUBMIT")
					<span class="badge bg-orange text-light">{{$order->status}}</span>
					@elseif($order->status == "PROCESS")
					<span class="badge bg-blue text-light">{{$order->status}}</span>
					@elseif($order->status == "FINISH")
					<span class="badge bg-green text-light">{{$order->status}}</span>
					@elseif($order->status == "CANCEL")
					<span class="badge bg-black text-light">{{$order->status}}</span>
					@elseif($order->status == "NO-ORDER")
					<span class="badge bg-red text-light">{{$order->status}}</span>
					@endif
				</td>
				<td>
					
					@if(\Auth::user()->roles == 'SUPERVISOR')
						@php
							$odr = \App\Order::with('products')->with('customers')
								->where('id',$order->id)->first();
						@endphp
						@if($odr->customers->status == 'NEW')<span class="badge bg-pink">New Customer</span><br>@endif
						<small><b>Name :</b> {{$odr->customers->store_name}}</small><br>
						<small><b>Sales Rep :</b> {{$odr->users['name']}} <span class="badge {{$odr->user_loc == 'On Location' ? 'bg-green' : 'bg-black'}}">{{$odr->user_loc}}</span></small><br>
						<small><b>Payment Term :</b> 
							{{$odr->payment_method}}
						</small>	
					@else
						@if($order->customers->status == 'NEW' && $order->status != 'NO-ORDER')
							<a href="{{route('orders.addnew_customer',[$vendor,Crypt::encrypt($order->customers->id),$order->payment_method])}}"><span class="badge bg-pink">New Customer</span></a><br>
						@else
							<a href="{{route('orders.addnew_customer',[$vendor,Crypt::encrypt($order->customers->id)])}}"><span class="badge bg-pink">New Customer</span></a><br>
						@endif
						
						<small><b>Name :</b> {{$order->customers->store_name}}</small><br>
						<!--<small><b>Email :</b> {{$order->customers->email}}</small><br>
						<small><b>Addr :</b> {{$order->customers->address}}</small><br>
						<small><b>Phone :</b> {{$order->customers->phone}}</small><br>-->
						<small><b>Sales Rep :</b> {{$order->users['name']}} <span class="badge {{$order->user_loc == 'On Location' ? 'bg-green' : 'bg-black'}}">{{$order->user_loc}}</span></small><br>
						<small><b>Payment Term :</b> 
							{{$order->payment_method}}
						</small>
					@endif
				</td>
				<!--
				<td align="left">
					<ul style="margin-left: -25px;">
						foreach(/*$order->products as $p)
						<li><small>$p->description <b>(/*$p->pivot->quantity*/)</b></small></li>
						endforeach
					</ul>
				</td>
				-->
				<td>
					{{\Auth::user()->roles == 'SUPERVISOR' ? $odr->totalQuantity : $order->totalQuantity}} 
					{{$order->status == 'NO-ORDER' ? '' : 'DUS'}}
				</td>
				<td>{{$order->created_at}}</td>
				<td>{{number_format($order->total_price)}}</td>
				
				<td>
					<a class="btn btn-info btn-xs btn-block" href="{{route('orders.detail',[$vendor,Crypt::encrypt($order->id)])}}">Details</a>&nbsp;
					@can('isSuperadmin')
						<!--<a style="margin-top:0;" class="btn btn-success btn-xs btn-block" href="route('order_edit',[$vendor,$order->id])">Edit</a>&nbsp;-->
					@endcan
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
			"order": [[ 4, "desc" ]]
		});
	});
</script>
@endsection
