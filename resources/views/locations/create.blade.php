@extends('layouts.citizen')
@section('title')
    Add Location
@stop
@section('extra-styles')

@stop
@section('content')

    <h2>Add Location</h2> <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        All fields with the asterisk (<span class="asterisk">*</span>) are required
                    </div>
                </div>
                <div class="panel-body">

                    {!! Form::open(['url'=>'location','class'=>'form-horizontal','role'=>'form','files'=>'true']) !!}
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Location <span class="asterisk">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="location" value=""
                                   placeholder="Please enter a location" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Comment </label>
                        <div class="col-sm-5">
                            <textarea class="form-control autogrow" name="other_notes"  placeholder="Please enter a comment" ></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-black btn-block" data-loading-text="Saving Location">Save
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