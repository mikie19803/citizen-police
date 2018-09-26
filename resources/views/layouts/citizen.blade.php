<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
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
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"
          id="style-resource-3">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}" id="style-resource-4">
    <link rel="stylesheet" href="{{asset('assets/css/neon-core.css')}}" id="style-resource-5">
    <link rel="stylesheet" href="{{asset('assets/css/neon-theme.css')}}" id="style-resource-6">
    <link rel="stylesheet" href="{{asset('assets/css/neon-forms.css')}}" id="style-resource-7">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" id="style-resource-8">
    <script src="{{asset('assets/js/jquery-1.11.3.min.js')}}"></script>
    <script src="http://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link rel="stylesheet" href="{{asset('js\sweetalert2\dist\sweetalert2.css')}}">

    <style>
        .asterisk, .error {
            color: crimson;
        }

        .label {
            cursor: pointer;
        }

        .page-div {
            background-color: red;
        }
    </style>

</head>

@yield('extra-styles')
<body class="page-body">
@php
    use Carbon\Carbon
@endphp
<div class="page-container">
    <div class="sidebar-menu">
        <div class="sidebar-menu-inner">
            <header class="logo-env"> <!-- logo -->
                <div class="logo">
                    <img src="{{url(asset('/images/logo.jpeg'))}}" style="width: 50px;height: 50px;">
                    <font style="font-size: 20px;color: white;"> CITIZEN POLICE</font></div>
                <!-- logo collapse icon -->
                <div class="sidebar-collapse"><a href="#" class="sidebar-collapse-icon">
                        <!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                        <i class="entypo-menu"></i> </a></div>
                <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                <div class="sidebar-mobile-menu visible-xs"><a href="#" class="with-animation">
                        <!-- add class "with-animation" to support animation --> <i class="entypo-menu"></i> </a></div>
            </header>
            <ul id="main-menu" class="main-menu">
                <li><a href="{{url('/')}}"><i class="entypo-home"></i> <span class="title">Home</span></a></li>
                {{--<li><a href="{{url('/dashboard')}}"><i class="entypo-home"></i><span class="title">Dashboard</span></a></li>--}}

                <li class="has-sub"><a href="#"><i class="entypo-folder"></i> <span class="title">Reports</span></a>
                    <ul>
                        @if(Auth::check()&&Auth::user()->isAdmin)
                            <li>
                                <a href="{{url('report/all?status=open')}}"><span class="title">All Reports</span></a>
                            </li>
                        @endif
                        @if(Auth::check()&&Auth::user()->isOfficer)
                            <li>
                                <a href="{{url('report')}}">
                                    <span class="title">My Assigned Cases</span>
                                </a>
                            </li>
                        @endif
                        @if((Auth::check() && Auth::user()->isCitizen )|| Auth::guest())
                            <li><a href="{{url('report/create')}}"><span class="title">Report An Incident</span></a>
                            </li>
                            <li><a href="{{url('/report')}}"><span class="title">My Reported Incidents</span></a>
                            </li>
                        @endif


                    </ul>
                </li>
                @if((Auth::check() && Auth::user()->isCitizen ))
                    <li><a href="{{url('/profile')}}"><i class="entypo-user"></i><span
                                    class="title">My Account</span></a>
                    </li>

                @endif

                @if(Auth::check()&&Auth::user()->isAdmin)
                    <li class="has-sub"><a href="#"><i class="entypo-doc-text"></i> <span
                                    class="title">Categories</span></a>
                        <ul>
                            <li><a href="{{url('category/create')}}"><span class="title">Add a category</span></a>
                            </li>
                            <li><a href="{{url('/category')}}"><span class="title">List Categories</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub"><a href="#"><i class="entypo-location"></i> <span class="title">Locations</span></a>
                        <ul>
                            <li><a href="{{url('location/create')}}"><span class="title">Add a location</span></a>
                            </li>
                            <li><a href="{{url('/location')}}"><span class="title">List Locations</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub"><a href="#"><i class="entypo-users"></i> <span class="title">Users</span></a>
                        <ul>
                            <li><a href="{{url('user/create')}}"><span class="title">Add a user</span></a>
                            </li>
                            <li><a href="{{url('/user')}}"><span class="title">List Users</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub"><a href="#"><i class="entypo-bell"></i> <span
                                    class="title">Send Notification</span></a>
                        <ul>
                            <li><a href="{{url('sendNotification')}}"><span class="title">Send a notification</span></a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="{{url('/backupDatabase')}}"><i class="entypo-database"></i> <span
                                    class="title">Back Up Database</span></a>

                    </li>

                @endif
                @if(Auth::guest())

                    <li><a href="{{url('/login')}}"><i class="entypo-login"></i> <span
                                    class="title">Sign In</span></a>

                    </li>
                @else

                    <li><a href="{{url('/logout')}}"><i class="entypo-logout"></i> <span
                                    class="title">Sign Out</span></a>

                    </li>
                @endif

            </ul>
        </div>
    </div>

    <div class="main-content page-div" style="background-image: url('{{asset('images/bckgrnd.jpg')}}');
            background-repeat : no-repeat;
            background-size:100% 100%
            ">
        <div class="row"> <!-- Profile Info and Notifications -->
            <div class="col-md-6 col-sm-8 clearfix">
                <ul class="user-info pull-left pull-none-xsm"> <!-- Profile Info -->
                    <li class="profile-info dropdown">
                        <!-- add class "pull-right" if you want to place this from right -->
                        <a href="#"
                           class="dropdown-toggle"
                           data-toggle="dropdown" style="font-size: 18px">

                            {{--<img src="assets/images/thumb-1%402x.png" alt="" class="img-circle" width="44"/>--}}

                            @if(Auth::check())
                                {{Auth::user()->name}} (<span class="asterisk">ID: </span>{{Auth::user()->account_no}})
                            @else
                                Hello citizen,
                            @endif
                        </a>
                        <ul class="dropdown-menu"> <!-- Reverse Caret -->
                            <li class="caret"></li> <!-- Profile sub-links -->
                            <li><a href="{{url('/profile')}}"> <i class="entypo-user"></i>
                                    My Account
                                </a>
                            </li>
                            {{--<li><a href="mailbox/main/index.html"> <i class="entypo-mail"></i>--}}
                            {{--Inbox--}}
                            {{--</a></li>--}}
                            {{--<li><a href="extra/calendar/index.html"> <i class="entypo-calendar"></i>--}}
                            {{--Calendar--}}
                            {{--</a></li>--}}
                            {{--<li><a href="#"> <i class="entypo-clipboard"></i>--}}
                            {{--Tasks--}}
                            {{--</a></li>--}}
                        </ul>
                    </li>
                </ul>
                <ul class="user-info pull-left pull-right-xs pull-none-xsm">
                    <li class="notifications dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                          data-hover="dropdown" data-close-others="true"> <i
                                    class="entypo-list"></i> <span
                                    class="badge badge-warning">{{sizeof($invitationsN)}}</span> </a>
                        <ul class="dropdown-menu">
                            <!-- TS14950193223600: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
                            <li class="top"><p>You have {{sizeof($invitationsN)}} invitation(s)</p></li>
                            <li>
                                <ul class="dropdown-menu-list scroller">
                                    @forelse($invitationsN as $invitation)

                                        <li class="unread notification-success">
                                            <a href="{{url('report/'.$invitation->report->code."/?invitation=1")}}">
                                                <i class="entypo-eye pull-right"></i>
                                                <span class="line">
                                                    <strong><b>From: </b>{{$invitation->invitor->name}}</strong>
                                                </span>
                                                <span class="line small">
                                                    {{\Carbon\Carbon::parse($invitation->created_at)->diffForHumans()}}
                                                </span>
                                            </a>
                                        </li>

                                    @empty
                                    @endforelse

                                </ul>
                            </li>
                            {{--<li class="external"><a href="#">See all tasks</a></li>--}}
                        </ul>
                    </li>

                </ul>
            </div> <!-- Raw Links -->
            <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                <ul class="list-inline links-list pull-right">
                    <li class="sep"></li>

                    @if(Auth::guest())
                        <li>
                            <a href="{{url('/login')}}">
                                Sign In <i class="entypo-login right"></i>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{url('/logout')}}">
                                Sign Out <i class="entypo-logout right"></i>
                            </a>
                        </li>
                    @endif


                </ul>
            </div>
        </div>
        <hr/>

        <div class="col-md-offset-7">
            <form action="{{url('/findByCode')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="code" required
                               placeholder="Please enter code here to search">
                        <span class="input-group-btn">
                            <button class="btn btn-blue" type="submit"><i class="entypo-search"></i> </button>
                        </span>
                    </div>

                </div>
            </form>
        </div>
    @yield('content')





    <!-- Footer -->
        <br/><br/>


        <footer class="main" style="background-color:#303641 ;color:white">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{url('images/officer.jpeg')}}" height="100px" width="200px">
                    </div>
                    <div class="col-md-4">
                       <span style="font-size: 15px">
                           To be a World Class Police Service capable of delivering planned,democratic
                        protective and peaceful services up to standards of international best practices.
                       </span>
                    </div>
                    <div class="col-md-4 ">
                        <span class="pull-right"> &copy; 2017 <strong> Citizen Police </strong></span>
                    </div>

                </div>
            </div>

        </footer>
    </div>

</div>
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
<script src="{{asset('js/sweetalert2/dist/sweetalert2.js')}}" id=" "></script>

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
@include('notifications.sweetalert')
@yield('extra-scripts')
<script>

</script>
</body>
</html>