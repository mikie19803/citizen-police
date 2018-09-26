@extends('layouts.citizen')
@section('title')
Add Report
@stop
@section('extra-styles')

@stop
@section('content')

    <h2>REPORT AN INCIDENT</h2> <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        All fields with the asterisk (<span class="asterisk">*</span>) are required
                    </div>
                </div>
                <div class="panel-body">

                    {!! Form::open(['url'=>'report','class'=>'form-horizontal','role'=>'form','files'=>'true']) !!}
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="title" value=""
                                   placeholder="Please enter a title">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Category <span
                                    class="asterisk">*</span></label>
                        <div class="col-sm-5">
                            {!!Form::select('category_id',$categories,null,['class'=>'form-control','required'=>'required','placeholder'=>'Please select a category'])  !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Location <span
                                    class="asterisk">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="location" value="" id="location"
                                   placeholder="Please enter a location">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Description <span class="asterisk">*</span></label>
                        <div class="col-sm-5">
                            <textarea class="form-control autogrow" name="description"  placeholder="Please enter a description" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Other Information</label>
                        <div class="col-sm-5">
                            <textarea class="form-control autogrow" name="extra_description"  placeholder=""></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Upload Documents/Photos</label>
                        <div class="col-sm-5">
                            <input type="file" class="form-control file2 inline btn btn-primary" multiple="1" name="document_file[]"
                                   data-label="<i class='glyphicon glyphicon-circle-arrow-up'></i> &nbsp;Browse Files"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-success btn-block" data-loading-text="Saving Report">Save
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
    <script src="{{asset('js/bootstrap-typeahead.js')}}"></script>
    <script>
        $('input#location').typeahead({
            source: function (query, process) {
                return $.get('/getLocations', {query: query}, function (data) {
                    return process(data);
                });
            }
        });
    </script>

@stop