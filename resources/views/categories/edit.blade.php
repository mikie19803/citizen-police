@extends('layouts.citizen')
@section('title')
    Edit Category
@stop
@section('extra-styles')

@stop
@section('content')

    <h2>Edit Category</h2> <br/>
    <div class="row">
        <div class="col-md-12">
            @if($category != null)
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            All fields with the asterisk (<span class="asterisk">*</span>) are required
                        </div>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['url'=>'category/'.$category->id,'class'=>'form-horizontal','role'=>'form','files'=>'true']) !!}
                        {{method_field('PATCH')}}
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Category <span class="asterisk">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="category" value="{{$category->category}}"
                                       placeholder="Please enter a category" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Description </label>
                            <div class="col-sm-5">
                                <textarea class="form-control autogrow" name="description"
                                          placeholder="Please enter a description">{{$category->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Status <span
                                        class="asterisk">*</span></label>
                            <div class="col-sm-5">
                                {!!Form::select('status',[
                                'active'=>'Active',
                                'inactive'=>'Inactive'
                                ],$category->status,['class'=>'form-control','required'=>'required','placeholder'=>'Please select a status'])  !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-black" data-loading-text="Updating Category">Save
                                </button>
                                <button type="button" class="btn btn-danger remove-category"
                                        data-category="{{$category->id}}" data-loading-text="Deleting Category">Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @else
                <div class="alert alert-danger col-md-8 col-md-offset-2 col-sm-12">
                    <h4><i class="fa fa-times-circle-o"></i> &nbsp; No category found with specified ID </h4>
                </div>
            @endif
        </div>
    </div>
@stop
@section('extra-scripts')
    <script src="{{asset('js\category.js')}}"></script>

@stop