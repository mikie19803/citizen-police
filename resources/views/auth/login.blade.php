@extends('layouts.auth')
@section('title')
    Login
@stop
@section('extra-styles')
    <link rel="stylesheet" href="{{asset('js\sweetalert2\dist\sweetalert2.css')}}">

@stop
@section('content')
    {{--{{dd($errors)}}--}}
    {{--<div class="login-container">--}}
    <div class="login-header login-caret">
        <div class="login-content"><a href="{{url('/')}}" class="logo"> <img class=""
                                                                             src="{{url(asset('images/logo2.jpeg'))}}"
                                                                             style="width: 250px;height: 200px" alt=""/>
            </a>
            <p class="description">Dear user, kindly sign in to access your account</p>
            <div class="login-progressbar-indicator"><h3>43%</h3> <span>logging in...</span></div>
        </div>
    </div>
    <div class="login-progressbar">
        <div></div>
    </div>
    <div class="login-form" style=" background-image: url('/images/group.jpeg');
  background-repeat : no-repeat;
  background-size:100% 100%">
        <div class="login-content" style="background-color: #373E4A;">
            <div class="form-login-error">
            </div>
            <p style="color:white"> You can also
                <a class="btn btn-blue" style="color:white" href="{{url('/report/create')}}">
                    make a report
                </a>
                without signing in.
            </p><!-- progress bar indicator -->
            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}" id="form_login">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12 pull-right" style="margin-right: 7%">
                        <div class="radio radio-replace">
                            <label id="email"> <input type="radio" class="color-gold" value="email"
                                                      name="login-type" checked>
                                Sign in with Email</label>
                        </div>
                    </div>
                    <div class="col-md-12 pull-right">
                        <div class="radio radio-replace">

                            <label id="phone"><input type="radio" value="phone" class="color-primary"
                                                     name="login-type"
                                                     @if ($errors->has('phone'))
                                                     checked
                                        @endif>
                                Sign in with Phone number</label>

                        </div>
                    </div>

                </div>

                <br/>
                @if ($errors->has('phone'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                @endif
                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif

                <br/>
                <div class="form-group log-type" id="phone-div" style="display:none">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="entypo-phone"></i></div>
                        <input type="text" class="form-control" name="phone" id="phone"
                               placeholder="Phone Number" data-mask="phone" autocomplete="off" required

                        />

                    </div>
                </div>
                <div class="form-group log-type" id="email-div">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="entypo-mail"></i></div>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email"
                               value="{{ old('email') }}"
                               autocomplete="off"/>
                    </div>
                </div>


                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="entypo-key"></i></div>
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="Password"
                               autocomplete="off"/>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 ">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                Remember Me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-login"><i class="entypo-login"></i>
                        Log In
                    </button>
                </div>
            </form>
            <div class="login-bottom-links">
                <a href="{{route('password.request')}}" class="link">
                    Forgot your password?
                </a>
                <br/>
                <a href="{{route('register')}}" class="link">
                    Register
                </a>
                <br/>
                <a href="#">ToS</a> - <a href="#">Privacy Policy</a>
            </div>

        </div>
    </div>
    </div>
@stop
@section('extra-scripts')
    <script src="{{asset('js/sweetalert2/dist/sweetalert2.js')}}" id=" "></script>

    <script src="{{asset('assets/js/jquery.validate.min.js')}}" id="script-resource-8"></script>
    <script src="{{asset('assets/js/neon-login.js')}}" id="script-resource-9"></script>
    <script>
        $("input[type='radio']").click(function (e) {
            type = $(this).val();
            if (type == 'email') {
                $('.log-type').css('display', 'none');
                $('#email-div').css('display', 'block')
            }
            else if (type == 'phone') {
                $('.log-type').css('display', 'none');
                $('#phone-div').css('display', 'block')
            }
        })
    </script>
    @include('notifications.sweetalert')

@stop