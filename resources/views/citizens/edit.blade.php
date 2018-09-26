@extends('layouts.citizen')
@section('title')
    Edit Information
@stop
@section('extra-styles')

@stop
@section('content')

    <h2>Edit Information</h2> <br/>
    <div class="row">
        <div class="col-md-12">
            @if($citizen != null)
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            All fields with the asterisk (<span class="asterisk">*</span>) are required
                        </div>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['url'=>'citizen/'.$citizen->id,'class'=>'form-horizontal','role'=>'form','files'=>'true']) !!}
                        {{method_field('PATCH')}}
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">ID </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" value="{{$citizen->account_no}}"
                                       placeholder="Please enter the name of the citizen" READONLY>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Name <span
                                        class="asterisk">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" value="{{$citizen->name}}"
                                       placeholder="Please enter your name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Mobile Number <span
                                        class="asterisk">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control phone" name="phone" value="{{$citizen->phone}}"
                                       placeholder="Please enter your mobile number" required>
                                @if($errors->has('phone'))
                                    <span class="help-block error">
                                           <strong>{{$errors->first('phone')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Email </label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control" name="email" value="{{$citizen->email}}"
                                       placeholder="Please enter the email of the citizen">
                                @if($errors->has('email'))
                                    <span class="help-block error">
                                           <strong>{{$errors->first('email')}}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Voter's ID Number</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="voter_id" value="{{$citizen->voter_id}}"
                                       placeholder="Please enter your voter's ID number">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-black" data-loading-text="Updating Information">
                                    Save
                                </button>
                            </div>
                        </div>


                    </div>
                    {!! Form::close() !!}
                </div>
            @else
                <div class="alert alert-danger col-md-8 col-md-offset-2 col-sm-12">
                    <h4><i class="fa fa-times-circle-o"></i> &nbsp; No citizen found with specified ID </h4>
                </div>
            @endif
        </div>
    </div>
@stop
@section('extra-scripts')
    <script src="{{asset('js\citizen.js')}}"></script>

    <script src="{{asset('js\jquery.alphanumeric-master\jquery.alphanumeric-master\jquery.alphanumeric.js')}}"></script>

    <script>
        $('.phone').numeric({
            allow: "+ -()"
        });
    </script>

@stop