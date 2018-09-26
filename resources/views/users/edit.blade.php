@extends('layouts.citizen')
@section('title')
    Edit User
@stop
@section('extra-styles')

@stop
@section('content')

    <h2>Edit User</h2> <br/>
    <div class="row">
        <div class="col-md-12">
            @if($user != null)
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            All fields with the asterisk (<span class="asterisk">*</span>) are required
                        </div>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['url'=>'user/'.$user->id,'class'=>'form-horizontal','role'=>'form','files'=>'true']) !!}
                        {{method_field('PATCH')}}
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">ID  </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" value="{{$user->account_no}}"
                                       placeholder="Please enter the name of the user" READONLY>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Name <span
                                        class="asterisk">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" value="{{$user->name}}"
                                       placeholder="Please enter the name of the user" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Email <span
                                        class="asterisk">*</span></label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control" name="email" value="{{$user->email}}"
                                       placeholder="Please enter the email of the user" required>
                                @if($errors->has('email'))
                                    <span class="help-block error">
                                           <strong>{{$errors->first('email')}}</strong>
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
                                ],$user->role,['class'=>'form-control','required'=>'required','placeholder'=>'Please select a role'])  !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-black" data-loading-text="Updating User">Save
                                </button>
                                <button type="button" class="btn btn-danger remove-user"
                                        data-user="{{$user->id}}" data-loading-text="Deleting User">Delete
                                </button>
                            </div>
                        </div>


                    </div>
                    {!! Form::close() !!}
                </div>
            @else
                <div class="alert alert-danger col-md-8 col-md-offset-2 col-sm-12">
                    <h4><i class="fa fa-times-circle-o"></i> &nbsp; No user found with specified ID </h4>
                </div>
            @endif
        </div>
    </div>
@stop
@section('extra-scripts')
    <script src="{{asset('js\user.js')}}"></script>

@stop