@extends('layouts.citizen')
@section('title')
    Edit Location
@stop
@section('extra-styles')

@stop
@section('content')

    <h2>Edit Location</h2> <br/>
    <div class="row">
        <div class="col-md-12">
            @if($location != null)
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            All fields with the asterisk (<span class="asterisk">*</span>) are required
                        </div>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['url'=>'location/'.$location->id,'class'=>'form-horizontal','role'=>'form','files'=>'true']) !!}
                        {{method_field('PATCH')}}
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Location <span class="asterisk">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="location" value="{{$location->location}}"
                                       placeholder="Please enter a location" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Comment </label>
                            <div class="col-sm-5">
                                <textarea class="form-control autogrow" name="other_notes"
                                          placeholder="Please enter a comment">{{$location->other_notes}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">


                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-black" data-loading-text="Updating Location">Save
                                </button>
                                <button type="button" class="btn btn-danger remove-location"
                                        data-location="{{$location->id}}" data-loading-text="Deleting Report">Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @else
                <div class="alert alert-danger col-md-8 col-md-offset-2 col-sm-12">
                    <h4><i class="fa fa-times-circle-o"></i> &nbsp; No location found with specified ID </h4>
                </div>
            @endif
        </div>
    </div>
@stop
@section('extra-scripts')
    <script src="{{asset('js\location.js')}}"></script>

@stop