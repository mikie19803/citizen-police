@extends('email.email')
    @section('content')
        <h2>Invitation from {{config('app.name')}}</h2>

        <div >
           Hello {{$name}},<br/>
           You have received an invitation from {{$inviteFrom}} to collaborate on a case.<br>
            Kindly log into you account to accept the invitation.

        </div>
    @endsection