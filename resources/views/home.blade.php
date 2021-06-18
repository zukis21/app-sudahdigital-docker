@extends('layouts.master')
@section('title') Home @endsection
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
        <style>
            .profile-card .profile-header {
                background-color: #3F51B5;
                padding: 42px 0;
            }
            .tab-pane ul{
                margin-left: -10px;
            }
        </style>
    @elseif(Gate::check('isOwner'))
    <style>
        .profile-card .profile-header {
            background-color: #FFC107;
            padding: 42px 0;
        }
        .tab-pane ul{
            margin-left: -10px;
        }
    </style>
    @endif
    <!--
    Hi <strong>{{ auth()->user()->name }}</strong>,
    {{ __('You are logged in as') }}
    @can('isSuperadmin')
        <span class="badge bg-green">Superadmin</span>
    @elsecan('isAdmin')
        <span class="badge bg-green">Admin</span>
    @elsecan('isSpv')
        <span class="badge bg-green">Supervisor</span>
    @endcan
    -->
    @can('isSpv')
        Hi <strong>{{ auth()->user()->name }}</strong>,
        {{ __('You are logged in as') }}
        <span class="badge bg-green">Supervisor</span>
    @endcan
    @if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-4">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <div class="profile-body">
                            <div class="image-area">
                                <img src="{{ asset('assets/image'.$client->client_image)}}" width="130" height="130" alt="image-logo" />
                            </div>
                            <div class="content-area">
                                <h3>{{$client->client_name}}</h3>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <!--<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Profile Details</a></li>-->
                                    <li role="presentation"><a href="#" aria-controls="settings" role="tab" data-toggle="tab">Profile Detail & Settings</a></li>
                                </ul>
                                <div class="tab-content">
                                    <!--
                                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                                        <ul>
                                            <li>
                                                <label class="form-label">Name</label>
                                            </li>
                                            <small class="text-muted">{{$client->client_name}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Shop/Company Name</label>
                                            </li>
                                            <small class="text-muted">{{$client->company_name ? "$client->company_name" : '-'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Email</label>
                                            </li>
                                            <small class="text-muted">{{$client->email ? "$client->email" : 'No Email'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Address</label>
                                            </li>
                                            <small class="text-muted">{{$client->client_address ? "$client->client_address" : 'No Address'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Phone</label>
                                            </li>
                                            <small><i class="fas fa-chevron-right text-danger"></i><b> Whatsapp :</b> {{$client->phone_whatsapp ? "$client->phone_whatsapp" : '-'}}</small><br>
                                            <small><i class="fas fa-chevron-right text-danger"></i><b> Office :</b> {{$client->phone ? "$client->phone" : '-'}}</small><br>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Facebook URL</label>
                                            </li>
                                            <small class="text-muted">{{$client->fb_url ? "$client->fb_url" : '-'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Instagram URL</label>
                                            </li>
                                            <small class="text-muted">{{$client->inst_url ? "$client->inst_url" : '-'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Youtube URL</label>
                                            </li>
                                            <small class="text-muted">{{$client->ytb_url ? "$client->ytb_url" : '-'}}</small>
                                        </ul>
                                        <hr style="margin-top:0; margin-bottom:10px;">
                                        <ul>
                                            <li>
                                                <label class="form-label">Twitter URL</label>
                                            </li>
                                            <small class="text-muted">{{$client->twt_url ? "$client->twt_url" : '-'}}</small>
                                        </ul>
                                    </div>
                                     -->
                                    <div role="tabpanel" class="tab-pane fade in active" id="profile_settings">
                                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{route('profile.client.update',[$vendor,$client->id])}}">
                                            @csrf
                                            <input type="hidden" name="_method" value="PUT">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-3 control-label">Name</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="name" name="client_name" placeholder="Name" value="{{$client->client_name}}" required readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="company_name" class="col-sm-3 control-label">Shop/Company Name</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="company_name" name="company_name" 
                                                        placeholder="Shop/Company Name" value="{{old('company_name') ? old('company_name') : $client->company_name}}" 
                                                        required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-3 control-label">Email</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="email" class="form-control" id="email" name="email" 
                                                        placeholder="Email" value="{{old('email') ? old('email') : $client->email}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="phone_whatsapp" class="col-sm-3 control-label">Whatsapp</label>

                                                <div class="col-sm-9">
                                                    <div class="form-line" style="padding-bottom:-1rem;">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">+62</span>
                                                            <input id="phone_whatsapp" type="text" class="form-control" placeholder="Whatsapp" 
                                                            name="phone_whatsapp" onkeypress="return isNumberKey(event)" 
                                                            value="{{old('phone_whatsapp') ? old('phone_whatsapp') : $client->phone_whatsapp}}" utocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="phone" class="col-sm-3 control-label">Office Phone</label>

                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input id="phone" value="{{old('phone') ? old('phone') : $client->phone}}" class="form-control" 
                                                        onkeypress="return isNumberKey(event)" 
                                                        type="text" name="phone" autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="client_address" class="col-sm-3 control-label">Address</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <textarea id="client_address" name="client_address" class="form-control" 
                                                            placeholder="Address" required>{{old('client_address') ? old('client_address') : $client->client_address}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="fb_url" class="col-sm-3 control-label">Facebook URL</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="url" class="form-control" id="fb_url" name="fb_url" 
                                                        placeholder="Your Facebook URL" value="{{old('fb_url') ? old('fb_url') : $client->fb_url}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inst_url" class="col-sm-3 control-label">Instagram URL</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="url" class="form-control" id="inst_url" name="inst_url" 
                                                        placeholder="Your Instagram URL" value="{{old('inst_url') ? old('inst_url') : $client->inst_url}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="ytb_url" class="col-sm-3 control-label">Youtube URL</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="url" class="form-control" id="ytb_url" name="ytb_url" 
                                                        placeholder="Your Youtube URL" value="{{old('ytb_url') ? old('ytb_url') : $client->ytb_url}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="twt_url" class="col-sm-3 control-label">Twitter URL</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="url" class="form-control" id="twt_url" name="twt_url" 
                                                        placeholder="Your Twitter URL" value="{{old('twt_url') ? old('twt_url') : $client->twt_url}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="client_image" class="col-sm-3 control-label">Image Logo</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        @if($client->client_image)
                                                        <img src="{{asset('assets/image'.$client->client_image)}}" width="120px"/>
                                                        @else
                                                        No Image Logo
                                                        @endif
                                                        <input type="file" name="client_image" class="form-control" id="client_image" autocomplete="off">
                                                        <small
                                                            class="text-muted">Leave it blank if you don't want to change your image
                                                        </small>
                                                    </div>
                                                    <label id="name-error" class="error" for="client_image">{{ $errors->first('client_image') }}</label>
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">SUBMIT</button>
                                                </div>
                                            </div>
                                            -->
                                            <div class="form-group">
                                                <div class="col-sm-offset-1 col-sm-11">
                                                    <button type="submit" class="btn btn-success">UPDATE</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(Gate::check('isOwner'))
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-sm-offset-3 col-xs-12 col-sm-6">
                    <div class="card profile-card">
                        <div class="profile-header text-center">
                            <div class="image-area">
                                <img src="{{ asset('assets/image'.$client->client_image)}}" alt="image logo" />
                            </div>
                        </div>
                        <div class="profile-body">
                            
                            <div class="content-area">
                                <h3>Wellcome</h3>
                                <h3>{{Auth::user()->name}}</h3>
                                <p>{{Auth::user()->email}}</p>
                                <p>Administrator</p>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('footer-scripts')
    <script>
        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
            return false;
            return true;
        }
    </script>
@endsection
