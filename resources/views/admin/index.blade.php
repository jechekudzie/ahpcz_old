@extends('layouts.admin')
@section('title','AHPCZ - Administration')
@section('plugins-css')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Admin Dashboard</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Admin Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- professions, qualification category and registers -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <!-- column -->
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">PROFESSIONS</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-info"><i class="icon-people"></i></span>
                                    <a href="/admin/professions" class="link display-5 ml-auto">{{$professions}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/professions" class="btn btn-info btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">QUALIFICATION CATEGORIES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-info"><i class="fa fa-compass"></i></span>
                                    <a href="/admin/qualification_categories" class="link display-5 ml-auto">{{$qualification_categories}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/qualification_categories" class="btn btn-info btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">REGISTERS</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-info"><i class="fa fa-registered"></i></span>
                                    <a href="/admin/register_categories" class="link display-5 ml-auto">{{$register_categories}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/register_categories" class="btn btn-info btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>
            </div>

        </div>


        <!-- renewal category, renewal statuses, operational statuses -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <!-- column -->
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">RENEWAL CATEGORIES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-success"><i class="fa fa-users"></i></span>
                                    <a href="/admin/renewal_categories" class="link display-5 ml-auto">{{$renewal_categories}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/renewal_categories" class="btn btn-success btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">RENEWAL STATUSES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-success"><i class="fa fa-hourglass-half"></i></span>
                                    <a href="/admin/renewal_statuses" class="link display-5 ml-auto">{{$renewal_statuses}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/renewal_statuses" class="btn btn-success btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">OPERATIONAL STATUSES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-success"><i class="fa fa-ban"></i></span>
                                    <a href="/admin/operational_statuses" class="link display-5 ml-auto">{{$operational_statuses}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/operational_statuses" class="btn btn-success btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>
            </div>

        </div>

        <!-- Renewal, Registration, Student Registration Fees -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <!-- column -->
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">PRACTITIONER REGISTRATION FEES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-primary"><i class="fa fa-money"></i></span>
                                    <a href="/admin/registration_fees" class="link display-5 ml-auto">{{$registration_fees}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/registration_fees" class="btn btn-primary btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">PRACTITIONER RENEWAL FEES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-primary"><i class="fa fa-usd"></i></span>
                                    <a href="/admin/renewal_fees" class="link display-5 ml-auto">{{$renewal_fees}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/renewal_fees" class="btn btn-primary btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">STUDENT REGISTRATION FEES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-primary"><i class="fa fa-credit-card"></i></span>
                                    <a href="/admin/student_registration_fees" class="link display-5 ml-auto">{{$student_registration_fees}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/student_registration_fees" class="btn btn-primary btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>
            </div>

        </div>

        <!-- Nationalities, cities and provinces  -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <!-- column -->
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">NATIONALITIES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-danger"><i class="fa fa-globe"></i></span>
                                    <a href="/admin/nationalities" class="link display-5 ml-auto">{{$nationalities}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/nationalities" class="btn btn-danger btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">PROVINCES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-danger"><i class="fa fa-map-marker"></i></span>
                                    <a href="/admin/provinces" class="link display-5 ml-auto">{{$provinces}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/provinces" class="btn btn-danger btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">CITIES </h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-danger"><i class="fa fa-location-arrow"></i></span>
                                    <a href="/admin/cities" class="link display-5 ml-auto">{{$cities}}</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="/admin/cities" class="btn btn-danger btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>
            </div>

        </div>
        <!-- Accredited institutions and profession accreditation  -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <!-- column -->
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Accreditation</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-default"><i class="fa fa-graduation-cap"></i></span>
                                    <a href="/admin/accredited_institutions" class="link display-5 ml-auto"></a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a style="background-color: black;color: white;" href="/admin/accredited_institutions" class="btn btn-default btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Qualification levels</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-default"><i class="fa fa-certificate"></i></span>
                                    <a href="/admin/qualification_levels" class="link display-5 ml-auto"></a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a style="background-color: black;color: white;" href="/admin/qualification_levels" class="btn btn-default btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Committee Members</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-default"><i class="fa fa-check-circle"></i></span>
                                    <a href="/admin/profession_approvers" class="link display-5 ml-auto"></a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a style="background-color: black;color: white;" href="/admin/profession_approvers" class="btn btn-default btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>
            </div>

        </div>


        <!-- Identifications -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <!-- column -->
                <div class="col-sm-6 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Payment Items</h5>
                            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                <span class="display-5 text-warning"><i class="fa fa-money"></i></span>
                                <a href="/admin/payment_items" class="link display-5 ml-auto">3</a>
                            </div>
                            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                <a href="/admin/payment_items" class="btn btn-warning btn-block"><i class="fa fa-pencil"></i> Manage</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- column -->
            </div>
        </div>
    </div>

        <!-- Identifications -->
        {{--<div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <!-- column -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">TITLES CATEGORIES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-warning"><i class="fa fa-male"></i><i class="fa fa-female"></i></span>
                                    <a href="javscript:void(0)" class="link display-5 ml-auto">3</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="javscript:void(0)" class="btn btn-warning btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">GENDER CATEGORIES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-warning"><i class="fa fa-venus-mars"></i></span>
                                    <a href="javscript:void(0)" class="link display-5 ml-auto">3</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="javscript:void(0)" class="btn btn-warning btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">MARITAL STATUSES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-warning"><i class="fa fa-circle-o"></i></span>
                                    <a href="javscript:void(0)" class="link display-5 ml-auto">23</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="javscript:void(0)" class="btn btn-warning btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">IDENTIFICATION CATEGORIES</h5>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <span class="display-5 text-warning"><i class="fa fa-id-card"></i></span>
                                    <a href="javscript:void(0)" class="link display-5 ml-auto">23</a>
                                </div>
                                <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                    <a href="javscript:void(0)" class="btn btn-warning btn-block"><i class="fa fa-pencil"></i> Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>
            </div>

        </div>--}}



    </div>
@endsection

@section('plugins-js')

@endsection
