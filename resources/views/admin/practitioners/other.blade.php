@extends('layouts.admin')
@section('title','AHPCZ - Create Nationality')
@section('plugins-css')

@endsection

@section('content')
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
                                        class="hidden-xs-down">Contact Details</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#qualifications"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Professional Qualification</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#documents" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                        class="hidden-xs-down">Documents</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#current_employment"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Current Employment</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#previous_employment"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Employment History</span></a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#renewal"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Payments</span></a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table color-table success-table">
                                                    <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Previous Name</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{$practitioner->title->name}}</td>
                                                        <td>{{$practitioner->first_name}}</td>
                                                        <td>{{$practitioner->last_name}}</td>
                                                        <td>@if($practitioner->previous)
                                                                {{$practitioner->previous_name}}
                                                            @else
                                                                {{'No previous names'}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table color-table success-table">
                                                    <thead>
                                                    <tr>
                                                        <th>Gender</th>
                                                        <th>Marital Status</th>
                                                        <th>Date Of Birth</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{$practitioner->gender->name}}</td>
                                                        <td>{{$practitioner->maritalStatus->name}}</td>
                                                        <td>{{$practitioner->dob}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table color-table success-table">
                                                    <thead>
                                                    <tr>
                                                        <th>Nationality</th>
                                                        <th>Identification Number</th>
                                                        <th>Province</th>
                                                        <th>City/Location</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{$practitioner->nationality->name}}</td>
                                                        <td>{{$practitioner->id_number}}</td>
                                                        <td>{{$practitioner->province->name}}</td>
                                                        <td>{{$practitioner->city->name}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table color-table success-table">
                                                    <thead>
                                                    <tr>
                                                        <th>Profession</th>
                                                        <th>Qualification Type</th>
                                                        <th>Renewal Category</th>
                                                        <th>Payment Method</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{$practitioner->profession->name}}</td>
                                                        <td>{{$practitioner->qualificationCategory->name}}</td>
                                                        <td>{{$practitioner->renewalCategory->name}}</td>
                                                        <td>{{$practitioner->paymentMethod->name}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <a href="/admin/practitioners/{{$practitioner->id}}/edit" class="btn btn-primary btn-block">Edit</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane  p-20" id="contacts" role="tabpanel">2</div>
                        <div class="tab-pane p-20" id="qualifications" role="tabpanel">3</div>
                        <div class="tab-pane p-20" id="documents" role="tabpanel">4</div>
                        <div class="tab-pane p-20" id="current_employment" role="tabpanel">5</div>
                        <div class="tab-pane p-20" id="previous_employment" role="tabpanel">6</div>
                        <div class="tab-pane p-20" id="renewal" role="tabpanel">7</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('plugins-js')

@endsection

