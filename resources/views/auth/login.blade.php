@extends('layouts.layout')

@section('title')
    Homestay
@endsection

@section('content')
    <header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url({{asset('images/img_bg_11.jpg')}})" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="gtco-container" style="margin-top: 10em;">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h3 class="text-center cursive-font" style="color: #FFFFFF; font-size: 40px;">Login</h3>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('auth/login') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-4 control-label white">E-Mail Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control white" name="email" value="{{ old('email') }}">

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-4 control-label white">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control white" name="password">

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="remember"> Remember Me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-sign-in"></i> Login
                                            </button>

                                            <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                        </div>
                                    </div>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

@endsection
@section('scripts')
@stop
