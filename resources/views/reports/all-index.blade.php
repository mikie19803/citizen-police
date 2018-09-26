@extends('layouts.citizen')
@section('title')
    Reports
@stop
@section('extra-styles')
    <link rel="stylesheet" href="{{asset('assets/js/datatables/datatables.css')}}">

@stop
@section('content')
    <h2>{{$header}} ({{$reports->total()}} found)</h2> <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary table-responsive" data-collapsed="0">
                <div class="col-md-offset-7">
                    <div class="form-group">
                        <label class="control-label col-md-2">
                            Find By:
                        </label>
                        <div class="col-md-5">
                            <?php

                            if (isset($_GET['status'])) {
                                $status = $_GET['status'];
                            } else {
                                $status = '';
                            }
                            ?>
                            <select id="filter" class="form-control">
                                <option value=""
                                        @if(strcasecmp(trim($status),'')==0)
                                        selected
                                        @endif
                                >All Cases
                                </option>
                                <option value="open"

                                        @if(strcasecmp(trim($status),'open')==0)
                                        selected
                                        @endif
                                >Open Cases
                                </option>
                                <option value="closed"

                                        @if(strcasecmp(trim($status),'closed')==0)
                                        selected
                                        @endif
                                >Closed Cases
                                </option>
                            </select></div>
                    </div>
                </div>
                <br/>
                <br/>
                <br/>
                <table class="table table-bordered datatable responsive no-wrap" id="table-1">
                    <thead>
                    <tr>
                        <th data-hide="phone"></th>
                        <th data-hide="phone">Title</th>
                        <th>Category</th>
                        <th data-hide="phone">Description</th>
                        <th data-hide="phone,tablet">Entry Date</th>
                        <th>Status</th>
                        <th>Code</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $key=>$report)
                        <tr class="odd gradeX">
                            <td>{{$key +1}}
                            @if($report->state=='new')
                                <label class="badge badge-warning">New</label>
                                @endif
                            </td>
                            <td>{{$report->title}}</td>
                            <td>{{$report->category->category}}</td>
                            <td>
                                {!!str_limit(nl2br($report->description),100)  !!}
                            </td>
                            <td class="center">{{\Carbon\Carbon::parse($report->created_at)->toDayDateTimeString()}}</td>
                            <td class="center">{{ucfirst($report->status)}}</td>
                            <td class="center">{{$report->code}}</td>
                            <td class="center">
                                <a href="{{url('/report/'.$report->code.'/')}}">
                                    <span class="btn btn-info btn-sm btn-icon icon-right">View Case Details<i class="entypo-eye"></i> </span>
                                </a>
                                <a href="{{url('/report/'.$report->id.'/assign')}}">
                                    <span class="btn btn-primary btn-sm btn-icon icon-right"> Officers assigned <i class="entypo-users"></i></span>
                                </a>

                            </td>
                            {{$report->setNullState}}
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-offset-4">
                    {{$reports->links()}}
                </div>
            </div>
        </div>
    </div>
  @stop
@section('extra-scripts')
    <script src="{{asset('assets/js/datatables/datatables.js')}}" id="script-resource-8"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        $('.pagination li a').click(function (e) {
            e.preventDefault();
            loc = $(this).attr('href');
            status = $('#filter').val();
            locationn = loc + "&status=" + status;
            window.location.href = locationn;
            return false
        });

        $('#filter').change(function (e) {
            status = $(this).val();
            window.location.href = '/report/all?status=' + status
        });

        $('.show-modal').click(function (e) {
            $('#myModal').modal('toggle');

            id = $(this).attr('data-report');
            title = $(this).attr('data-report-name');
            $('.modal-title').html('Assign ' + title + ' to Officer');
        });

    </script>
@stop