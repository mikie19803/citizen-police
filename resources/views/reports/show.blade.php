@extends('layouts.citizen')
@section('title')
    Report
@stop
@section('extra-styles')
    <link rel="stylesheet" href="{{asset('assets/js/vertical-timeline/css/component.css')}}" id="style-resource-1">
    <link rel="stylesheet" href="{{asset('assets/css/font-icons/font-awesome/css/font-awesome.min.css')}}"
          id="style-resource-1">
    <style>
        .mtime {
            font-size: 11px !important;
        }

        .cbp_tmlabel {
            padding: 10px !important;
        }

        .content {
            margin-left: 10%;
        }

    </style>
@stop
@section('content')

    <h2>Details of Report </h2>
    @if(Auth::check() && Auth::user()->is_admin)
        <h2>
            <button class="btn btn-black close-case">Close this case</button>
        </h2>
    @endif
    <br/>
    <div class="row">
        @if($report!=null)
            <div class="col-md-12" style="padding:10px">
                <div class="panel panel-primary" data-collapsed="0">

                    @if($report->reported_by == null)
                        <div class="panel-heading">
                            <div class="panel-title">
                                Did you report this case? Click
                                <a href="javascript:;" class="label label-secondary"
                                   onclick="jQuery('#modal-5').modal('show', {backdrop: 'static'});"> HERE </a>

                                to add it to your account.
                            </div>
                        </div>
                    @endif

                    <div class="panel-body">
                        <div class="col-md-offset-1">
                            {!! Form::model($report,['url'=>'report/'.$report->code,'class'=>'form-horizontal','method'=>'post','role'=>'form','files'=>'true']) !!}
                            {{method_field('PATCH')}}

                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block">Title</button>

                                </div>
                                <div class="col-md-6 content btn btn-default">
                                    {{$report->title}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block">Date</button>

                                </div>
                                <div class="col-md-6 content btn btn-default">
                                    {{\Carbon\Carbon::parse($report->created_at)->toDayDateTimeString()}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block">Category</button>

                                </div>
                                <div class="col-md-6 content btn btn-default">
                                    {{$report->category->category}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block">Status</button>

                                </div>
                                <div class="col-md-6 content btn btn-default">
                                    {{ucfirst($report->status)}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block">
                                        @if($report->reported_by == null)
                                            Description
                                        @else
                                            Statement
                                        @endif
                                    </button>

                                </div>
                                <div class="col-md-6 content btn btn-default">
                                    {!! nl2br($report->description) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block">Other Information</button>

                                </div>
                                <div class="col-md-6 content btn btn-default">
                                    {!! nl2br($report->extra_description) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block">Complainant</button>

                                </div>
                                <div class="col-md-6 content btn btn-default">
                                    @if($report->reported_by == null)
                                        Anonymous
                                    @else
                                        {!! nl2br($report->reportedBy->name) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block">Officers in charge:</button>

                                </div>
                                <div class="col-md-6 content btn btn-default">

                                    @forelse($report->officers as $collaborator)
                                        {{$collaborator->name}}<br/>
                                    @empty
                                        No officers have been assigned.

                                    @endforelse


                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block">Collaborators</button>

                                </div>
                                <div class="col-md-6 content btn btn-default">
                                    @if($report->reported_by == null)
                                        This report is currently not attached to any account.
                                    @else
                                        @forelse($report->citizens as $collaborator)
                                            {{$collaborator->name}}<br/>
                                        @empty
                                            {{--This should never show :-)--}}
                                            No collaborators have been added.
                                        @endforelse
                                        <br>
                                        <span class="label label-success">Pending Requests</span>
                                        @if(Auth::check() && Auth::user()->is_citizen)
                                            <a href="javascript:;" class="label label-warning" id="add-collaborator"
                                               onclick="jQuery('#modal-6').modal('show', {backdrop: 'static'});">
                                                Add Collaborator</a>
                                        @endif
                                        <br/>
                                        <div id="pending-requests">

                                            @forelse($report->invitations as $invitations)
                                                {{$invitations->invited->name}}<br/>

                                            @empty
                                                <div id="no-pending">
                                                    No Pending requests found.
                                                </div>

                                            @endforelse
                                        </div>

                                    @endif

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block">Code</button>

                                </div>
                                <div class="col-md-6 content btn btn-default">
                                    {{$report->code}}
                                </div>
                            </div>
                            @if(!isset($_GET['invitation']))
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <button class="btn btn-info btn-block">Documents</button>

                                    </div>
                                    <div class="col-md-6 content btn btn-default">
                                        @forelse($documents as $document)
                                            <a href="{{asset('documents/'.$document->path)}}" download>
                                    <span class="label label-info"><i
                                                class="entypo-download"></i> </span> {{$document->path}}
                                            </a>
                                            Uploaded {{\Carbon\Carbon::parse($document->created_at)->diffForHumans()}}
                                            <br/>
                                            <br/>
                                        @empty
                                            No documents have been uploaded.
                                        @endforelse
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 col-md-offset-1 control-label">Add
                                        Comment</label>
                                    <div class="col-md-5">
                                        <textarea class="form-control autogrow" name="comment" id="comment"></textarea>
                                        <div class="error" id="comment-error"></div>
                                        @if(Auth::guest())
                                            <span class="asterisk">*You must be logged in to post a comment</span>
                                        @endif
                                    </div>
                                    <div class="col-md-2">

                                        <button type="button" id="add-comment" class="btn btn-blue btn-block"
                                                data-loading-text="Saving Comment"
                                                @if(Auth::guest())
                                                disabled="disabled"
                                                @endif > Save
                                        </button>

                                    </div>

                                </div>
                                <div class="form-group">

                                    <label for="field-1" class="col-md-3  col-md-offset-1 control-label">Upload
                                        Documents/Photos</label>
                                    <div class="col-md-5">
                                        <input type="file" class="form-control file2 inline btn btn-primary"
                                               multiple="1"
                                               required
                                               name="document_file[]"
                                               data-label="<i class='glyphicon glyphicon-circle-arrow-up'></i> &nbsp;Browse Files"/>
                                    </div>
                                    <div class="col-md-2">

                                        <button type="submit" id="add-comment" class="btn btn-info btn-block"
                                                data-loading-text="Uploading Files"
                                                @if(Auth::guest())
                                                disabled="disabled"
                                                @endif > Upload
                                        </button>

                                    </div>
                                    <input type="hidden" name="user_id" id="user-id"
                                           @if(Auth::check())
                                           value="{{Auth::user()->id}}"
                                            @endif >
                                    <input type="hidden" name="report_id" id="report-id"
                                           value="{{$report->id}}">
                                    <div class="form-group">

                                    </div>


                                </div>
                            @endif
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>

            @if(!isset($_GET['invitation']))
                <div class="col-md-offset-2 col-md-8">
                    <div class="panel panel-info" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Comments <span class="badge badge-info" id="comment-count">{{$comments->count()}}</span>
                            </div>
                        </div>
                        <div class="panel-body scrollable" data-height="700" style="height: 700px">

                            <ul class="cbp_tmtimeline" id="timeline">
                                @forelse($comments as $comment)
                                    <li>
                                        <time class="cbp_tmtime " datetime="2017-05-17T03:45">
                                            <span class="mtime">{{\Carbon\Carbon::parse($comment->created_at)->format('g:i a')}}</span>
                                            <span class="mtime">{{\Carbon\Carbon::parse($comment->created_at)->format('d M, Y')}}</span>
                                        </time>
                                        <div class="cbp_tmicon
                                    @if($comment->user->role=='citizen')
                                                bg-info
                                    @elseif($comment->user->role=='officer')
                                                bg-success
                                    @endif
                                                ">
                                            <i class="
                                    @if($comment->user->role=='citizen')
                                                    fa fa-user
                                    @elseif($comment->user->role=='officer')
                                                    fa fa-shield
                                    @endif
                                                    "></i>
                                        </div>
                                        <div class="cbp_tmlabel" style="background-color:
                                        @if($comment->user->role=='citizen')
                                        {{\App\Http\Controllers\GeneralController::getCitizenCmtBckGrnd()}}

                                        @elseif($comment->user->role=='officer')
                                        {{\App\Http\Controllers\GeneralController::getOfficerCmtBckGrnd()}}

                                        @endif
                                                ">
                                            <h2><a href="#">{{$comment->user->name}}</a></h2>
                                            <p>{{$comment->comment}}</p>
                                        </div>
                                    </li>
                                @empty
                                    <li id="no-comment">
                                        No comments have been added.
                                    </li>
                                @endforelse

                            </ul>


                        </div>
                    </div>
                </div>
            @endif
            @if(isset($_GET['invitation']))

                <input type="hidden" name="report_id" id="report-id"
                       value="{{$report->id}}">
                <div class="col-md-5">
                    <button class="btn btn-success" id="accept">Accept Invitation</button>
                    <button class="btn btn-danger" id="decline">Decline Invitation</button>
                </div>
            @endif
        @else
            <div class="alert alert-danger col-md-8 col-md-offset-2 col-md-12">
                <h4><i class="fa fa-times-circle-o"></i> &nbsp; No report found with specified code. </h4>
            </div>
        @endif



        {{--modals--}}
        {{--ADD COLLABORATOR MODAL--}}
        <div class="modal fade" id="modal-6">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add Collaborator</h4>
                        <h6>Please add a collaborator using one of the following options</h6>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="{{url('/addCollaborator')}}" method="post" id="by-id">
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <input type="text" placeholder="Please enter ID of user" required name="value"
                                               class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-blue">Invite By ID</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{url('/addCollaborator')}}" method="post" id="by-email">
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <input type="email" placeholder="Please enter email of user" required
                                               name="value"
                                               class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-blue">Invite By Email</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{url('/addCollaborator')}}" method="post" id="by-number">
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <input type="text" placeholder="Please enter phone number of user" name="value"
                                               required
                                               class="form-control phone">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-blue">Invite By Phone Number</button>
                                    </div>
                                </div>
                            </form>
                            <br>


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        {{--ATTACH TO ACCOUNT MODAL--}}
        <div class="modal fade" id="modal-5">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add Report to Account.</h4>
                        <h6>Please enter the secret code given to you during after you submitted the report.</h6>
                    </div>
                    <form action="" method="post" id="attach-to-account">

                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <input type="text" placeholder="code" required name="code"
                                               class="form-control">
                                    </div>

                                </div>
                                <br>


                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-blue">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
@stop
@section('extra-scripts')
    <script type="text/javascript"
            src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
        function initialize() {
            var $ = jQuery,
                map_canvas = $("#sample-checkin");
            var location = new google.maps.LatLng(36.738888, -119.783013),
                map = new google.maps.Map(map_canvas[0], {
                    center: location,
                    zoom: 14,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false
                });
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script src="{{asset('js/bootstrap-typeahead.js')}}"></script>

    <script src="{{asset('js\jquery.alphanumeric-master\jquery.alphanumeric-master\jquery.alphanumeric.js')}}"></script>

    <script>
        $('.phone').numeric({
            allow: "+ -()"
        });
    </script>
    <script>
        var token = $("input[name='_token']").val();
        var report_id = $('#report-id').val();

        $('#add-comment').click(function (e) {
            $('.error').html('');
            comment = $('#comment').val();
            if ($.trim(comment) == '') {
                $('#comment-error').html('Please enter a comment');
            } else {


                swal({
                    title: 'Are you sure you want to post this comment?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, post it',
                    cancelButtonText: 'No, cancel',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    $.ajax({
                        type: "post",
                        url: '/' + 'postComment',
                        data: {_token: token, comment: comment, report_id: report_id},
                        success: function (e) {
                            if (e == 0) {
                                swal(
                                    'Cancelled',
                                    'You must be logged in to post a comment?',
                                    'error'
                                )


                            }
                            if (e == 2) {
                                swal(
                                    'Cancelled',
                                    'Sorry, you cannot post comments on this case.',
                                    'error'
                                )

                            }
                            else {
                                $('#no-comment').remove();
                                $('#timeline').prepend(e);

                                commentcount = parseInt($('#comment-count').html()) + 1;
                                $('#comment-count').html(commentcount);
                                comment = $('#comment').val('');


                            }
                        }
                    });


                }, function (dismiss) {
                    // dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                    if (dismiss === 'cancel') {
                        swal(
                            'Cancelled',
                            'Your comment was not posted'
                        )
                    }
                })
            }
        });
        $('#by-id').submit(function (e) {
            formdata = $(this).serialize();

            $.ajax({
                type: "post",
                url: '/' + 'addCollaborator/id',
                data: {_token: token, formdata: formdata, report_id: report_id},
                success: function (e) {
                    invitationResult(e);
                }
            });
            return false
        })
        $('#by-email').submit(function (e) {
            formdata = $(this).serialize();

            $.ajax({
                type: "post",
                url: '/' + 'addCollaborator/email',
                data: {_token: token, formdata: formdata, report_id: report_id},
                success: function (e) {
                    invitationResult(e);
                }
            });
            return false
        })
        $('#by-number').submit(function (e) {
            formdata = $(this).serialize();

            $.ajax({
                type: "post",
                url: '/' + 'addCollaborator/number',
                data: {_token: token, formdata: formdata, report_id: report_id},
                success: function (e) {
                    invitationResult(e);
                }
            });
            return false
        })
        $('#attach-to-account').submit(function (e) {
            formdata = $(this).serialize();
            $.ajax({
                type: "post",
                url: '/' + 'attachToAccount',
                data: {_token: token, formdata: formdata},
                success: function (e) {
                    $('#modal-5').modal('hide');
                    if (e == 1) {
                        swal({
                            title: 'Action successful.',
                            text: "This report can now be seen from your account.",
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                            confirmButtonClass: 'btn btn-success',
                            buttonsStyling: false
                        }).then(function () {
                            window.location.reload();
                        })
                    } else if (e == 2) {
                        swal(
                            '',
                            'You must be logged in to perform this action',
                            'error'
                        )
                    } else if (e == 3) {
                        swal(
                            '',
                            'The code entered is wrong. Please verify and try again.',
                            'error'
                        )
                    }
                }
            });

            return false;
        })
        $('#decline').click(function () {
            $.ajax({
                type: "post",
                url: '/' + 'invitation?action=decline',
                data: {_token: token, report_id: report_id},
                success: function (e) {
                    swal(
                        '',
                        e,
                        'success'
                    );
                    window.location.reload();
                }
            });
        });
        $('#accept').click(function () {
            $.ajax({
                type: "post",
                url: '/' + 'invitation?action=accept',
                data: {_token: token, report_id: report_id},
                success: function (e) {
                    swal(
                        '',
                        e,
                        'success'
                    );
                    window.location.reload();
                }
            });
        });
        $('.close-case').click(function () {
            swal({
                title: 'Are you sure you want to close this case ?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, close it',
                cancelButtonText: 'No, cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function () {
                $.ajax({
                    type: "post",
                    url: '/' + 'report/'+report_id+'/close',
                    data: {_token: token, report_id: report_id},
                    success: function (e) {
                        swal(
                            '',
                            'This case has been closed.',
                            'success'
                        ).then(function(){
                            window.location.reload();
                        })
                    }
                });

            })
        });


        function invitationResult(a) {
            $('#modal-6').modal('hide');
            a = $.parseJSON(a);
            for (i = 0; i < a.length; i++) {
                e = a[i].code;
                name = a[i].name;
            }

            console.log(name);
            if (e == 0) {
                swal(
                    'Error',
                    'Sorry, your invitation could not be sent. Please try again later.',
                    'error'
                )

            } else if (e == 1) {
                swal(
                    '',
                    'Invitation has been sent.',
                    'success'
                )
                $('#no-pending').remove();
                $('#pending-requests').append(name + "<br");

            } else if (e == 2) {
                swal(
                    '',
                    'Sorry, this user was not found in the system.',
                    'error'
                )

            } else if (e == 3) {
                swal(
                    '',
                    'An invitation has already been sent to this user.',
                    'warning'
                )

            } else if (e == 4) {
                swal(
                    '',
                    'This user is already a collaborator',
                    'error'
                )
            }
        }

    </script>

@stop