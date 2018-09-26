@extends('layouts.citizen')
@section('title')
Reports
@stop
@section('extra-styles')
    <link rel="stylesheet" href="{{asset('assets/js/datatables/datatables.css')}}"  >

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            var $table1 = jQuery('#table-1');
// Initialize DataTable
            $table1.DataTable({
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "bStateSave": true

            });
        });
    </script>
@stop

@section('content')
    <h2>{{$header}}</h2> <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary table-responsive" data-collapsed="0">

                <table class="table table-bordered datatable responsive no-wrap" id="table-1">
                    <thead>
                    <tr>
                        <th data-hide="phone"> </th>
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
                        <td>{{$key +1}}</td>
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
                                <span class="btn btn-info btn-sm btn-icon icon-right">View <i class="entypo-eye"></i> </span>
                            </a>
                        </td>
                    </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
</div>
@stop
@section('extra-scripts')
    <script src="{{asset('assets/js/datatables/datatables.js')}}" id="script-resource-8"></script>
<script>
</script>
@stop