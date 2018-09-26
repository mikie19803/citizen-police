@extends('layouts.auth')
@section('title')
    Register
@stop
@section('extra-styles')

@stop
@section('content')
    {{--    {{dd($errors)}}--}}
    <div class="login-container">
        <div class="login-header login-caret">
            <div class="login-content"><a href="{{url('/')}}" class="logo"> <img class=""
                                                                                 src="{{url(asset('images/logo2.jpeg'))}}"  style="width: 250px;height: 200px" alt=""/> </a>
                <p class="description">Create an account, it's free and takes few moments only!</p>
             </div>

        </div>
        <div class="login-progressbar">
            <div></div>
        </div>
        <div class="login-form" style=" background-image: url('/images/group.jpeg');
  background-repeat : no-repeat;
  background-size:100% 100%">
            <div class="login-content">
                <form method="post" role="form" id="form_register" action="{{ url('/register') }}">
                    {{csrf_field()}}

                    <div class="form-register-success"><i class="entypo-check"></i>
                        <h3>You have been successfully registered.</h3>
                        <p>We have emailed you the confirmation link for your account.</p>
                    </div>
                    <div class="form-steps">
                        <div class="step current" id="step-1">
                            <div class="row">
                                {{--<input type="hidden" value="email" name="login-type">--}}

                                <div class="col-md-12 pull-right" style="margin-right: 7%">
                                    <div class="radio radio-replace">
                                        <label id="email"> <input type="radio" class="color-gold" value="email"
                                                                  name="login-type" checked>
                                            Create account with Email</label>
                                    </div>
                                </div>
                                <div class="col-md-12 pull-right">
                                    <div class="radio radio-replace">

                                        <label id="phone"><input type="radio" value="phone" class="color-primary"
                                                                 name="login-type">
                                            Create account with Phone number</label>

                                    </div>
                                </div>
                            </div>
                            <br/>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="entypo-user"></i></div>
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="Full Name"
                                           autocomplete="off"/></div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="form-group log-type" id="phone-div" style="display:none">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="entypo-phone"></i></div>
                                    <input type="text" class="form-control phone" name="phone" id="phone"
                                           placeholder="Phone Number" autocomplete="off" required/>
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group log-type" id="email-div">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="entypo-mail"></i></div>
                                    <input type="text" class="form-control" name="email" id="email" data-mask="email"
                                           placeholder="E-mail" autocomplete="off" required/>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="entypo-lock"></i></div>
                                    <input type="password" class="form-control" name="password" id="password"
                                           placeholder="Password" autocomplete="off"/>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="entypo-lock"></i></div>
                                    <input type="password" class="form-control" name="password_confirmation"
                                           id="password-confirmation"
                                           placeholder="Confirm Password" autocomplete="off"/></div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block btn-login"><i
                                            class="entypo-right-open-mini"></i>
                                    Complete Registration
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
                <div class="login-bottom-links"><a href="{{url('/login')}}" class="link"> <i class="entypo-lock"></i>
                        Return to Login Page
                    </a> <br/> <a href="#">ToS</a> - <a href="#">Privacy Policy</a></div>
            </div>
        </div>
    </div>

@stop
@section('extra-scripts')

    <script src="{{asset('assets/js/jquery.validate.min.js')}}" id="script-resource-8"></script>
    <script src="{{asset('assets/js/neon-register.js')}}" id="script-resource-9"></script>

    <script src="{{asset('js\jquery.alphanumeric-master\jquery.alphanumeric-master\jquery.alphanumeric.js')}}"></script>

    <script>
        $('.phone').numeric({
            allow: "+ -()"
        });
    </script>
    <script>
        $("input[type='radio']").click(function (e) {
            type = $(this).val();
            if (type == 'email') {
                $('.log-type').hide();
                $('#email-div').show();
            }
            else if (type == 'phone') {
                $('.log-type').hide();
                $('#phone-div').show();
            }
        })
    </script>
@stop