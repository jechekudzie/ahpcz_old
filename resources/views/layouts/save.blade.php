<?php

use App\Practitioner;
use App\Renewal;
use Carbon\CarbonInterval;

function getDifference($created_at, $now)
{
    $days = $created_at->diffInDays($now);
    $hours = $created_at->diffInHours($now->subDays($days));
    $minutes = $created_at->diffInMinutes($now->subHours($hours));
    $seconds = $created_at->diffInSeconds($now->subMinutes($minutes));

    return CarbonInterval::days($days)->hours($hours)->minutes($minutes)->seconds($seconds)->forHumans();
}

function countTasks()
{
    $user_role = auth()->user()->role_id;
    $count = 0;
    if ($user_role == 4) {
        $count = Practitioner::whereRegistration_officerOrRegistration_officerAndAccountantAndMember(0, 1, 1, 1)->count();
    }

    if ($user_role == 5) {
        $count = Practitioner::whereRegistration_officerAndAccountant(1, 0)->count();

    }

    if ($user_role == 6) {
        $count = Practitioner::whereRegistration_officerAndAccountantAndMember(1, 1, 0)->count();

    }

    if ($user_role == 7) {
        $count = Practitioner::whereRegistration_officerAndAccountantAndMemberAndRegistrar(2, 1, 1, 0)->count();

    }

    if ($user_role == 3) {

        $count = 0;
    }
    if ($user_role == 2) {

        $count = 0;
    }
    if ($user_role == 1) {

        $count = 0;
    }

    echo $count;
}

function countCertificates()
{

    $current_year = date('Y');
    $no_shortfalls = [];
    $percentage = 0;
    $count_certificates = 0;
    $complete_renewals = Renewal::where('renewal_period_id', '>=', $current_year)->get();
    foreach ($complete_renewals as $complete_renewal) {

        $total = count($complete_renewal->practitioner->practitionerRequirements);
        $checked = count($complete_renewal->practitioner->practitionerRequirements->where('status', '1'));
        $percentage = ($checked / $total) * 100;

        if ($percentage == 100 && ($complete_renewal->renewal_status_id == 1) && ($complete_renewal->cdpoints == 1) && ($complete_renewal->placement == 1)) {
            $no_shortfalls[] = array('shortfall' => $percentage, 'renewal_id' => $complete_renewal->id);
        }

    }

    $count_certificates = count($no_shortfalls);

    echo $count_certificates;
}


function countPendingItems()
{
    $year = date('Y');
    $shortfalls = [];
    $percentage = 0;
    $count_pending = 0;
    $renewals = Renewal::where('renewal_period_id', '>=', $year)->get();
    foreach ($renewals as $renewal) {

        $total = count($renewal->practitioner->practitionerRequirements);
        $checked = count($renewal->practitioner->practitionerRequirements->where('status', '1'));
        $percentage = ($checked / $total) * 100;

        if ($percentage < 100 || ($renewal->renewal_status_id != 1) || ($renewal->cdpoints == 0) || ($renewal->placement == 0)) {
            $shortfalls[] = array('shortfall' => $percentage, 'renewal_id' => $renewal->id);
        }

    }
    $count_pending = count($shortfalls);

    echo $count_pending;
}

?>

    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Allied Health Practitioners Council</title>
    <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{asset('dist/css/pages/dashboard1.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style-horizontal.min.css')}}">

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    @yield('plugins-css')

</head>

<body class="horizontal-nav skin-megna fixed-layout">


<div id="main-wrapper">

    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-header">
                <a class="navbar-brand" href="/">
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="hidden-sm-down">
                         <!-- dark Logo text -->

                         {{--<img src="{{asset('profiles/ahpcz.png')}}" alt="homepage" class="dark-logo"/>--}}
                         <img style="background-color: white;" src="{{asset('profiles/ahpcz.png')}}" alt="homepage"
                              class="light-logo"/>


                    </span>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div style="color:white;padding-left: 9%"><h1>Allied Health Practitioners Council</h1></div>

            <div class="navbar-collapse">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto">
                    <!-- This is  -->
                    <li class="nav-item"><a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark"
                                            href="javascript:void(0)"><i class="ti-menu"></i></a></li>
                    <li class="nav-item"><a class="nav-link sidebartoggler d-none waves-effect waves-dark"
                                            href="javascript:void(0)"><i class="icon-menu"></i></a></li>

                </ul>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->

                <ul class="navbar-nav my-lg-0">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">@if(auth()->user()->unreadNotifications){{count(auth()->user()->unreadNotifications)}}@endif
                            <i class="ti-email"></i>
                            <div class="notify"><span class="heartbit"></span> <span class="point"></span></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                            <ul>
                                <li>
                                    <a href="/admin/notification/inbox">
                                        <div class="drop-title">Notifications
                                            @if(auth()->user()->unreadNotifications->count() > 0 ){{count(auth()->user()->unreadNotifications)}}@endif
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="message-center">
                                        <!-- Message -->
                                        @if(auth()->user()->unreadNotifications->count() > 0)
                                            @foreach (auth()->user()->unreadNotifications as $notification)
                                                <a href="/admin/{{$notification->id}}/read">
                                                    <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i>
                                                    </div>
                                                    <div class="mail-contnet">
                                                        <h5>{{$notification->data['sender']['name']}}</h5> <span
                                                            class="mail-desc">
                                                        @if($notification->data['comment'] != null){{$notification->data['comment']}}@else{{'No comment on this notification'}}@endif
                                                    </span>

                                                        <span class="time">{{getDifference($notification->created_at,now())}} ago</span>

                                                    </div>

                                                </a>
                                            @endforeach
                                        @endif

                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center link" href="{{url('/admin/notification/inbox')}}">
                                        <strong>View all
                                            notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown u-pro">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span
                                 class="hidden-md-down">{{auth()->user()->name}} &nbsp;<i
                                     class="fa fa-angle-down"></i></span> </a>
                        <div class="dropdown-menu dropdown-menu-right animated flipInY">
                            <!-- text-->
                            <a href="javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                            <!-- text-->
                            {{--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
                            <!-- text-->
                            <a href="javascript:void(0)" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                            <!-- text-->--}}
                            <div class="dropdown-divider"></div>
                            <!-- text-->
                            <a href="/password/reset" class="dropdown-item"><i class="ti-settings"></i> Password
                                Setting</a>
                            <!-- text-->
                            <div class="dropdown-divider"></div>
                            <!-- text-->
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                               class="dropdown-item"><i class="fa fa-power-off"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                            <!-- text-->
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    </header>

    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">

                    <li><a class="waves-effect waves-dark" href="/" aria-expanded="false"><i
                                class="fa fa-bank"></i><span class="hide-menu">Home</span> </a>

                    </li>


                    <li><a class=" waves-effect waves-dark" href="/admin/practitioners" aria-expanded="false">
                            <i class="fa fa-user-md"></i><span class="hide-menu">Practitioners

                            </span></a>
                        {{--<ul aria-expanded="false" class="collapse">
                            <li><a href="/admin/practitioner_applications"> <i class="fa fa-file"> </i> Practitioner
                                    Applications
                                </a>
                            </li>
                        </ul>--}}
                    </li>

                    <li><a class=" waves-effect waves-dark two-column" href="javascript:void(0)"
                           aria-expanded="false"><i class="fa fa-graduation-cap"></i><span
                                class="hide-menu">Students </span></a>
                    </li>

                    <li><a class=" waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                                class="fa fa-pie-chart"></i><span class="hide-menu">Reports</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="#">Practitioner</a></li>
                            <li><a href="#">Students</a></li>
                            <li><a href="#">Users</a></li>

                        </ul>
                    </li>

                    <li><a class="waves-effect waves-dark" href="/admin/practitioner_applications"
                           aria-expanded="false"><i
                                class="fa fa-tasks"></i><span
                                class="hide-menu">My Tasks ({{countTasks()}})</span></a>
                    </li>

                    <li><a class="waves-effect waves-dark" href="/admin/practitioners/certificate/index"
                           aria-expanded="false"><i
                                class="fa fa-certificate"></i><span class="hide-menu">Certificate Collection ({{countCertificates()}})</span></a>
                    </li>

                    <li><a class="waves-effect waves-dark" href="/admin/practitioners/certificate/pending"
                           aria-expanded="false"><i class="fa fa-certificate"></i><span class="hide-menu"> Out-standings ({{countPendingItems()}})</span></a>
                    </li>
                    @can('admin')
                        <li><a class="waves-effect waves-dark" href="/admin/" aria-expanded="false"><i
                                    class="ti-settings"></i><span class="hide-menu">Administration</span></a>
                        </li>


                    @endcan
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <br/>
    <br/>

    <div class="page-wrapper">

        @yield('content')


    </div>

    <footer class="footer">
        ©{{date('Y')}} Allied Health Practitioners Council
    </footer>

    <script src="{{asset('assets/node_modules/jquery/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('dist/js/dashboard1.js')}}"></script>

    <script src="{{asset('assets/node_modules/popper/popper.min.js')}}"></script>
    <script src="{{asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('dist/js/perfect-scrollbar.jquery.min.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('dist/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('dist/js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('dist/js/custom.min.js')}}"></script>

    @yield('plugins-js')
</div>
</body>

</html>
