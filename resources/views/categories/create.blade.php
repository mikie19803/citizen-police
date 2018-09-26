@extends('layouts.citizen')
@section('title')
    Add Category
@stop
@section('extra-styles')

@stop
@section('content')

    <h2>Add Category</h2> <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        All fields with the asterisk (<span class="asterisk">*</span>) are required
                    </div>
                </div>
                <div class="panel-body">

                    {!! Form::open(['url'=>'category','class'=>'form-horizontal','role'=>'form','files'=>'true']) !!}
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Category <span class="asterisk">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="category" value=""
                                   placeholder="Please enter a category" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Description </label>
                        <div class="col-sm-5">
                            <textarea class="form-control autogrow" name="description"  placeholder="Please enter a description" ></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-black btn-block" data-loading-text="Saving Category">Save
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