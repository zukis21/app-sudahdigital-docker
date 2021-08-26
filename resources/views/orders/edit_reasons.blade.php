@extends('layouts.master')
@section('title') Edit Checkout Reasons @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('reasons.update',[$vendor,$reasons_edit->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" value="{{$reasons_edit->reasons_name}}" name="reasons_name" autocomplete="off" required>
                <label class="form-label">Reasons</label>
            </div>
        </div>

        
        <button class="btn btn-primary waves-effect" type="submit">EDIT</button>&nbsp;
        <a href="{{route('reasons.index',[$vendor])}}" class="btn bg-deep-orange waves-effect" >&nbsp;CLOSE&nbsp;</a>
    </form>

    <!-- #END#  -->		

@endsection