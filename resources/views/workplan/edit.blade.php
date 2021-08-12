@extends('layouts.master')

    @section('title') Edit Holiday Plans {{date('M-Y', strtotime($plan->work_period))}}@endsection
    @section('content')
    
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-success">
                {{session('error')}}
            </div>
        @endif
        <!-- Form Create -->
        <form id="form_validation" class="form_spv" method="POST" enctype="multipart/form-data" action="{{route('workplan.update',[$vendor,$plan->id])}}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="param_date" name="param_date" value="{{$plan->work_period}}">
            <div class="form-group"  id="selectday">
                <h2 class="card-inside-title">Holiday Date</h2>
                
                    <div class="form-line" id="here">
                        <input type="text" id="holidays" name="holidays" 
                        class="date-picker_day form-control" 
                        value="{{implode(',',$day_off)}}"
                        placeholder="Please choose a date..." autocomplete="off" required readonly>
                    </div>
                
            </div>
            <button id="btnSubmit" class="btn btn-primary waves-effect" type="submit">UPDATE</button>
            
        </form>
        <!-- #END#  -->		

    @endsection
    @section('footer-scripts')
        <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
        
        <script type="text/javascript">
            var year = {!! $year !!};
            var date = {!! $month !!};
            //console.log(date);
            var day = new Date(year,date,0).getDate();
            var startDate = new Date(year,date-1,1);
            var endDate = new Date(year,date-1,day);
            
            $('.date-picker_day').datepicker({
                multidate: true,
                format: 'yyyy-mm-dd',
                startDate: startDate,
                endDate: endDate
            });
        </script> 
    @endsection
