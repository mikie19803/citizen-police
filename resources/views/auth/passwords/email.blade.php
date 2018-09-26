@extends('layouts.auth')
@section('title')

@stop
@section('extra-styles')

@stop
@section('content')
    <script type="text/javascript">
        var baseurl = '../../index.html';
    </script>

            <div class="login-container">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="login-header login-caret">
                    <div class="login-content"><a href="{{url('/')}}" class="logo">
                            <img class=""
                                 src="{{url(asset('images/logo2.jpeg'))}}"
                                 style="width: 250px;height: 200px"
                                 alt=""/> </a>

                    </div>

                </div>


                 <div class="login-form"  style=" background-image: url('/images/group.jpeg');
  background-repeat : no-repeat;
  background-size:100% 100%">
                     <div class="">

                     </div>
                     <br/>
                    <div class="login-content">
                        <div class=" ">

                            <a href="{{url('password/reset/phone')}}" class="btn btn-block btn-blue" style="color:white">Reset Through SMS</a>
                            <br/>
                            <br/>
                        </div>
                        <br/>
                         <p class="description">Enter your email, and we will send the reset link.</p>

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                            <div class="form-forgotpassword-success"><i class="entypo-check"></i>
                                <h3>Reset email has been sent.</h3>
                                <p>Please check your email, reset password link will expire in 24 hours.</p></div>
                            <div class="form-steps">
                                <div class="step current" id="step-1">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="entypo-mail"></i></div>
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Email"
                                                   data-mask="email" autocomplete="off" value="{{ old('email') }}"/>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btn-block btn-login">
                                            Send Password Reset Link
                                            <i class="entypo-right-open-mini"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="login-bottom-links"><a href="{{url('/login')}}" class="link"> <i class="entypo-lock"></i>
                                Return to Login Page
                            </a> <br/> <a href="#">ToS</a> - <a href="#">Privacy Policy</a>
                        </div>
                    </div>
                </div>
            </div>


@stop
@section('extra-scripts')
    <script src="{{asset('assets/js/jquery.validate.min.js')}}" id="script-resource-8"></script>
    <script src="{{asset('assets/js/neon-forgotpassword.js')}}" id="script-resource-9"></script>
    <script src="{{asset('assets/js/jquery.inputmask.bundle.js')}}" id="script-resource-10"></script>
@stop