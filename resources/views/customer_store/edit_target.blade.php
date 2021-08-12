@extends('layouts.master')

    @section('title') Edit Customer Target @endsection
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
        <form id="form_validation" class="form_spv" method="POST" enctype="multipart/form-data" action="{{route('customers.update_target',[$vendor])}}">
            @csrf
            <input type="hidden" value="{{$target->id}}" name="target_id">
            <h2 class="card-inside-title">Period Of Time</h2>
            <div class="form-group">
                <div class="form-line" >
                    <input type="text" name="period" class="form-control" 
                     placeholder="Please choose a date..." autocomplete="off" required readonly
                     value="{{date('Y-m', strtotime($target->period))}}">
                </div>
            </div>
            
            <div class="form-group">
                <div class="form-line">
                    <input type="text" name="customer" class="date-picker form-control" 
                     placeholder="Please choose a date..." autocomplete="off" required readonly
                     value="{{$target->customers->store_name}}">
                </div>
            </div>
           
            
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="number" class="form-control" name="target_value" value="{{$target->target_values}}" 
                        autocomplete="off" required>
                    <label class="form-label">Target Value (IDR)</label>
                </div>
            </div>

            <button id="btnSubmit" class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
        </form>
        <!-- #END#  -->		

    @endsection
    
