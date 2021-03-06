@extends('layouts.master')
@section('title') Details Customer @endsection
@section('content')
     
    <ul>
        <li>
            <label class="form-label">Customer Code / Search key</label>
        </li>
        <small class="text-muted">{{$customer->store_code ? "$customer->store_code" : 'No Code'}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Name</label>
        </li>
        <small class="text-muted">{{$customer->store_name ? "$customer->store_name" : '-'}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Email</label>
        </li>
        <small class="text-muted">{{$customer->email ? "$customer->email" : 'No Email'}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">City</label>
        </li>
        <small class="text-muted">{{$customer->city_id ? $customer->cities->city_name : '-'}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Address</label>
        </li>
        <small class="text-muted">{{$customer->address ? "$customer->address" : 'No Address'}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Coordinate</label>
        </li>
        <small class="text-muted">{{$customer->lat ? $customer->lat.', '.$customer->lng : '-'}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Phone</label>
        </li>
        <small><i class="fas fa-chevron-right text-danger"></i><b> Whatsapp :</b> {{$customer->phone ? "$customer->phone" : '-'}}</small><br>
        <small><i class="fas fa-chevron-right text-danger"></i><b> Owner :</b> {{$customer->phone_owner ? "$customer->phone_owner" : '-'}}</small><br>
        <small><i class="fas fa-chevron-right text-danger"></i><b> Office :</b> {{$customer->phone_store ? "$customer->phone_store" : '-'}}</small><br>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Contact Person</label>
        </li>
        <small class="text-muted">{{$customer->name ? "$customer->name" : '-'}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Customer Type</label>
        </li>
        <small class="text-muted">{{$customer->cust_type ? $customer->type_cust->name : '-'}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Term Of Payment</label>
        </li>
        @if($customer->payment_term == 'Cash')
            <small class="text-muted">{{$customer->payment_term ? "$customer->payment_term" : '-'}}</small>
        @else
        <small class="text-muted">
            TOP&nbsp;{{$customer->payment_term ? "$customer->payment_term" : '-'}}
        </small>
        @endif
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Pareto Code</label>
        </li>
        <small class="text-muted">{{$customer->pareto_id ? $customer->pareto->pareto_code : '-'}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Target Store</label>
        </li>
        <small class="text-muted">{{$customer->ptarget_store ? $customer->target_store : '-'}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Sales Representative</label>
        </li>
        @if($customer->user_id > 0)
        <small class="text-muted">{{$customer->users->name}}</small>
        @else
        <small class="text-muted">-</small>
        @endif
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Status</label>
        </li>
        <small class="text-muted">{{$customer->status}}</small>
    </ul>
    <hr style="margin-top:0; margin-bottom:10px;">
    <ul>
        <li>
            <label class="form-label">Registered Point</label>
        </li>
        <small class="text-muted">{{$customer->reg_point == 'Y' ? 'Registerd' : 'Not Registered'}}</small>
    </ul>

@endsection

