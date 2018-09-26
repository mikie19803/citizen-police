<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from demo.neontheme.com/extra/blank-page/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 17 May 2017 11:16:42 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Neon Admin Panel"/>
    <meta name="author" content="Laborator.co"/>
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}">
    <title> @yield('title') | Citizen Police </title>
    <link rel="stylesheet" href="{{asset('assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css')}}"
          id="style-resource-1">
    <link rel="stylesheet" href="{{asset('assets/css/font-icons/entypo/css/entypo.css')}}" id="style-resource-2">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}" id="style-resource-4">
    <link rel="stylesheet" href="{{asset('assets/css/neon-core.css')}}" id="style-resource-5">
    <link rel="stylesheet" href="{{asset('assets/css/neon-theme.css')}}" id="style-resource-6">
    <link rel="stylesheet" href="{{asset('assets/css/neon-forms.css')}}" id="style-resource-7">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" id="style-resource-8">
    <script src="{{asset('assets/js/jquery-1.11.3.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('js\sweetalert2\dist\sweetalert2.css')}}">

    <script src="http://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    @yield('extra-styles')
</head>
<body class="page-body login-page login-form-fall" data-url="http://demo.neontheme.com">

@yield('content')

<script src="{{asset('assets/js/gsap/TweenMax.min.js')}}" id="script-resource-1"></script>
<script src="{{asset('assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js')}}" id="script-resource-2"></script>
<script src="{{asset('assets/js/bootstrap.js')}}" id="script-resource-3"></script>
<script src="{{asset('assets/js/joinable.js')}}" id="script-resource-4"></script>
<script src="{{asset('assets/js/resizeable.js')}}" id="script-resource-5"></script>
<script src="{{asset('assets/js/neon-api.js')}}" id="script-resource-6"></script>
<script src="{{asset('assets/js/cookies.min.js')}}" id="script-resource-7"></script>
<!-- JavaScripts initializations and stuff -->
<script src="{{asset('assets/js/neon-custom.js')}}" id="script-resource-8"></script> <!-- Demo Settings -->
<script src="{{asset('assets/js/neon-demo.js')}}" id="script-resource-9"></script>
<script src="{{asset('assets/js/neon-skins.js')}}" id="script-resource-10"></script>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-28991003-7']);
    _gaq.push(['_setDomainName', 'demo.neontheme.com']);
    _gaq.push(['_trackPageview']);
    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
</script>
@yield('extra-scripts')
</body>
<!-- Mirrored from demo.neontheme.com/extra/login/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 17 May 2017 11:12:25 GMT -->
</html>