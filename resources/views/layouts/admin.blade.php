<?php

use App\Practitioner;
use App\ProfessionApprover;
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
    if (\Illuminate\Support\Facades\Auth::check()) {
        $user_role = auth()->user()->role_id;
        $user = auth()->user();
        $count = 0;
        if ($user_role == 4) {
            $count = Practitioner::where('registration_officer', 0)->count();
        }

        if ($user_role == 6) {
            $profession_approvers = ProfessionApprover::where('user_id', $user->id)->get();
            foreach ($profession_approvers as $profession_approver) {
                $count = Practitioner::where('registration_officer', 1)
                    ->where('member', 0)
                    ->where('profession_id', $profession_approver->profession_id)
                    ->count();
            }
        }

        if ($user_role == 7) {
            $count = Practitioner::where('registration_officer', 1)
                ->where('member', 1)
                ->where('registrar', 0)
                ->count();

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
            <div style="color:white;padding-left: 9%"><h1 style="text-align: center">Allied Health Practitioners
                    Council</h1></div>

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
                           aria-expanded="false">
                            @if(auth()->check())
                                @if(auth()->user()->unreadNotifications)
                                    ({{auth()->user()->unreadNotifications()->count()}})
                                @endif
                            @endif
                            <i class="ti-email"></i>
                            <div class="notify"><span class="heartbit"></span> <span class="point"></span></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                            <ul>
                                <li>
                                    <a href="{{url('/admin/notification/inbox')}}">
                                        <div class="drop-title">Notifications
                                            @if(auth()->check() )
                                                @if(auth()->user()->unreadNotifications)
                                                    ({{auth()->user()->unreadNotifications()->count()}})
                                                @endif
                                            @endif
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="message-center">
                                        <!-- Message -->
                                        @if(auth()->check() )
                                            @if(auth()->user()->unreadNotifications)
                                                @foreach (auth()->user()->unreadNotifications as $notification)
                                                    <a href="/admin/{{$notification->id}}/read">
                                                        <div class="btn btn-danger btn-circle"><i
                                                                class="fa fa-link"></i>
                                                        </div>
                                                        <div class="mail-contnet">
                                                            <h5>
                                                                @if($notification->data['sender'])
                                                                    {{$notification->data['sender']['name']}}
                                                                @endif
                                                            </h5>
                                                            <span
                                                                class="mail-desc">
                                                         @if($notification->data['comment'] != null){{$notification->data['comment']}}@else{{'No comment on this notification'}}@endif
                                                     </span>

                                                            <span class="time">{{getDifference($notification->created_at,now())}} ago</span>

                                                        </div>

                                                    </a>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center link" href="{{url('/admin/notification/inbox')}}">
                                        <strong>View all
                                            notifications</strong> <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown u-pro">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span
                                 class="hidden-md-down">@if(auth()->check()){{auth()->user()->name}}@endif &nbsp;<i
                                     class="fa fa-angle-down"></i></span> </a>
                        <div class="dropdown-menu dropdown-menu-right animated flipInY">
                            <!-- text-->
                            <a href="javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> My Profile</a>

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


                    <li><a class=" waves-effect waves-dark" href="{{url('/admin/practitioners')}}"
                           aria-expanded="false">
                            <i class="fa fa-user-md"></i><span class="hide-menu">Practitioners
                            </span></a>
                        {{-- <ul aria-expanded="false" class="collapse">
                             <li><a href="{{url('/admin/practitioners')}}"> Practitioners Approved
                                 </a>
                             </li>
                             <li><a href="{{url('/admin/pending_approval')}}">Practitioners
                                     Pending Approval
                                 </a>
                             </li>
                         </ul>--}}
                    </li>

                    <li><a class=" waves-effect waves-dark two-column" href="{{url('admin/students')}}"
                           aria-expanded="false"><i class="fa fa-graduation-cap"></i><span
                                class="hide-menu">Students </span></a>
                    </li>

                    <li>
                        <a class=" waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
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
                                class="fa fa-certificate"></i><span
                                class="hide-menu">Certificate Collection {{--({{countCertificates()}})--}}</span></a>
                    </li>

                    <li><a class="waves-effect waves-dark" href="/admin/practitioners/certificate/pending"
                           aria-expanded="false"><i class="fa fa-certificate"></i><span
                                class="hide-menu"> Out-standings {{--({{countPendingItems()}})--}}</span></a>
                    </li>

                    <li><a class="waves-effect waves-dark" href="/admin/emails"
                           aria-expanded="false"><i class="fa fa-id-card"></i><span
                                class="hide-menu"> Practitioner Contacts </span></a>
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

    <script src="{{asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!--Menu sidebar -->
    <script src="{{asset('dist/js/sidebarmenu.js')}}"></script>

    @yield('plugins-js')

</div>

</body>

</html>

