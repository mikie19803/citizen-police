@extends('email.email')
    @section('content')
        <h2>Notification from {{config('app.name')}}</h2>

        <div >
           Hello {{$name}}, <br/>
            <p>{!! $msg !!} </p>

        </div>
    @endsection