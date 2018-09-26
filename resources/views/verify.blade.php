@extends('layouts.citizen')
@section('title')
Activate Account
@stop
@section('extra-styles')

@stop
@section('content')
    <div class="row" style="margin-top:30px">
                                 @if(isset($confirmationError))
                                     <div class="alert alert-warning col-md-8 col-md-offset-2 col-sm-12">
                                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                         <h4><i class="fa fa-times-circle-o"></i> {!! $confirmationError !!} </h4>
                                     </div>
                                 @endif
                 </div>
@stop
@section('extra-scripts')

@stop
