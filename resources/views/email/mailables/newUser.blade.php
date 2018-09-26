@extends('email.email')
    @section('content')
        <h2>New Account Created</h2>

        <div >
           Hello {{$user->name}},<br/>
           Your Account has been created with the following credentials.

            <p>Email: {{$user->email}}</p>
            <p>Password: {{$password}}</p>
            <p>ID: {{$user->account_no}}</p>

        </div>
    @endsection