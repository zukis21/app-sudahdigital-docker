@extends('layouts.master')


	@section('title') Sales Target List @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif

	<div class="row">
		<div class="col-md-12">
			<a href="{{route('sales.create_target',[$vendor])}}" class="btn bg-cyan ">Create Target</a>
		</div>
	</div>
		
	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<!--<th>No</th>-->
					<th>Name</th>
					<th>VAT(PPN)</th>
					<th>Target Val.(IDR)</th>
					<th>Achieve. (IDR)</th>
					<th>Period</th>
					<th>Created By</th>
					<th>Updated By</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($targets as $u)
					<?php $no++;?>
					<tr>
						<!--<td>{{$no}}</td>-->
						<td>
							@if($u->users)
								{{ $u->users->name }}
							@endif
						</td>
						<td>
							
							@if ($u->ppn == 1)
								<span class="badge bg-green">Y</span>
							@else
							<span class="badge bg-red">N</span>
							@endif	
							
						</td>
						<td>
							
							{{number_format($u->target_values)}}
							
						</td>
						<td>
							
							@php
								$month= date('m', strtotime($u->period));
								$year= date('Y', strtotime($u->period));
								//dd($month);
								$order_ach = \App\Order::where('user_id',$u->user_id)
										->whereNotNull('customer_id')
										->whereMonth('created_at', '=', $month)
										->whereYear('created_at', '=', $year)
										->where('status','!=','CANCEL')->get();
										$total_ach = 0;
											foreach($order_ach as $p){
												$total_ach += $p->total_price;
											}
										//return $total_ach;
										
										if($u->ppn == 1){
											echo number_format($total_ach / 1.1);
										}
										else{
											echo number_format($total_ach);
										}
							@endphp
							<!--{{number_format($u->target_achievement)}}-->
						</td>
						<td>
							
							{{date('M-Y', strtotime($u->period))}}
							<br>
							@php
								$customer = \App\Customer::where('user_id',$u->user_id)->count();
							@endphp
							<small><b>{{$customer.' Customers'}}</b></small>
						</td>
						<td>
							
								{{$u->created_by ? $u->created_of->name : ''}}
								<br>
								{{$u->created_by ? $u->created_at : ''}}
							
						</td>
						<td>
							
								{{$u->updated_by ? $u->updated_of->name : ''}}
								<br>
								{{$u->updated_by ? $u->updated_at : ''}}
							
						</td>
						<td>
							
							<a class="btn btn-info btn-xs" href="{{route('sales.edit_target',[$vendor,Crypt::encrypt($u->id)])}}"><i class="material-icons">edit</i></a>&nbsp;
							
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
		
	</div>



@endsection