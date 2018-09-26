@extends('layouts.citizen')
@section('title')
    Activate your account
@stop
@section('extra-styles')

@stop
@section('content')
    <div class="row" style="margin-top:30px">
        <div class="panel panel-primary col-md-offset-1 col-md-10" >
            <div class="panel-heading">
                <div class="panel-title">
                    Your account has been created. Kindly enter the code sent to this number here to activate your
                    account.
                </div>
            </div>
            <div class="panel-body">
                <form action="{{url('confirm/code')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="control-label col-md-1">
                            Code:
                        </label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="activation_code">
                            @if($errors->has('code'))
                                    <span class="help-block error">
                                           <strong>{{$errors->first('code')}}</strong>
                                    </span>
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-black" type="submit">Activate Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('extra-scripts')

@stop