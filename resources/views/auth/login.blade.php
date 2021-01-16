@extends('layouts.login')

@section('content')

    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
        <div class="auth-box bg-dark border-top border-secondary">
            <div id="loginform">

                <div class="text-center">
                    <span class="db"><img src="{{asset('assets/images/vnplogo.jpg')}}" alt="logo" width="150px;" /></span>
                </div>
                <div class="text-center">
                    <span class="db" style="color: #fff !important;"><h3>Login</h3></span>
                </div>

                <!-- Form -->
                <form class="form-horizontal m-t-20" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="row p-b-30">
                        <div class="col-12">
                            @if ($errors->has('email'))
                                <span class="help-block text-center" style="color: #ff3162 !important;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                            <div class="input-group mb-3 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" name="email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" required value="{{ old('email') }}">

                            </div>

                            <div class="input-group mb-3 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                                </div>
                                <input type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row border-top border-secondary">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="p-t-20">
                                    <button class="btn btn-info" type="button"><i class="fa fa-lock m-r-5"></i> Lost password?</button>
                                    <button class="btn btn-success float-right" type="submit">Login</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
