@extends('layouts.citizen')
@section('title')
    Reset your password
@stop
@section('extra-styles')

@stop
@section('content')
    <div class="row" style="margin-top:30px">
        <div class="panel panel-primary col-md-offset-1 col-md-8" >
            <div class="panel-heading">
                <div class="panel-title">
                     Kindly enter the code sent to this number here reset your password.
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-offset-1">
                    <div>
                        @if($errors->has('user'))
                            <span class="help-block error">
                                           <strong>{{$errors->first('user')}}</strong>
                                    </span>
                        @endif
                    </div>
                    <form action="{{url('password/resetPassword')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2">
                                    Code:
                                </label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="code"
                                           placeholder="Reset Code sent to your phone" required>
                                    @if($errors->has('code'))
                                        <span class="help-block error">
                                           <strong>{{$errors->first('code')}}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2">
                                    Code:
                                </label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control phone" name="phone" placeholder="Phone number" required>
                                    @if($errors->has('phone'))
                                        <span class="help-block error">
                                           <strong>{{$errors->first('phone')}}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2">
                                    Password:
                                </label>
                                <div class="col-md-5">
                                    <input type="password" class="form-control" name="password" required>
                                    @if($errors->has('password'))
                                        <span class="help-block error">
                                           <strong>{{$errors->first('password')}}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2">
                                    Password Confirmation:
                                </label>
                                <div class="col-md-5">
                                    <input type="password" class="form-control" name="password_confirmation" required>

                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <button class="btn btn-black" type="submit">Reset Password</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@stop
@section('extra-scripts')
    <script src="{{asset('js\jquery.alphanumeric-master\jquery.alphanumeric-master\jquery.alphanumeric.js')}}"></script>

    <script>
        $('.phone').numeric({
            allow: "+ -()"
        });
    </script>
@stop