<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <script src="{{asset('assets/js/bootstrap.js')}}" id="script-resource-3"></script>
</head>
<body style="padding: 5%;">
{{--<div style="background: #92C941;padding: 1%" >--}}
    {{--<div style="">--}}
{{--        <img src="{{$message->embed('wp-content/uploads/sites/2/2014/09/logo.png')}}" width="200px" height="80px" alt="ARB Apex" class="img-responsive">--}}
    {{--</div>--}}

{{--</div>--}}
<div style="margin-left: 10%">
    @yield('content')

    <br/>
</div>
<div>
    <div class="col-sm-offset-7">
        © {{date('Y')}} Citizen Police
    </div>
</div>
{{--<div style="background-color: #92C941; padding: 2%">--}}
    {{--<div style="font-size: 10px">--}}

        {{--No. 5, 9th Road,<br/>--}}
        {{--Gamel Abdul Nasser Avenue, <br/>--}}
        {{--South Ridge, Accra. <br/>--}}
        {{--P. O. Box GP 20321, Accra <br/>--}}
        {{--0302 – 771738 / 772129 / 772034<br/>--}}
        {{--info@citizenPolice.com--}}
    {{--</div>--}}
{{--</div>--}}

<script src="{{asset('assets/js/bootstrap.js')}}" id="script-resource-3"></script>

</body>
</html>