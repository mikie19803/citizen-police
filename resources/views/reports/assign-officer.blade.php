@extends('layouts.citizen')
@section('title')

@stop
@section('extra-styles')

@stop
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                       <h3> Assigned Officers to case: {{$report->title}}<br/> Code:{{$report->code}}</h3>
                    </div>
                </div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'report','class'=>'form-horizontal','role'=>'form','files'=>'true']) !!}
                    <input type="hidden" name="report_id" value="{{$report->id}}">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-5">
                            <h3>Officers already assigned to Case ({{count($assignedOfficers)}} found)</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-8 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>

                                </thead>
                                <tbody>
                                @forelse($assignedOfficers as $key=>$assigned)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$assigned->name}}</td>
                                        <td>
                                            <span class="btn btn-danger btn-sm btn-icon icon-right remove-officer" data-officer="{{$assigned->id}}"
                                                   data-toggle="tooltip" title="Remove this officer from the case">
                                               Remove officer<i class="entypo-cancel"></i> </span>

                                            <a href="{{url('/user/'.$assigned->id.'/case')}}">
                                                <span class="btn btn-success btn-sm btn-icon icon-right">Officer's Cases <i class="entypo-book"></i> </span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">No Officers have been assigned to this case</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>


                 <br/><br/>
                <div class="form-group">

                    <label for="field-1" class="col-sm-3 control-label">Select Officer</label>
                    <div class="col-sm-5">
                        <select class="form-control" id="add-officer" name="add-officer">
                            <option value="">Please select an officer</option>
                            @foreach($officers as $officer)
                                <option value="{{$officer->id}}"
                                        data-officer-name="{{$officer->name}}">{{$officer->name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>


                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-5" id="assign-officers">

                    </div>

                </div>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="button" id="submit-officers" class="btn btn-block btn-info pull-right">
                            Submit
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
    <script>
        var token = $("input[name='_token']").val();
        var report_id = $("input[name='report_id']").val();


        $(document).on('click', '.remove-officer', function (e) {
            id = $(this).attr('data-officer');
            swal({
                                    title: 'Are you sure you want to remove this officer from this case ?',
                                    text: "You won't be able to revert this!",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, remove',
                                    cancelButtonText: 'No, cancel!',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false
                                }).then(function () {
                                     $.ajax({
                                                             type:"post",
                                                             url:'/'+'unassignOfficer',
                                                             data:{_token:token,officer_id:id,report_id:report_id},
                                                             success:function (e) {
                                                                 swal(
                                                                     '',
                                                                     'Officer has been removed from the case',
                                                                     'success'
                                                                 ).then(function(e){
                                                                     window.location.reload();
                                                                 })
                                                             }
                                                         });

                                }, function (dismiss) {
                                    // dismiss can be 'cancel', 'overlay',
                                    // 'close', and 'timer'
                                    if (dismiss === 'cancel') {
                                        swal(
                                            'Cancelled',
                                            'Officer was not removed',
                                            'error'
                                        )
                                    }
                                })

        });
        $(document).on('change', '#add-officer', function (e) {
            id = $('#add-officer').val();
            if ($.trim(id) != '') {
                name = $('#add-officer option:selected').attr('data-officer-name');
                idArr = getIdArray('assign');

                if ($.inArray(id, idArr) != -1) {
                    swal(
                        '',
                        'This officer has already been selected.',
                        'error'
                    )
                } else {
                    $.ajax({
                        type: "post",
                        url: '/verifyAssignedOfficer',
                        data: {_token: token, user_id: id, report_id: report_id},
                        success: function (e) {
                            if (e == 0) {
                                swal(
                                    '',
                                    'This officer has already been assigned to the case.',
                                    'error'
                                )
                            } else if (e == 1) {

                                $('#assign-officers').append("<p data-officer=" + id + " class='assign'> <span class='label label-danger remove-officer-div'>X</span> " +
                                    name + " " + "</p>");
                            }
                        }
                    });
                }

            }
        });
        $(document).on('click', '.remove-officer-div', function () {
            $(this).parents('p').remove();
        });
        $('#submit-officers').click(function (e) {
            idArray = getIdArray('assign');
            $.ajax({
                type: "post",
                url: '/' + 'report/' + report_id + '/assign',
                data: {_token: token, id_array: idArray, report_id: report_id},
                success: function (e) {
                    swal(
                        'Success',
                        'The selected officers have been assigned to the case',
                        'success'
                    ).then(function(e){
                        window.location.reload();
                    })
                }
            });
        })
        $

        function getIdArray(classname) {
            sel = '.' + classname;
            arr = [];
            $(sel).each(function (e) {
                a = $(this).attr('data-officer');
                arr.push(a);
            });
            return arr;
        }

    </script>
@stop