@extends('layouts.citizen')
@section('title')
    Add User
@stop
@section('extra-styles')

@stop
@section('content')

    <h2>Add User</h2> <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        All fields with the asterisk (<span class="asterisk">*</span>) are required
                    </div>
                </div>
                <div class="panel-body">

                    {!! Form::open(['url'=>'user','class'=>'form-horizontal','role'=>'form','files'=>'true']) !!}
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Name <span class="asterisk">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="name" value=""
                                   placeholder="Please enter the name of the user" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Email <span
                                    class="asterisk">*</span></label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" name="email" value=""
                                   placeholder="Please enter the email of the user" required>
                            @if($errors->has('email'))
                                <span class="help-block error">
                                           <strong>{{$errors->first('email')}}</strong>
                                    </span>
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Password <span
                                    class="asterisk">*</span></label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" name="password" value=""
                                   placeholder="Please enter the password of the user" required>
                            @if($errors->has('password'))
                                <span class="help-block error">
                                           <strong>{{$errors->first('password')}}</strong>
                                    </span>
                            @endif

                        </div>
                    </div>
                         <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Role <span
                                        class="asterisk">*</span></label>
                            <div class="col-sm-5">
                                {!!Form::select('role',[
                                'admin'=>'Administrator',
                                'officer'=>'Police Officer'
                                ],null,['class'=>'form-control','required'=>'required','placeholder'=>'Please select a role'])  !!}
                            </div>
                        </div>



                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-black btn-block" data-loading-text="Saving User">Save
                            </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
@section('extra-scripts')

@stop