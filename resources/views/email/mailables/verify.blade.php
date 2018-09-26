@extends('email.email')
    @section('content')
        <h2>Verify Your Email Address</h2>

        <div >
            Thanks for creating an account with {{config('app.name')}}.
            Please follow the link below to verify your email address.
            <a href="{{URL::to('register/verify/' . $confirmation_code."/".$confirmation_status)}}">{{ URL::to('register/verify/' . $confirmation_code."/".$confirmation_status) }}</a>
             <br/>

        </div>
    @endsection