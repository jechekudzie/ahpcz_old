@extends('layouts.admin')
@section('title','AHPCZ - Add Application')
@section('plugins-css')
@section('content')

    <div class="container-fluid">
        <div class="row page-titles">

            <div class="col-md-5 align-self-center">
                {{-- @can('admin')
                     <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
                 @endcan--}}
                <a href="/admin/practitioners" class="btn btn-success"></i> All Practitioners</a>
            </div>

            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{$practitioner->title->name.' '.ucwords($practitioner->first_name).' '.ucwords($practitioner->last_name)}} </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if(session('message'))
                        <div class="alert alert-success alert-rounded col-md-6">
                            <i class="fa fa-check-circle"></i> {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-body p-b-0">
                        <h4 class="card-title">{{$practitioner->title->name.' '.ucwords($practitioner->first_name).' '.ucwords($practitioner->last_name)}}</h4>
                        <h4>Registration Number :
                            @if($practitioner->registration_number == null)
                                {{$practitioner->prefix.' (No Registration Number)'}} <a
                                    href="/admin/practitioners/generate_reg/{{$practitioner->profession_id}}/{{$practitioner->id}}">Generate</a>
                            @else
                                {{$practitioner->prefix.str_pad($practitioner->registration_number, 4, '0', STR_PAD_LEFT)}}
                            @endif
                        </h4>
                        <h6 style="font-size: 20px;" class="card-subtitle">Current Status:
                            <code>
                                @if($practitioner->currentRenewal)
                                    @if (($practitioner->currentRenewal->renewal_status_id == 1) && ($practitioner->currentRenewal->cdpoints == 1) && ($practitioner->currentRenewal->placement == 1))
                                        {{'Compliant'}}
                                    @else
                                        {{'Not Compliant'}}
                                    @endif
                                @else
                                    {{'Not Compliant'}}
                                @endif
                            </code> @can('updatePractitioner')<a
                                href="/admin/practitioners/{{$practitioner->id}}/cdpoints"
                                class="btn btn-success btn-xs">Add CPD Points</a>@endcan</h6>
                    </div>
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
                                    class="hidden-xs-down">Documents</span></a>

                        </li>

                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#intern" role="tab"><span
                                    class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                    class="hidden-xs-down">Internship</span></a>
                        </li>

                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#employment_history"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Employment</span></a>
                        </li>

                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#shortfalls"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Shortfalls</span></a>
                        </li>

                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#apps" role="tab"><span
                                    class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                    class="hidden-xs-down">Applications</span></a>

                        </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#renewal"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Payments</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#approval"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Approval</span></a></li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal" role="tabpanel">

                            <div class="row small-spacing">
                                <div class="col-md-4 col-xs-12">
                                    <div class="box-content bordered primary margin-bottom-20">
                                        <div class="profile-avatar">
                                            <img src="{{asset('profiles/user.png')}}" alt="">
                                            <a href="#" class="btn btn-block btn-success"><i
                                                    class="fa fa-envelope"></i> Send Message</a>
                                            <h4 style="text-align: center;">
                                                <strong>{{ucwords($practitioner->first_name).' '.ucwords($practitioner->last_name)}}</strong>
                                            </h4>
                                        </div>
                                        <!-- .profile-avatar -->
                                        <table class="table table-hover no-margin">
                                            <tbody>
                                            <tr>
                                                <td>Approval Status</td>
                                                <td><span class="notice notice-danger">
                                                        @if($practitioner->approval_status  == 1)
                                                            {{'Approved'}}
                                                        @else
                                                            {{'Pending Approval'}}
                                                        @endif
                                                    </span></td>
                                            </tr>
                                            {{--<tr>
                                                <td>User Renewal Status</td>
                                                <td><i class="fa fa-star text-warning"></i> <i
                                                            class="fa fa-star text-warning"></i> <i
                                                            class="fa fa-star text-warning"></i> <i
                                                            class="fa fa-star text-warning"></i> <i
                                                            class="fa fa-star text-warning"></i></td>
                                            </tr>--}}
                                            <tr>
                                                <td>Member Since</td>
                                                <td>{{date('d F Y',strtotime($practitioner->registration_date))}}</td>
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
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Name (s)</strong>
                                            <br>
                                            <p class="text-muted">{{ucwords($practitioner->first_name)}}</p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Last Name</strong>
                                            <br>
                                            <p class="text-muted">{{ucwords($practitioner->last_name)}}</p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Previous Name</strong>
                                            <br>
                                            <p class="text-muted">{{ucwords($practitioner->previous_name)}}</p>
                                        </div>

                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Id Number</strong>
                                            <br>
                                            <p class="text-muted">{{$practitioner->id_number}}</p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Date Of Birth</strong>
                                            <br>
                                            <p class="text-muted">{{ date("d F Y",strtotime($practitioner->dob))}}</p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Gender</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->gender){{$practitioner->gender->name}}@endif</p>
                                        </div>
                                    </div>

                                    <hr/>

                                    <div class="row">

                                        <div class="col-md-4 col-xs-6 b-r"><strong>Profession</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->profession){{$practitioner->profession->name}}@endif</p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Professional Qualification</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->professionalQualification){{$practitioner->professionalQualification->name}}@endif</p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Accredited Institution</strong>
                                            <br>
                                            <p class="text-muted">

                                                    @if($practitioner->qualification_category_id==1)
                                                        @if($practitioner->accreditedInstitution)
                                                            {{$practitioner->accreditedInstitution->name}}
                                                        @endif
                                                    @else
                                                        {{ucwords($practitioner->institution)}}
                                                    @endif

                                            </p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Qualification Category</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->qualificationCategory){{$practitioner->qualificationCategory->name}}@endif</p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Renewal Category</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->renewalCategory){{$practitioner->renewalCategory->name}}@endif</p>
                                        </div>

                                        <div class="col-md-4 col-xs-6 b-r"><strong>Register Category</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->registerCategory){{$practitioner->registerCategory->name}}@endif</p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Registration Number</strong>
                                            <br>
                                            <p class="text-muted">
                                                @if($practitioner->registration_number == null)
                                                    {{$practitioner->prefix.' (No Registration Number)'}} <a
                                                        href="/admin/practitioners/generate_reg/{{$practitioner->profession_id}}/{{$practitioner->id}}">Generate</a>
                                                @else
                                                    {{$practitioner->prefix.str_pad($practitioner->registration_number, 4, '0', STR_PAD_LEFT)}}
                                                @endif
                                            </p>
                                        </div>

                                    </div>
                                    @can('updatePractitioner')
                                        <a href="/admin/practitioners/{{$practitioner->id}}/edit"
                                           class="btn btn-success btn-block">Edit</a>
                                    @endcan
                                </div>
                                <!-- /.col-md-9 col-xs-12 -->
                            </div>

                        </div>
                        <div class="tab-pane p-20" id="contacts" role="tabpanel">
                            <div class="card-body col-md-10">
                                <div class="row">
                                    <div class="col-md-3 col-xs-6 b-r"><strong>Physical address</strong>
                                        <br>
                                        <p class="text-muted">@if($practitioner->contact){{ucwords($practitioner->contact->physical_address)}}@endif</p>
                                    </div>
                                    <div class="col-md-3 col-xs-6 b-r"><strong>Mobile</strong>
                                        <br>
                                        <p class="text-muted">@if($practitioner->contact){{$practitioner->contact->primary_phone}}@endif</p>
                                    </div>
                                    <div class="col-md-3 col-xs-6 b-r"><strong>Secondary</strong>
                                        <br>
                                        <p class="text-muted">@if($practitioner->contact){{$practitioner->contact->secondary_phone}}@endif</p>
                                    </div>
                                    <div class="col-md-3 col-xs-6 b-r"><strong>Email</strong>
                                        <br>
                                        <p class="text-muted">@if($practitioner->contact){{$practitioner->contact->email}}@endif</p>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-3 col-xs-6 b-r"><strong>Nationality</strong>
                                        <br>
                                        <p class="text-muted">@if($practitioner->nationality_id){{$practitioner->nationality->name}}@endif</p>
                                    </div>
                                    <div class="col-md-3 col-xs-6 b-r"><strong>Province</strong>
                                        <br>
                                        <p class="text-muted">@if($practitioner->contact->province_id){{$practitioner->contact->province->name}}@endif</p>
                                    </div>
                                    <div class="col-md-3 col-xs-6 b-r"><strong>City/Location</strong>
                                        <br>
                                        <p class="text-muted">@if($practitioner->contact->city_id){{$practitioner->contact->city->name}}@endif</p>
                                    </div>
                                </div>
                                <hr>
                                @can('updatePractitioner')
                                    @if($practitioner->contact)
                                        <a href="/admin/practitioners/contacts/{{$practitioner->id}}/edit"
                                           class="btn btn-success btn-block">Edit
                                        </a>
                                    @else
                                        <a href="/admin/practitioners/contacts/{{$practitioner->id}}/create"
                                           class="btn btn-success btn-block">Add Contacts
                                        </a>
                                    @endif
                                @endcan
                            </div>
                        </div>
                        <div class="tab-pane p-20" id="qualifications" role="tabpanel">
                            @can('updatePractitioner')
                                <a href="/admin/practitioners/qualifications/{{$practitioner->id}}/create"
                                   class="btn btn-success btn-sm" style="margin-bottom: 10px;">Additional
                                    Qualification</a>
                            @endcan

                            <div class="row small-spacing">
                                <div class="col-md-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-graduation-cap"></i> Professional
                                                    Qualifications
                                                </h4>

                                                <div class="card-content">

                                                    <ul class="dot-list">
                                                        <li>
                                                            <a href="/admin/practitioners/qualifications/{{$practitioner->id}}/showprimary">
                                                                @if($practitioner->qualification_category_id !=null)
                                                                    @if($practitioner->professionalQualification){{$practitioner->professionalQualification->name}}@endif
                                                                @endif</a>

                                                                @if($practitioner->qualification_category_id == 1)
                                                                    <span
                                                                        class="date">@if($practitioner->accreditedInstitution){{$practitioner->accreditedInstitution->name}}@endif
                                                                    </span>
                                                                    <i style="color: black;font-weight: bolder;padding-right: 5px;">Commencement
                                                                        date
                                                                    </i>
                                                                    <span>: {{ date("d F Y",strtotime($practitioner->commencement_date))}}</span>
                                                                    <br/>
                                                                    <i style="color: black;font-weight: bolder;padding-right: 45px;">Completion
                                                                        date
                                                                    </i>
                                                                    <span>: {{ date("d F Y",strtotime($practitioner->completion_date))}}</span>

                                                                @else
                                                                    <span
                                                                        class="date">{{ucwords($practitioner->institution)}}</span>
                                                                    <i style="color: black;font-weight: bolder;padding-right: 5px;">Commencement
                                                                        date
                                                                    </i>
                                                                    <span>: {{ date("d F Y",strtotime($practitioner->commencement_date))}}</span>
                                                                    <br/>
                                                                    <i style="color: black;font-weight: bolder;padding-right: 45px;">Completion
                                                                        date
                                                                    </i>
                                                                    <span>: {{ date("d F Y",strtotime($practitioner->completion_date))}}</span>
                                                                @endif


                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="card-content">
                                                    @if($practitioner->practitionerQualification)
                                                        <ul class="dot-list">
                                                            @foreach($practitioner->practitionerQualification as $practitioner_qualification)
                                                                <li>
                                                                    <a href="/admin/practitioners/qualifications/{{$practitioner_qualification->id}}/show">{{$practitioner_qualification->professionalQualification->name}}</a>
                                                                    @if($practitioner_qualification->qualification_category_id == 1)
                                                                        <span
                                                                            class="date">{{$practitioner_qualification->accreditedInstitution->name}}</span>
                                                                        <span
                                                                            class="date">Commencement date: {{date("d F Y",strtotime($practitioner_qualification->commencement_date))}}</span>
                                                                        <span
                                                                            class="date">Completion date  : {{date("d F Y",strtotime($practitioner_qualification->completion_date))}}</span>

                                                                    @else
                                                                        <span
                                                                            class="date">{{ucwords($practitioner->institution)}}</span>
                                                                        <span
                                                                            class="date">Commencement date: {{date("d F Y",strtotime($practitioner_qualification->commencement_date))}}</span>
                                                                        <span
                                                                            class="date">Completion date  : {{date("d F Y",strtotime($practitioner_qualification->completion_date))}}</span>

                                                                    @endif

                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
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
                            @can('updatePractitioner')
                                <a href="/admin/practitioners/documents/{{$practitioner->id}}/create"
                                   class="btn btn-success btn-sm">Add Documents</a>
                                <br/>
                                <br/>
                            @endcan

                            <div class="row small-spacing">
                                <div class="col-md-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-4 col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-user"> </i> Personal Documents
                                                </h4>
                                                <div class="card-content">
                                                    <ul class="dot-list">
                                                        @foreach($identifications as $identification)
                                                            <li>
                                                                <a href="/{{$identification->path}}"
                                                                   target="_blank">{{$identification->documentCategory->name}}</a>
                                                                <span
                                                                    class="date">{{$identification->documentCategory->group}}</span>
                                                                <span class="">
                        <a href="/admin/practitioners/documents/{{$identification->id}}/edit">
                            <i class="fa fa-pencil"></i> Edit
                        </a>

                    </span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-certificate"></i> Educational
                                                    Documents</h4>
                                                <div class="card-content">
                                                    <ul class="dot-list">
                                                        @foreach($educations as $education)
                                                            <li>
                                                                <a href="/{{$education->path}}"
                                                                   target="_blank">{{$education->documentCategory->name}}</a>
                                                                <span
                                                                    class="date">{{$education->documentCategory->group}}</span>
                                                                <span class=""><a
                                                                        href="/admin/practitioners/documents/{{$education->id}}/edit"><i
                                                                            class="fa fa-pencil"></i>Edit</a> </span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-trophy ico"></i> Professional
                                                    Documents</h4>
                                                <div class="card-content">
                                                    <ul class="dot-list">
                                                        @foreach($professionals as $professional)
                                                            <li>
                                                                <a href="/{{$professional->path}}"
                                                                   target="_blank">{{$professional->documentCategory->name}}</a>
                                                                <span
                                                                    class="date">{{$professional->documentCategory->group}}</span>
                                                                <span class=""><a
                                                                        href="/admin/practitioners/documents/{{$professional->id}}/edit"><i
                                                                            class="fa fa-pencil"></i> Edit</a>
                    </span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-20" id="intern" role="tabpanel">
                            {{-- <a href="/admin/practitioners/documents/{{$practitioner->id}}/create"
                                class="btn btn-success btn-sm">Add Internship</a>--}}

                            <a href="/admin/practitioners/{{$practitioner->id}}/createPlacement"
                               class="btn btn-success btn-sm">Add Placement</a>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive m-t-40">
                                            <h4 class="card-title">Internship Placement</h4>
                                            <table id="placements"
                                                   class="display nowrap table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Period</th>
                                                    <th>Status</th>
                                                    <th>Renewal Date</th>
                                                    <th>view</th>

                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Period</th>
                                                    <th>Status</th>
                                                    <th>Renewal Date</th>
                                                    <th>view</th>

                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @if(count($practitioner->renewals))
                                                    @foreach($practitioner->renewals as $renewal)
                                                        <tr>
                                                            <td>{{$period = $renewal->renewal_period_id}}</td>
                                                            <td>
                                                                @if($renewal->placement == 0)
                                                                    {{'Pending Placement'}}
                                                                @else
                                                                    {{'Up to date'}}
                                                                @endif
                                                            </td>
                                                            <td>{{$renewal->created_at->format('d F Y')}}</td>
                                                            <td>
                                                                @if($practitioner_placement = \App\PractitionerPlacement::where('renewal_period_id',$renewal->renewal_period_id)->first())
                                                                    <a target="_blank"
                                                                       href="/{{$practitioner_placement->path}}">View
                                                                        Placement Letter </a>
                                                                @else
                                                                    {{'Pending placement letter'}}
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="tab-pane p-20" id="employment_history" role="tabpanel">
                            @can('updatePractitioner')
                                @if($practitioner->employer)
                                    <a href="/admin/practitioners/employer/{{$practitioner->employer->id}}/edit"
                                       class="btn btn-success btn-sm">Edit Current Employer
                                    </a>
                                @else
                                    <a href="/admin/practitioners/employer/{{$practitioner->id}}/create"
                                       class="btn btn-success btn-sm">Add Current Employer
                                    </a>
                                @endif
                            @endcan
                            <br/>
                            <br/>
                            <div class="col-md-9 col-xs-12">
                                <div class="box-content card">
                                    <h4 class="box-title"><i class="fa fa-bookmark-o"></i> Current Employer </h4>
                                    <div class="card-content">
                                        <ul class="dot-list">
                                            <div class="row">
                                                <div class="col-md-3 col-xs-6 b-r"><strong>Employer Name</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner->employer){{ucwords($practitioner->employer->name)}}@endif</p>
                                                </div>
                                                <div class="col-md-3 col-xs-6 b-r"><strong>Business Address</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner->employer){{$practitioner->employer->business_address}}@endif</p>
                                                </div>
                                                <div class="col-md-3 col-xs-6 b-r"><strong>Job Title</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner->employer){{$practitioner->employer->job_title}}@endif</p>
                                                </div>

                                                <div class="col-md-3 col-xs-6 b-r"><strong>Commencement date</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner->employer){{ date("d M Y", strtotime($practitioner->employer->commencement_date)) }}@endif</p>
                                                </div>

                                            </div>
                                            <hr/>

                                            <div class="row">

                                                <div class="col-md-3 col-xs-6 b-r"><strong>Contact Person</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner->employer){{$practitioner->employer->contact_person}}@endif</p>
                                                </div>
                                                <div class="col-md-3 col-xs-6"><strong>Email</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner->employer){{$practitioner->employer->email}}@endif</p>
                                                </div>
                                                <div class="col-md-3 col-xs-6"><strong>Phone</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner->employer){{$practitioner->employer->phone}}@endif</p>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-3 col-xs-6 b-r"><strong>Province</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner->employer){{$practitioner->employer->province->name}}@endif</p>
                                                </div>
                                                <div class="col-md-3 col-xs-6"><strong>City/Location</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner->employer){{$practitioner->employer->city->name}}@endif</p>
                                                </div>

                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 col-xs-12">
                                @can('updatePractitioner')
                                    <a href="/admin/practitioners/experience/{{$practitioner->id}}/create"
                                       class="btn btn-success btn-sm">Add Practitioner Experience
                                    </a>
                                    <br/>
                                    <br/>
                                @endcan
                                <div class="box-content card">

                                    <h4 class="box-title"><i class="fa fa-history"></i> Practitioner Experience</h4>
                                    <div class="card-content">
                                        <ul class="dot-list">
                                            @if($practitioner->practitionerExperience)
                                                @foreach($practitioner->practitionerExperience as $experience)
                                                    <li>
                                                        <a href="/admin/practitioners/experience/{{$experience->id}}/show">{{$experience->name}}</a>
                                                        <span class="date">{{$experience->job_title}}</span>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-20" id="shortfalls" role="tabpanel">
                            <div class="table-responsive">

                                <br/>
                                <h4 class="card-title">Requirements and Shortfalls</h4>
                                <table id="practitioner_requirements"
                                       class="display table table-hover table-striped table-bordered"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Requirements</th>
                                        <th>Registration Officer Approval (<span id="officer"></span>)</th>
                                        <th>Member Approval (<span id="member"></span>)</th>

                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Requirements</th>
                                        <th>Registration Officer Approval</th>
                                        <th>Member Approval</th>

                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($practitioner->practitionerRequirements)
                                        @foreach($practitioner->practitionerRequirements as $shortfall)
                                            <tr>
                                                <td>{{$shortfall->requirement->name}}</td>

                                                <td>


                                                    <input type="checkbox" name="status"
                                                           {{$shortfall->status ?'checked':'' }} value="{{$shortfall->id}}"
                                                           class="officer">


                                                </td>
                                                <td>
                                                    <input type="checkbox" name="member_status"
                                                           {{$shortfall->member_status?'checked':'' }} value="{{$shortfall->id}}"
                                                           class="member">

                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane p-20" id="apps" role="tabpanel">

                            <a href="/admin/practitioners/apps/{{$practitioner->id}}/create"
                               class="btn btn-success btn-sm">Create Other Applications
                            </a>

                            <div class="table-responsive">
                                <h4 class="card-title">Other application Documents</h4>
                                <table id="others_apps"
                                       class="display nowrap table table-hover table-striped table-bordered"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Application form</th>
                                        <th>Application Date</th>
                                        <th>Edit</th>
                                        <th>Add Documents</th>
                                        <th>View</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Application form</th>
                                        <th>Application Date</th>
                                        <th>Edit</th>
                                        <th>Add Documents</th>
                                        <th>View</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($practitioner->otherApplications)
                                        @foreach($practitioner->otherApplications as $others_apps)
                                            <tr>
                                                <td>{{$others_apps->paymentItem->name}}</td>
                                                <td>
                                                    {{date("d F Y",strtotime($others_apps->application_date))}}
                                                </td>
                                                <td>
                                                    <a href="/admin/practitioners/apps/{{$others_apps->practitioner->id}}/edit">Edit
                                                        application</a>
                                                </td>
                                                <td>
                                                    <a href="/admin/practitioners/docs/{{$others_apps->id}}/create">Add
                                                        Documents
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="/admin/practitioners/apps/{{$others_apps->id}}/show">View
                                                        Application
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane p-20" id="renewal" role="tabpanel">
                            @can('updatePractitionerPayment')
                                <a href="/admin/practitioners/registration/{{$practitioner->id}}/registration"
                                   class="btn btn-success">REGISTER</a>

                                <a href="/admin/practitioners/renewals/{{$practitioner->id}}/checkPaymentStatusRenewal"
                                   class="btn btn-success"> RENEW
                                </a>
                            @endcan
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-group">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-cyan" role="progressbar"
                                                                 style="width: 100%; height: 6px;"
                                                                 aria-valuenow="100"
                                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Column -->
                                        <!-- Column -->
                                        <div class="card">
                                            <a href="/admin/practitioners/renewals/{{$practitioner->id}}/practitionerBalances">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                        </div>
                                                        <div class="col-12">
                                                            <div class="progress">
                                                                <div class="progress-bar bg-purple" role="progressbar"
                                                                     style="width: 100%; height: 6px;"
                                                                     aria-valuenow="100"
                                                                     aria-valuemin="0" aria-valuemax="100">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>


                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive m-t-40">
                                                <h4 class="card-title">Renewals and Payments</h4>
                                                <table id="renewals"
                                                       class="display nowrap table table-hover table-striped table-bordered"
                                                       cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Period</th>
                                                        <th>Current Balance</th>
                                                        <th>Status</th>
                                                        <th>CPD Points</th>
                                                        <th>Placement</th>
                                                        <th>Renewal Date</th>
                                                        <th>view</th>

                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Period</th>
                                                        <th>Current Balance</th>
                                                        <th>Status</th>
                                                        <th>CPD Points</th>
                                                        <th>Placement</th>
                                                        <th>Renewal Date</th>
                                                        <th>view</th>

                                                    </tr>
                                                    </tfoot>
                                                    <tbody>
                                                    @if(count($practitioner->renewals))
                                                        @foreach($practitioner->renewals as $renewal)
                                                            <tr>
                                                                <td>{{$renewal->renewal_period_id}}</td>
                                                                <td>{{number_format($renewal->payments->sum('balance'),2)}}</td>
                                                                <td>

                                                                    {{$renewal->renewalStatus->name}}
                                                                </td>
                                                                <td>
                                                                    @if($renewal->cdpoints == 0)
                                                                        {{'Pending Cd Points'}}
                                                                    @else
                                                                        {{'Up to date'}}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($renewal->placement == 0)
                                                                        {{'Pending Placement'}}
                                                                    @else
                                                                        {{'Up to date'}}
                                                                    @endif
                                                                </td>
                                                                <td>{{$renewal->created_at->format('d F Y')}}</td>
                                                                <td>
                                                                    <a href="/admin/practitioners/renewals/{{$renewal->id}}/payments_list">Payments </a>

                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="tab-pane p-20" id="approval" role="tabpanel">

                            <div class="col-md-9 col-xs-12">
                                @if($practitioner->approval_status == 0)
                                    <a href="/admin/practitioners/approval/{{$practitioner->id}}/approve"
                                       class="btn btn-success btn-xs"><i class="fa fa-check"></i> Approve Application
                                    </a>

                                    <a href="/admin/practitioners/approval/{{$practitioner->id}}/disapprove"
                                       class="btn btn-success btn-xs"><i class="fa fa-crosshairs"></i> Disapprove
                                        Application
                                    </a>
                                @else
                                    {{'Application approved'}}
                                @endif
                                <br/>
                                <br/>
                                <div class="box-content card">
                                    <h4 class="box-title"><i class="fa fa-bookmark-o"></i> Application Comments </h4>
                                    <div class="card-content">
                                        <ul class="dot-list">
                                            @if(count(auth()->user()->unreadNotifications))
                                                @foreach (auth()->user()->unreadNotifications as $notification)
                                                    @if ($practitioner->id == $notification->data['id'])
                                                        <li>
                                                            {{--<a href="/admin/practitioners/read/{{$practitioner->id}}/{{$notification->id}}">Mark
                                                                As Read</a>--}}
                                                            <span
                                                                class="date">@if($notification->data['comment'] != null){{$notification->data['comment']}}@else{{'No comment on this notification'}}@endif</span>
                                                        </li>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @stop
    </div>


@section('plugins-js')

    <!-- This is data table -->
    <script src="{{asset('assets/node_modules/datatables/jquery.dataTables.min.js')}}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <script>
        $('#renewals').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $('#placements').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $('#profession_practitioners').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $('#practitioner_requirements').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            pageLength: 25
        });

        $('#others_apps').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });


        //shortfalls
        $(document).ready(function () {
            $(".officer").click(function () {
                var practitionerRequirement = $(this).val();

                $.ajax
                ({
                    type: "get",
                    url: "/admin/submit_requirements/" + practitionerRequirement,
                    data: practitionerRequirement,
                    cache: false,
                    success: function (data) {
                        $("#officer").html(data);
                    }
                });
            });

        });

        $(document).ready(function () {
            $(".member").click(function () {
                var practitionerRequirement = $(this).val();

                $.ajax
                ({
                    type: "get",
                    url: "/admin/submit_requirements/" + practitionerRequirement + "/member",
                    data: practitionerRequirement,
                    cache: false,
                    success: function (data) {
                        $("#member").html(data);
                    }
                });
            });

        });


    </script>
@endsection

