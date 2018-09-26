@extends('layouts.citizen')
@section('title')
    Notifications
@stop
@section('extra-styles')
    <link href="{{asset('/js/summernote/dist/summernote.css')}}" rel="stylesheet">

@stop
@section('content')
    <div class="row">
        <div class="panel panel-primary col-md-offset-1 col-md-10">
            <div class="panel-heading">
                <div class="panel-title">
                   <h4>Create Notification</h4>
                </div>
            </div>
            <div class="panel-body">
                <form action="{{url('sendNotification')}}" method="post">
{{csrf_field()}}
                    <div class="form-group">
                        <label for="" class="control-label col-md-2">Enter Email Content:</label>
                        <div class="col-md-9">
                            <textarea id="email-content" name="email_content" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-2">Enter Sms Content:</label>
                        <div class="col-md-9">
                            <textarea id="sms-content" class="form-control" name="sms_content" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <button class="btn btn-black" type="submit">Send Notification</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop
@section('extra-scripts')
    <script src="{{asset('/js/summernote/dist/summernote.js')}}"></script>

    <script>
        $('#email-content').summernote({
            placeholder: 'Place content here...',
            disableDragAndDrop: true,
            height: 300

        });


    </script>
@stop