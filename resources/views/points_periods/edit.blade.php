@extends('layouts.master')
@section('title') Edit Point Periods @endsection
@section('content')
    <style>
        .table tr { line-height: 14px; }
    </style>
    

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
	<!-- Form Create -->
    <form id="form_validation" method="POST"  action="{{route('points_periods.update',[$vendor,$PointPeriod->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line" >
                <input type="text" class="form-control" name="name"
                value="{{old('name',$PointPeriod->name)}}" autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>
        <div class="input-daterange input-group" id="">
            <div class="form-line">
                <input type="text"  name="starts_at" value="{{old('starts_at',date('Y-m-d', strtotime($PointPeriod->starts_at)))}}"
                class="start_date form-control" 
                readonly required placeholder="Date start...">
            </div>
            <span class="input-group-addon">to</span>
            <div class="form-line">
                <input type="text" name="expires_at" value="{{old('expires_at',date('Y-m-d', strtotime($PointPeriod->expires_at)))}}"
                class="expires_date form-control" 
                readonly required placeholder="Date end...">
            </div>
        </div>
        

        <button id="save" class="btn btn-success waves-effect" name="save_action" value="SAVE" type="submit">UPDATE</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $('.prd_id').select2({
        placeholder: 'Select an item',
    });
    var start_date = <?php echo json_encode($start_date); ?>;
    var end_date = <?php echo json_encode($end_date); ?>;
    if(start_date != '' && end_date != ''){
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            startDate: new Date(start_date),
            endDate: new Date(end_date),
            autoclose: true,
        });
    }else if(start_date == '' && end_date != ''){
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            //startDate: new Date(start_date),
            endDate: new Date(end_date),
            autoclose: true,
        });
    }else if(start_date != '' && end_date == ''){
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            startDate: new Date(start_date),
            //endDate: new Date(end_date),
            autoclose: true,
        });
    }else{
        $('.input-daterange').datepicker({
            autoclose: true,
        });
    }
    
</script>

@endsection