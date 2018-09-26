@extends('layouts.citizen')
@section('title')
    Users
@stop
@section('extra-styles')
    <link rel="stylesheet" href="{{asset('assets/js/datatables/datatables.css')}}">

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

    <h2>Users</h2> <br/>
    {{csrf_field()}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary table-responsive" data-collapsed="0">

                <table class="table table-bordered datatable responsive no-wrap" id="table-1">
                    <thead>
                    <tr>
                        <th data-hide="phone"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key=>$user)
                        <tr class="odd gradeX">
                            <td>{{$key +1}}</td>
                            <td>{{$user->account_no}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{ucfirst($user->user_role)}}</td>

                            <td class="center">{{\Carbon\Carbon::parse($user->created_at)->toDayDateTimeString()}}</td>
                            <td class="center">
                                <a href="{{url('/user/'.$user->id.'/edit')}}">
                                    <span class="btn btn-info btn-sm btn-icon icon-right">View <i class="entypo-eye"></i> </span>
                                </a>
                                <span class="btn btn-danger btn-sm btn-icon icon-right remove-user" data-user="{{$user->id}}">Delete <i
                                            class="entypo-trash"></i> </span>

                                @if($user->isOfficer)
                                    <a href="{{url('/user/'.$user->id.'/case')}}">
                                        <span class="btn btn-success btn-sm btn-icon icon-right">Cases <i class="entypo-folder"></i> </span>
                                    </a>


                                @endif
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
    <script src="{{asset('js\user.js')}}"></script>


@stop