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

<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">AHPCZ</p>
    </div>
</div>

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
                    <!-- ============================================================== -->
                    <!-- Search -->
                    <!-- ============================================================== -->

                </ul>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->

                <ul class="navbar-nav my-lg-0">
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

                    <li><a class="waves-effect waves-dark" href="#" aria-expanded="false"><i
                                    class="fa fa-bank"></i><span class="hide-menu">Home</span> </a>

                    </li>


                    <li><a class=" waves-effect waves-dark" href="/admin/practitioners" aria-expanded="false">
                            <i class="fa fa-user-md"></i><span class="hide-menu">Practitioners ({{count(auth()->user()->unreadNotifications)}})

                            </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="/admin/practitioner_applications"> <i class="fa fa-file"> </i> Practitioner
                                    Applications
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li><a class=" waves-effect waves-dark two-column" href="javascript:void(0)"
                           aria-expanded="false"><i class="fa fa-graduation-cap"></i><span
                                    class="hide-menu">Students </span></a>
                    </li>

                    <li><a class=" waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                                    class="fa fa-pie-chart"></i><span class="hide-menu">Reports</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="form-basic.php">Practitioner</a></li>
                            <li><a href="form-layout.php">Students</a></li>
                            <li><a href="form-addons.php">Users</a></li>

                        </ul>
                    </li>

                    <li><a class="waves-effect waves-dark" href="/admin/practitioners/certificate/index"
                           aria-expanded="false"><i
                                    class="fa fa-certificate"></i><span class="hide-menu">Certificate Collection</span></a>
                    </li>
                    @can('admin')
                        <li><a class="waves-effect waves-dark" href="/admin/" aria-expanded="false"><i
                                        class="ti-settings"></i><span class="hide-menu">Administration</span></a></li>

                        <li><a class=" waves-effect waves-dark" href="/admin/users" aria-expanded="false"><i
                                        class="fa fa-users"></i><span class="hide-menu">Manage System Users</span></a>

                    @endcan
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <br/>
    <br/>
    <br/>

    <div class="page-wrapper">

        @yield('content')


    </div>

    <footer class="footer">
        ©{{date('Y')}} Allied Health Practitioners Council
    </footer>

</div>

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
<!-- ============================================================== -->

<!-- This page plugins -->
@yield('plugins-js')

</body>

</html>
