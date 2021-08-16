@extends('layouts.master')


	@section('title') Customer Target List @endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif

	<div class="row">
		<div class="col-md-12">
			<a href="{{route('customers.create_target',[$vendor])}}" class="btn bg-green ">Create Target</a>&nbsp;
			
		</div>
	</div>
		
	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<!--<th>No</th>-->
					<th>Total Customers</th>
					<!--<th>Cat</th>-->
					<th>Total Target Values (IDR)</th>
					<th>Period</th>
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
						{{$u->total}}
					</td>
					<td>
						{{number_format($u->total_target)}}
					</td>
					<td>
						{{date('M-Y', strtotime($u->period))}}
					</td>
					<td>
						<a class="btn btn-info btn-xs" href="{{route('customers.edit_target',[$vendor,Crypt::encrypt($u->period)])}}"><i class="material-icons">list</i></a>&nbsp;
						
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		
		
	</div>
@endsection
@section('footer-scripts')
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        
        var dp=$("#datepicker").datepicker( {
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months",
            onSelect: function(dateText, inst) {
                    $("input[name='param_customer']").val(dateText);
                }
        });

        dp.on('changeMonth', function (e) {
            //var dateObject = $("#datepicker").val();    
            //do something here
            $(".datepicker").hide();
        });

        $('#datepicker').change(function() {
  			var date = $(this).val();
			$.ajax({
				url: '{{URL::to('/ajax/edit_exist_date/search')}}',
				type: 'get',
				data: {
					'date' : date
				},
				success: function(response){
					if (response == 'taken') {
					//$('.email_').addClass("focused error");
					$('.err_exist').addClass("small").addClass('merah').text('This Period already exists in target ...');
					$('#btnSubmit').prop('disabled', true);
					}else if (response == 'not_taken') {
					$('.err_exist').addClass("text-primary").removeClass('merah').text('');
					$('#btnSubmit').prop('disabled', false);
					}
					/*
					else if(response == 'not_taken' && email==""){
						//$('#email_').siblings("label").text('');
						$('.err_exist').text('');
					}*/
				}
			});
		}).change();
    </script> 
    @endsection