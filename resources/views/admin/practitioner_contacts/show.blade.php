@extends('layouts.admin')
@section('title','AHPCZ - Create Nationality')
@section('plugins-css')

@endsection

@section('content')
    <link rel="stylesheet" href="{{asset('css/style-horizontal.min.css')}}">

    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <a href="/admin/practitioners" class="btn btn-success"></i> All Practitioners</a>

                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration</a>

            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">{{$practitioner->title->name.' '.$practitioner->first_name.' '.$practitioner->last_name}} </li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">{{$practitioner->title->name.' '.$practitioner->first_name.' '.$practitioner->last_name}}</h4>
                        <h6 class="card-subtitle">Current Status <code>Owing</code></h6></div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#personal"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span>
                                <span class="hidden-xs-down">Personal Details</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contacts" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                        class="hidden-xs-down">Contact</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#qualifications"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Qualification</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#documents" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                        class="hidden-xs-down">Documents</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#current_employment"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Current Employment</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#employment_history"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Employment History</span></a>
                        </li>

                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#disciplinary"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down"> Disciplinary</span></a>
                        </li>

                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#shortfalls"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Shortfalls</span></a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#renewal"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Payments</span></a></li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal" role="tabpanel">

                            <div class="row small-spacing">
                                <div class="col-md-4 col-xs-12">
                                    <div class="box-content bordered primary margin-bottom-20">
                                        <div class="profile-avatar">
                                            <img src="{{asset('profiles/logo_new.png')}}" alt="">
                                            <a href="#" class="btn btn-block btn-success"><i
                                                        class="fa fa-envelope"></i> Send Message</a>
                                            <h4 style="text-align: center;">
                                                <strong>{{$practitioner->first_name.' '.$practitioner->last_name}}</strong>
                                            </h4>
                                        </div>
                                        <!-- .profile-avatar -->
                                        <table class="table table-hover no-margin">
                                            <tbody>
                                            <tr>
                                                <td>Status</td>
                                                <td><span class="notice notice-danger">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td>User Rating</td>
                                                <td><i class="fa fa-star text-warning"></i> <i
                                                            class="fa fa-star text-warning"></i> <i
                                                            class="fa fa-star text-warning"></i> <i
                                                            class="fa fa-star text-warning"></i> <i
                                                            class="fa fa-star text-warning"></i></td>
                                            </tr>
                                            <tr>
                                                <td>Member Since</td>
                                                <td>{{$practitioner->created_at->format('d M Y')}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-content bordered -->

                                    <!-- /.box-content -->
                                </div>
                                <!-- /.col-md-3 col-xs-12 -->
                                <div class="col-md-8 col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-user ico"></i>About</h4>
                                                <!-- /.box-title -->
                                                <div class="dropdown js__drop_down">
                                                    <a href="#"
                                                       class="dropdown-icon glyphicon glyphicon-option-vertical js__drop_down_button"></a>
                                                    <ul class="sub-menu">
                                                        <li><a href="#">Action</a></li>
                                                        <li><a href="#">Another action</a></li>
                                                        <li><a href="#">Something else there</a></li>
                                                        <li class="split"></li>
                                                        <li><a href="#">Separated link</a></li>
                                                    </ul>
                                                    <!-- /.sub-menu -->
                                                </div>
                                                <!-- /.dropdown js__dropdown -->
                                                <div class="card-content">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>First
                                                                        Name:</label></div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->first_name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Last Name:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->last_name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Previous
                                                                        Name:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->previous_name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Dirt of
                                                                        Birth:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->dob}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Identification
                                                                        Number:</label></div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->id_number}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Gender:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->gender->name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.card-content -->
                                            </div>
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-user ico"></i></h4>
                                                <!-- /.box-title -->

                                                <!-- /.dropdown js__dropdown -->
                                                <div class="card-content">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5">
                                                                    <label>Nationality:</label></div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->nationality->name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Current
                                                                        Province:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->province->name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Current
                                                                        City/Location:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->city->name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->

                                                        <!-- /.col-md-6 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.card-content -->
                                            </div>
                                            <!-- /.box-content card -->
                                        </div>
                                        <!-- /.col-md-12 -->
                                        <a href="/admin/practitioners/{{$practitioner->id}}/edit"
                                           class="btn btn-success btn-block">Edit</a>

                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-9 col-xs-12 -->
                            </div>
                            <!-- /.row small-spacing -->
                            <!-- /.main-content -->

                        </div>

                        <div class="tab-pane  p-20" id="contacts" role="tabpanel">
                            <div class="row small-spacing">
                                <div class="col-md-8 col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-user ico"></i>About</h4>
                                                <!-- /.box-title -->
                                                <div class="dropdown js__drop_down">
                                                    <a href="#"
                                                       class="dropdown-icon glyphicon glyphicon-option-vertical js__drop_down_button"></a>
                                                    <ul class="sub-menu">
                                                        <li><a href="#">Action</a></li>
                                                        <li><a href="#">Another action</a></li>
                                                        <li><a href="#">Something else there</a></li>
                                                        <li class="split"></li>
                                                        <li><a href="#">Separated link</a></li>
                                                    </ul>
                                                    <!-- /.sub-menu -->
                                                </div>
                                                <!-- /.dropdown js__dropdown -->
                                                <div class="card-content">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>First
                                                                        Name:</label></div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->first_name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Last Name:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->last_name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Previous
                                                                        Name:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->previous_name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Dirt of
                                                                        Birth:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->dob}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Identification
                                                                        Number:</label></div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->id_number}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Gender:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->gender->name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.card-content -->
                                            </div>
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-user ico"></i></h4>
                                                <!-- /.box-title -->

                                                <!-- /.dropdown js__dropdown -->
                                                <div class="card-content">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5">
                                                                    <label>Nationality:</label></div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->nationality->name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Current
                                                                        Province:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->province->name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-5"><label>Current
                                                                        City/Location:</label>
                                                                </div>
                                                                <!-- /.col-xs-5 -->
                                                                <div class="col-md-7 col-xs-7">{{$practitioner->city->name}}</div>
                                                                <!-- /.col-xs-7 -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.col-md-6 -->
                                                        <a href="/admin/practitioner/contacts/{{$practitioner->id}}/add" class="btn btn-success btn-block">Add</a>                                                        <!-- /.col-md-6 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.card-content -->
                                            </div>
                                            <!-- /.box-content card -->
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-9 col-xs-12 -->
                            </div>
                        </div>


                        <div class="tab-pane p-20" id="qualifications" role="tabpanel">
                            <div class="row small-spacing">
                                <div class="col-md-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-file-text ico"></i>
                                                    Experience</h4>
                                                <!-- /.box-title -->
                                                <!-- /.dropdown js__dropdown -->
                                                <div class="card-content">
                                                    <ul class="dot-list">
                                                        <li><a href="#">Owner</a> at <a
                                                                    href="#">NinjaTeam</a>.<span class="date">March 2013 ~ Now</span>
                                                        </li>
                                                        <li><a href="#">CEO</a> at <a href="#">CEO
                                                                Company</a>.<span class="date"> March 2011 ~ February 2013</span>
                                                        </li>
                                                        <li><a href="#">Web Designer</a> at <a href="#">Web
                                                                Design Company Ltd.</a>.<span class="date"> March 2010 ~ February 2011</span>
                                                        </li>
                                                        <li><a href="#">Sales</a> at <a href="#">Sales Company
                                                                Ltd.</a>.<span
                                                                    class="date"> March 2009 ~ February 2010</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- /.card-content -->
                                            </div>
                                            <!-- /.box-content card -->
                                        </div>
                                        <!-- /.col-md-6 -->
                                        <div class="col-md-6 col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-trophy ico"></i> Education
                                                </h4>
                                                <!-- /.box-title -->
                                                <!-- /.dropdown js__dropdown -->
                                                <div class="card-content">
                                                    <ul class="dot-list">
                                                        <li><a href="#">Students</a> at <a href="#">CEO
                                                                Education</a>.<span class="date">March 2013 ~ Now</span>
                                                        </li>
                                                        <li><a href="#">Students</a> at <a href="#">Web Design
                                                                Education</a>.<span class="date">March 2011 ~ February 2013</span>
                                                        </li>
                                                        <li><a href="#">Students</a> at <a href="#">Sales
                                                                School</a>.<span class="date"> March 2010 ~ February 2011</span>
                                                        </li>
                                                        <li><a href="#">Students</a> at <a href="#">High
                                                                School</a>.<span class="date"> March 2009 ~ February 2010</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- /.card-content -->
                                            </div>
                                            <!-- /.box-content card -->
                                        </div>
                                        <!-- /.col-md-6 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-9 col-xs-12 -->
                            </div>
                        </div>
                        <div class="tab-pane p-20" id="documents" role="tabpanel">
                            <div class="row small-spacing">
                                <div class="col-md-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-4 col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-file-text ico"></i>
                                                    Experience</h4>
                                                <!-- /.box-title -->
                                                <!-- /.dropdown js__dropdown -->
                                                <div class="card-content">
                                                    <ul class="dot-list">
                                                        <li><a href="#">Owner</a> at <a
                                                                    href="#">NinjaTeam</a>.<span class="date">March 2013 ~ Now</span>
                                                        </li>
                                                        <li><a href="#">CEO</a> at <a href="#">CEO
                                                                Company</a>.<span class="date"> March 2011 ~ February 2013</span>
                                                        </li>
                                                        <li><a href="#">Web Designer</a> at <a href="#">Web
                                                                Design Company Ltd.</a>.<span class="date"> March 2010 ~ February 2011</span>
                                                        </li>
                                                        <li><a href="#">Sales</a> at <a href="#">Sales Company
                                                                Ltd.</a>.<span
                                                                    class="date"> March 2009 ~ February 2010</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- /.card-content -->
                                            </div>
                                            <!-- /.box-content card -->
                                        </div>
                                        <!-- /.col-md-6 -->
                                        <div class="col-md-4 col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-trophy ico"></i> Education
                                                </h4>
                                                <!-- /.box-title -->
                                                <!-- /.dropdown js__dropdown -->
                                                <div class="card-content">
                                                    <ul class="dot-list">
                                                        <li><a href="#">Students</a> at <a href="#">CEO
                                                                Education</a>.<span class="date">March 2013 ~ Now</span>
                                                        </li>
                                                        <li><a href="#">Students</a> at <a href="#">Web Design
                                                                Education</a>.<span class="date">March 2011 ~ February 2013</span>
                                                        </li>
                                                        <li><a href="#">Students</a> at <a href="#">Sales
                                                                School</a>.<span class="date"> March 2010 ~ February 2011</span>
                                                        </li>
                                                        <li><a href="#">Students</a> at <a href="#">High
                                                                School</a>.<span class="date"> March 2009 ~ February 2010</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- /.card-content -->
                                            </div>
                                            <!-- /.box-content card -->
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-trophy ico"></i> Education
                                                </h4>
                                                <!-- /.box-title -->
                                                <!-- /.dropdown js__dropdown -->
                                                <div class="card-content">
                                                    <ul class="dot-list">
                                                        <li><a href="#">Students</a> at <a href="#">CEO
                                                                Education</a>.<span class="date">March 2013 ~ Now</span>
                                                        </li>
                                                        <li><a href="#">Students</a> at <a href="#">Web Design
                                                                Education</a>.<span class="date">March 2011 ~ February 2013</span>
                                                        </li>
                                                        <li><a href="#">Students</a> at <a href="#">Sales
                                                                School</a>.<span class="date"> March 2010 ~ February 2011</span>
                                                        </li>
                                                        <li><a href="#">Students</a> at <a href="#">High
                                                                School</a>.<span class="date"> March 2009 ~ February 2010</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- /.card-content -->
                                            </div>
                                            <!-- /.box-content card -->
                                        </div>
                                        <!-- /.col-md-6 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-9 col-xs-12 -->
                            </div>

                        </div>
                        <div class="tab-pane p-20" id="current_employment" role="tabpanel">5</div>
                        <div class="tab-pane p-20" id="employment_history" role="tabpanel">6</div>
                        <div class="tab-pane p-20" id="disciplinary" role="tabpanel">6D</div>
                        <div class="tab-pane p-20" id="shortfalls" role="tabpanel">Shortfalls</div>
                        <div class="tab-pane p-20" id="renewal" role="tabpanel">7</div>
                    </div>
                </div>
            </div>
        </div>


    </div>




@endsection

@section('plugins-js')

@endsection

