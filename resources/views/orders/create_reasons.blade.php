@extends('layouts.master')
@section('title') Create Checkout Reasons @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('reasons.store',[$vendor])}}">
    	@csrf
        <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="reasons_name" autocomplete="off" required>
                <label class="form-label">Reasons</label>
            </div>
        </div>
        
                        
        <button class="btn btn-primary waves-effect" type="submit">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection