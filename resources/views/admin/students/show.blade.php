@extends('layouts.admin')
@section('title','AHPCZ - Add Application')
@section('plugins-css')@stop
@section('content')

    <div class="container-fluid">
        <div class="row page-titles">

            <div class="col-md-5 align-self-center">
                {{-- @can('admin')
                     <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
                 @endcan--}}
                <a href="/admin/students" class="btn btn-success"> All Students</a>
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
                    <div class="card-body p-b-0">
                        <h4 class="card-title">{{$practitioner->title->name.' '.ucwords($practitioner->first_name).' '.ucwords($practitioner->last_name)}}</h4>
                        <h4>Student Number :
                            @if($practitioner->student_number == null)
                                {{'A/S (No Registration Number)'}} <a
                                    href="/admin/students/generate_reg/{{$practitioner
                                    ->id}}">Generate</a>
                            @else
                                {{str_pad($practitioner->student_number, 4, '0', STR_PAD_LEFT)}}
                            @endif
                        </h4>
                        <h6 style="font-size: 20px;" class="card-subtitle">Current Status:
                            <code>
                                @if($practitioner->currentRenewal)
                                    {{'Compliant'}}
                                @else
                                    {{'Not Compliant'}}
                                @endif
                            </code> @can('updatePractitioner')<a
                                href="/admin/practitioners/{{$practitioner->id}}/cdpoints"
                                class="btn btn-success btn-xs">Add CPD Points</a>@endcan</h6>
                        @if(session('message'))
                            <div class="alert alert-success alert-rounded col-md-12">
                                <i class="fa fa-check-circle"></i> {{ session('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
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

                        @can('requirementChecklist')
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#shortfalls"
                                                    role="tab"><span class="hidden-sm-up"><i
                                            class="ti-email"></i></span>
                                    <span class="hidden-xs-down">Requirements Checklist</span></a>
                            </li>
                        @endcan
                        @can('updatePractitioner')
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#apps" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                        class="hidden-xs-down">Request For Upgrade</span></a>

                            </li>
                        @endcan
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#renewal"
                                                role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span>
                                <span class="hidden-xs-down">Payments</span></a></li>
                        @can('registrarApproval')
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#approval"
                                                    role="tab"><span class="hidden-sm-up"><i
                                            class="ti-email"></i></span>
                                    <span class="hidden-xs-down">Approval and Sign Off</span></a></li>
                        @endcan

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Start Of Personal details tab -->
                        <div class="tab-pane active" id="personal" role="tabpanel">

                            <div class="row small-spacing">
                                <div class="col-md-4 col-xs-12">
                                    <div class="box-content bordered primary margin-bottom-20">
                                        <div class="profile-avatar">
                                            <img src="{{asset('profiles/user.png')}}" alt="">
                                            {{--
                                                                                        <a href="#" class="btn btn-block btn-success"><i class="fa fa-envelope"></i> Send Message</a>
                                            --}}
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
                                            <p class="text-muted">@if($practitioner->dob !=null){{ date("Y-m-d",strtotime($practitioner->dob))}}@endif</p>
                                        </div>
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Gender</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->gender){{$practitioner->gender->name}}@endif</p>
                                        </div>
                                    </div>

                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6 b-r"><strong>Nationality</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->nationality){{$practitioner->nationality->name}}@endif</p>
                                        </div>


                                        <div class="col-md-4 col-xs-6 b-r"><strong>Registration Date</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->registration_date){{date('d F Y',strtotime($practitioner->registration_date))}}@endif</p>
                                        </div>
                                    </div>

                                    <hr/>

                                    <div class="row">

                                        <div class="col-md-4 col-xs-6 b-r"><strong>Profession</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->profession){{$practitioner->profession->name}}@endif</p>
                                        </div>

                                        <div class="col-md-4 col-xs-6 b-r"><strong>Student Number</strong>
                                            <br>
                                            <p class="text-muted">
                                                @if($practitioner->student_number == null)
                                                    {{'A/S (No Registration Number)'}} <a
                                                        href="/admin/students/generate_reg/{{$practitioner->id}}">Generate</a>
                                                @else
                                                    {{str_pad($practitioner->student_number, 4, '0',
                                                    STR_PAD_LEFT)}}
                                                @endif
                                            </p>
                                        </div>


                                        <div class="col-md-4 col-xs-6 b-r"><strong>Register Category</strong>
                                            @if($practitioner->practitioner_payment_information)
                                                <br>
                                                <p class="text-muted">@if($practitioner->practitioner_payment_information->register_category){{$practitioner->practitioner_payment_information->register_category->name}}@endif</p>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 col-xs-6 b-r"><strong>Employment Status</strong>
                                            <br>
                                            <p class="text-muted">
                                                @if($practitioner->employment_status_id != null)
                                                    {{$practitioner->employment_status->name}}
                                                @endif
                                            </p>
                                        </div>

                                        <div class="col-md-4 col-xs-6 b-r"><strong>Residence</strong>
                                            <br>
                                            <p class="text-muted">
                                                @if($practitioner->employment_location_id != null)
                                                    {{$practitioner->employment_location->name}}
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
                        <!-- Start Of Contact tab -->
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
                                    @if($practitioner->contact)
                                        <div class="col-md-3 col-xs-6 b-r"><strong>Province</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->contact->province){{$practitioner->contact->province->name}}@endif</p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r"><strong>City/Location</strong>
                                            <br>
                                            <p class="text-muted">@if($practitioner->contact->city){{$practitioner->contact->city->name}}@endif</p>
                                        </div>
                                    @endif

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
                        <!-- Start Of Practitioner Qualifications tab -->
                        <div class="tab-pane p-20" id="qualifications" role="tabpanel">
                            @can('updatePractitioner')
                                <a href="/admin/practitioners/qualifications/{{$practitioner->id}}/create"
                                   class="btn btn-success btn-sm" style="margin-bottom: 10px;">Additional
                                    Qualification</a>
                            @endcan

                            <div class="row small-spacing">

                                <div class="col-md-8 col-xs-12">
                                    @if($practitioner->practitionerQualifications->count())
                                        @foreach($practitioner->practitionerQualifications as $practitioner_qualification)
                                            <div class="row">
                                                <div class="col-md-3 col-xs-4 b-r"><strong>Profession</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner_qualification->profession){{$practitioner_qualification->profession->name}}@endif</p>
                                                </div>


                                                <div class="col-md-3 col-xs-4 b-r"><strong>Professional
                                                        Qualification</strong>
                                                    <br>
                                                    @if($practitioner_qualification->qualification_category_id == 1)
                                                        <p class="text-muted">@if($practitioner_qualification->professionalQualification){{$practitioner_qualification->professionalQualification->name}}@endif</p>
                                                    @else
                                                        <p class="text-muted">@if($practitioner_qualification->professional_qualification_name !=null){{$practitioner_qualification->professional_qualification_name}}@endif</p>

                                                    @endif
                                                </div>


                                                <div class="col-md-3 col-xs-4 b-r"><strong>Accredited
                                                        Institution</strong>
                                                    <br>
                                                    <p class="text-muted">

                                                        @if($practitioner_qualification->qualification_category_id==1)
                                                            @if($practitioner_qualification->accreditedInstitution)
                                                                {{$practitioner_qualification->accreditedInstitution->name}}
                                                            @endif
                                                        @else
                                                            {{ucwords($practitioner_qualification->institution)}}
                                                        @endif

                                                    </p>
                                                </div>
                                                <div class="col-md-3 col-xs-4 b-r"><strong>Qualification
                                                        Category</strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner_qualification->qualificationCategory){{$practitioner_qualification->qualificationCategory->name}}@endif</p>
                                                </div>

                                                <div class="col-md-3 col-xs-4 b-r"><strong>Commencement Date
                                                    </strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner_qualification->commencement_date){{date('d F Y',strtotime($practitioner_qualification->commencement_date))}}@endif</p>
                                                </div>

                                                <div class="col-md-3 col-xs-4 b-r"><strong>Completion Date
                                                    </strong>
                                                    <br>
                                                    <p class="text-muted">@if($practitioner_qualification->completion_date){{date('d F Y',strtotime($practitioner_qualification->completion_date))}}@endif</p>
                                                </div>


                                            </div>
                                            <div class="col-md-12 col-xs-12">
                                                <a href="{{url('/admin/practitioners/qualifications/'.$practitioner_qualification->id.'/edit')}}">
                                                    Edit Professional Qualification
                                                </a>
                                            </div>
                                            <br/>
                                            <br/>
                                        @endforeach
                                    @endif
                                </div>
                                <!-- /.col-md-9 col-xs-12 -->
                            </div>
                        </div>
                        <!-- Start Of documents  tab -->
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
                        <!-- Start Of intern  tab -->
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
                                                   width="100%">
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
                                                            <td>@if($renewal->created_at !=null){{$renewal->created_at->format('d F Y')}}@endif</td>
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
                        <!-- Start Of employment  tab -->
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
                                                    <p class="text-muted">
                                                        @if($practitioner->employer)
                                                            @if($practitioner->employer->province)
                                                                {{$practitioner->employer->province->name}}
                                                            @endif
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-3 col-xs-6"><strong>City/Location</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                        @if($practitioner->employer)
                                                            @if($practitioner->employer->city)
                                                                {{$practitioner->employer->city->name}}
                                                            @endif
                                                        @endif</p>
                                                </div>

                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Start Of shortfalls  tab -->
                        <div class="tab-pane p-20" id="shortfalls" role="tabpanel">
                            <div class="table-responsive">

                                <br/>
                                <h4 class="card-title">Requirements</h4>
                                <table id="practitioner_requirements"
                                       class="display table table-hover table-striped table-bordered"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Requirements</th>
                                        <th>Document</th>
                                        <th>Registration Officer Approval (<span id="officer"></span>)</th>
                                        {{--<th>Member Approval (<span id="member"></span>)</th>--}}

                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Requirements</th>
                                        <th>Document</th>
                                        <th>Registration Officer Approval</th>
                                        {{--<th>Member Approval</th>--}}

                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($practitioner->practitionerRequirements)
                                        @foreach($practitioner->practitionerRequirements as $shortfall)
                                            <tr>
                                                <td>{{$shortfall->requirement->name}}</td>
                                                <td>
                                                    @if($shortfall->file !=null)
                                                        <a href="{{asset($shortfall->file)}}"
                                                           target="_blank">View Document</a>
                                                    @else
                                                        {{'No Document'}}
                                                    @endif
                                                </td>

                                                <td>

                                                    <input type="checkbox" name="status"
                                                           {{$shortfall->status ?'checked':'' }} value="{{$shortfall->id}}"
                                                           class="officer">

                                                </td>
                                                {{-- <td>
                                                     <input type="checkbox" name="member_status"
                                                            {{$shortfall->member_status?'checked':'' }} value="{{$shortfall->id}}"
                                                            class="member">

                                                 </td>--}}

                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                                <br/>
                                <div class="col-md-9 col-xs-12">
                                    @if($practitioner->approval_status == 0)
                                        <a href="/admin/students/approval/{{$practitioner->id}}/approve"
                                           class="btn btn-success btn-xs"><i class="fa fa-check"></i> Approve
                                            Application
                                        </a>

                                        <a href="/admin/students/approval/{{$practitioner->id}}/disapprove"
                                           class="btn btn-success btn-xs"><i class="fa fa-crosshairs"></i> Disapprove
                                            Application
                                        </a>
                                    @else
                                        {{'Application approved'}}
                                    @endif
                                    <br/>
                                    <br/>
                                    <div class="box-content card">
                                        <h4 class="box-title"><i class="fa fa-bookmark-o"></i> Application Comments
                                        </h4>
                                        <div class="card-content">
                                            <ul class="dot-list">
                                                @if(auth()->check())
                                                    @if(auth()->user()->notifications->count())
                                                        @foreach (auth()->user()->notifications as $notification)
                                                            @if ($practitioner->id == $notification->data['id'])
                                                                <li>
                                                                    {{--<a href="/admin/practitioners/read/{{$practitioner->id}}/{{$notification->id}}">Mark
                                                                        As Read</a>--}}
                                                                    <span class="date">
                                                                            @if($notification->data['comment'] != null)
                                                                            {{$notification->data['comment']}}
                                                                        @else{{'No comment on this notification'}}
                                                                        @endif
                                                                        </span>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                        <a class="btn btn-success"
                                           href="/student_confirmation/{{$practitioner->id}}"
                                           target="_blank">Preview Student Confirmation</a>
                                </div>
                            </div>
                        </div>
                        <!-- Start Of applications  tab -->
                        <div class="tab-pane p-20" id="apps" role="tabpanel">

                            <a href="/admin/practitioners/apps/{{$practitioner->id}}/create"
                               class="btn btn-success btn-sm">Create Other Applications
                            </a>

                            <div class="table-responsive">
                                <h4 class="card-title">Applications</h4>
                                <table id="others_apps"
                                       class="display nowrap table table-hover table-striped table-bordered"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Application</th>
                                        <th>Application date</th>
                                        <th>Application Status</th>
                                        <th>Payment Status</th>
                                        <th>Verify</th>
                                        <th>View</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Application</th>
                                        <th>Application date</th>
                                        <th>Application Status</th>
                                        <th>Payment Status</th>
                                        <th>Verify</th>
                                        <th>View</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($applications)
                                        @foreach($applications as $application)
                                            <tr>
                                                <td>{{$application->payment_item->name}}</td>
                                                <td>
                                                    {{date("d F Y",strtotime($application->created_at))}}
                                                </td>
                                                <td>
                                                    @if($application->status == 0)
                                                        {{'Pending Approval'}}
                                                    @elseif($application == 1)
                                                        {{'Pending Sign Off'}}
                                                    @else
                                                        {{'Approved'}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($application->payment_status == 1)
                                                        {{'Paid'}}
                                                    @elseif($application == 2)
                                                        {{'Pending Payment'}}
                                                    @else
                                                        {{'Owing'}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a
                                                        href="/admin/practitioners/apps/{{$application->practitioner->id}}/edit">Verify
                                                        application
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="/admin/practitioners/apps/{{$application->id}}/show">View
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
                        <!-- Start Of renewal  tab -->
                        <div class="tab-pane p-20" id="renewal" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-group">

                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive m-t-40">
                                                    <h4 class="card-title">Renewals and Payments</h4>
                                                    <table id="renewals"
                                                           class="display nowrap table table-hover table-striped table-bordered"
                                                           width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Period</th>
                                                            <th>Current Balance</th>
                                                            <th>Status</th>
                                                            <th>CPD Points</th>
                                                            <th>Renewal Date</th>
                                                            <th>Preview</th>
                                                            <th>Verify</th>
                                                            <th>Record Payment</th>
                                                            <th>All</th>

                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr>
                                                            <th>Period</th>
                                                            <th>Current Balance</th>
                                                            <th>Status</th>
                                                            <th>CPD Points</th>
                                                            <th>Renewal Date</th>
                                                            <th>Preview</th>
                                                            <th>Verify</th>
                                                            <th>Record Payment</th>
                                                            <th>All</th>

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

                                                                    <td>@if($renewal->created_at !=null){{$renewal->created_at->format('d F Y')}}@endif</td>
                                                                    <td>
                                                                        <a href="/certificate/{{$renewal->id}}"
                                                                           target="_blank">Preview </a>
                                                                    </td>
                                                                    <td>
                                                                        @if($renewal->certificate == 2)
                                                                            {{'Signed'}}
                                                                        @elseif($renewal->certificate == 1)
                                                                            @can('registrarApproval')
                                                                                <a href="/admin/practitioner_renewals/{{$renewal->id}}/initiate_renewal_sign_off">Sign_off </a>
                                                                            @endcan
                                                                        @else
                                                                            @can('updatePractitionerPayment')
                                                                                <a href="/admin/practitioner_renewals/{{$renewal->id}}/initiate_renewal_verification">Verify </a>
                                                                            @else
                                                                                {{'No rights'}}
                                                                            @endcan
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a
                                                                            href="/admin/practitioners/renewals/{{$renewal->id}}/create_payment">Record
                                                                            Payment </a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="/admin/practitioner_renewals/{{$renewal->id}}/index">Payments </a>
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
                                <br/>
                                @can('updatePractitionerPayment')
                                    <div class="col-md-9 col-xs-12">
                                        @if($practitioner->approval_status == 0)

                                            @if($practitioner->accountant == 0 )
                                                <a href="/admin/students/approval/{{$practitioner->id}}/approve"
                                                   class="btn btn-success btn-xs"><i class="fa fa-check"></i>
                                                    Approve Application Payment
                                                </a>

                                            @elseif($practitioner->accountant == 1 || $practitioner->accountant == 3)
                                                <a href="/admin/students/approval/{{$practitioner->id}}/approve"
                                                   class="btn btn-success btn-xs"><i class="fa fa-check"></i>
                                                    Approve Registration Payment
                                                </a>
                                            @endif
                                            <a href="/admin/students/approval/{{$practitioner->id}}/disapprove"
                                               class="btn btn-success btn-xs"><i class="fa fa-crosshairs"></i>
                                                Disapprove Payment
                                            </a>

                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-bookmark-o"></i>
                                                    Application Comments
                                                </h4>
                                                <div class="card-content">
                                                    <ul class="dot-list">
                                                        @if(auth()->check())
                                                            @if(auth()->user()->notifications->count())
                                                                @foreach (auth()->user()->notifications as $notification)
                                                                    @if ($practitioner->id == $notification->data['id'])
                                                                        <li>
                                                                            {{--<a href="/admin/practitioners/read/{{$practitioner->id}}/{{$notification->id}}">Mark
                                                                                As Read</a>--}}
                                                                            <span class="date">
                                                                            @if($notification->data['comment'] != null)
                                                                                    {{$notification->data['comment']}}
                                                                                @else{{'No comment on this notification'}}
                                                                                @endif
                                                                        </span>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <a href="/admin/practitioners/registration/{{$practitioner->id}}/registration"
                                       class="btn btn-success"> Registration Payment
                                    </a>

                                    <a href="/check_restoration_penalties/{{$practitioner->id}}"
                                       class="btn btn-success"> Renewal Payment
                                    </a>
                                    <br/>
                                    <br/>
                                @endcan

                            </div>
                        </div>
                        <!-- Start Of Approvals  tab -->
                        <div class="tab-pane p-20" id="approval" role="tabpanel">
                            @if(auth()->user()->role_id == 7)
                                <div class="col-md-9 col-xs-12">
                                    @if($practitioner->approval_status == 0)
                                        <a href="/admin/students/approval/{{$practitioner->id}}/approve"
                                           class="btn btn-success btn-xs"><i class="fa fa-check"></i> Approve
                                            Application
                                        </a>

                                        <a href="/admin/students/approval/{{$practitioner->id}}/disapprove"
                                           class="btn btn-success btn-xs"><i class="fa fa-crosshairs"></i> Disapprove
                                            Application
                                        </a>
                                    @else
                                        {{'Application approved'}}
                                    @endif
                                    <br/>
                                    <br/>
                                    @if($practitioner->approval_status == 0)
                                        <div class="box-content card">
                                            <h4 class="box-title"><i class="fa fa-bookmark-o"></i> Application Comments
                                            </h4>
                                            <div class="card-content">
                                                <ul class="dot-list">
                                                    @if(auth()->check())
                                                        @if(auth()->user()->notifications->count())
                                                            @foreach (auth()->user()->notifications as $notification)
                                                                @if ($practitioner->id == $notification->data['id'])
                                                                    <li>
                                                                        {{--<a href="/admin/practitioners/read/{{$practitioner->id}}/{{$notification->id}}">Mark
                                                                            As Read</a>--}}
                                                                        <span class="date">
                                                                            @if($notification->data['comment'] != null)
                                                                                {{$notification->data['comment']}}
                                                                            @else{{'No comment on this notification'}}
                                                                            @endif
                                                                        </span>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    @endif


                                            <a class="btn btn-success"
                                               href="/student_confirmation/{{$practitioner->id}}"
                                               target="_blank">Preview Student Confirmation</a>


                                </div>
                                <br/>
                            @endif
                            <div class="col-md-9 col-xs-12">
                                <h1>Portal Account Permissions</h1>
                                <a href="{{url('admin/practitioners/'.$practitioner->id.'/1/verify_create')}}"
                                   class="btn btn-success btn-xs"><i class="fa fa-check"></i> Activate
                                </a>

                                <a href="/admin/practitioners/{{$practitioner->id}}/2/verify_create"
                                   class="btn btn-success btn-xs"><i class="fa fa-window-close"></i> De-activate
                                </a>
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

