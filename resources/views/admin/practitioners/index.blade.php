@extends('layouts.admin')
@section('plugins-css')

@section('content')
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">

                @can('updatePractitioner')
                    <a href="practitioners/create" class="btn btn-success"><i
                            class="fa fa-plus-circle"></i> Add Practitioner</a>
                    <a href="/admin/practitioners/renewal/create" class="btn btn-success"><i
                            class="fa fa-plus-circle"></i> Add Practitioner For Renewal</a>
                @endcan
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>

                        <li class="breadcrumb-item active">Practitioners</li>
                    </ol>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if (session('message'))
                    <div class="alert alert-success alert-rounded col-md-6">
                        <i class="fa fa-check-circle"></i> {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#approved"
                                                role="tab"><span
                                    class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                    class="hidden-xs-down"> Practitioners</span></a></li>

                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pending" role="tab"><span
                                    class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                    class="hidden-xs-down">Applications Pending Approval ({{$pending_apps = \App\Practitioner::where("approval_status","=",0)->count()}})</span></a>
                        </li>


                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="approved" role="tabpanel">
                            <div class="card-body">
                                <h4 class="card-title">Practitioners</h4>
                                <div class="table-responsive m-t-40">
                                    <table id="practitioners"
                                           class="display table table-hover table-striped table-bordered"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Practitioner Name</th>
                                            <th>Registration Number</th>
                                            <th>Profession</th>
                                            <th>Professional Qualification</th>
                                            {{--<th>Qualification Category</th>--}}
                                            <th>Accredited Institution</th>
                                            <th>Status</th>
                                            <th>view</th>
                                            @can('updatePractitioner')
                                                <th>Delete</th>
                                            @endcan
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Practitioner Name</th>
                                            <th>Registration Number</th>
                                            <th>Profession</th>
                                            <th>Professional Qualification</th>
                                            {{--<th>Qualification Category</th>--}}
                                            <th>Accredited Institution</th>
                                            <th>Status</th>
                                            <th>view</th>
                                            @can('updatePractitioner')
                                                <th>Delete</th>
                                            @endcan
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach($practitioners->where('approval_status',1)->sortBy('first_name') as $practitioner)
                                            <tr>
                                                <td>{{$practitioner->title->name}}</td>
                                                <td>{{$practitioner->first_name.' '.$practitioner->last_name}}</td>
                                                <td>
                                                    @if($practitioner->registration_number == null)
                                                        {{$practitioner->prefix.' (No Registration Number)'}}
                                                    @else
                                                        {{$practitioner->prefix.str_pad($practitioner->registration_number, 4, '0', STR_PAD_LEFT)}}
                                                    @endif
                                                </td>
                                                <td>{{$practitioner->profession->name}}</td>
                                                <td> @if($practitioner->professional_qualification_id !=null){{$practitioner->professionalQualification->name}}@endif</td>
                                                {{--
                                                                                                <td>@if($practitioner->qualification_category_id!=null){{$practitioner->qualificationCategory->name}}@endif</td>
                                                --}}
                                                <td>
                                                    @if($practitioner->qualification_category_id!=null)
                                                        @if($practitioner->qualification_category_id == 1)
                                                            {{$practitioner->accreditedInstitution->name}}
                                                        @else
                                                            {{$practitioner->institution}}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($practitioner->currentRenewal)
                                                        @if (($practitioner->currentRenewal->renewal_status_id == 1) && ($practitioner->currentRenewal->cdpoints == 1) && ($practitioner->currentRenewal->placement == 1))
                                                            {{'Compliant'}}
                                                        @else
                                                            {{'Not Compliant'}}
                                                        @endif
                                                    @else
                                                        {{'Not Compliant'}}
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="/admin/practitioners/{{$practitioner->id}}">View</a> |
                                                    <a href="/admin/practitioners/renewals/{{$practitioner->id}}/checkPaymentStatusRenewal"> Renew</a>
                                                </td>
                                                @can('updatePractitioner')
                                                    <td><a href="/admin/practitioners/{{$practitioner->id}}/delete">
                                                            Delete</a></td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="pending" role="tabpanel">
                            <div class="card-body">
                                <h4 class="card-title">Practitioners</h4>
                                <div class="table-responsive m-t-40">
                                    <table id="pendings"
                                           class="display table table-hover table-striped table-bordered"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Practitioner Name</th>
                                            <th>Registration Number</th>
                                            <th>Profession</th>
                                            <th>Professional Qualification</th>
                                            <th>Qualification Category</th>
                                            <th>Accredited Institution</th>
                                            <th>Status</th>
                                            <th>view</th>
                                            @can('updatePractitioner')
                                                <th>Delete</th>
                                            @endcan
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Practitioner Name</th>
                                            <th>Registration Number</th>
                                            <th>Profession</th>
                                            <th>Professional Qualification</th>
                                            <th>Qualification Category</th>
                                            <th>Accredited Institution</th>
                                            <th>Status</th>
                                            <th>view</th>
                                            @can('updatePractitioner')
                                                <th>Delete</th>
                                            @endcan
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach($practitioners->where('approval_status',0)->sortBy('first_name') as $practitioner)
                                            <tr>
                                                <td>{{$practitioner->title->name}}</td>
                                                <td>{{$practitioner->first_name.' '.$practitioner->last_name}}</td>
                                                <td>
                                                    @if($practitioner->registration_number == null)
                                                        {{$practitioner->prefix.' (No Registration Number)'}}
                                                    @else
                                                        {{$practitioner->prefix.str_pad($practitioner->registration_number, 4, '0', STR_PAD_LEFT)}}
                                                    @endif
                                                </td>
                                                <td>{{$practitioner->profession->name}}</td>
                                                <td>@if($practitioner->professional_qualification_id !=null){{$practitioner->professionalQualification->name}}@endif</td>
                                                <td>@if($practitioner->qualification_category_id !=null){{$practitioner->qualificationCategory->name}}@endif</td>
                                                <td>
                                                    @if($practitioner->qualification_category_id !=null)
                                                        @if($practitioner->qualification_category_id == 1)
                                                            {{$practitioner->accreditedInstitution->name}}
                                                        @else
                                                            {{$practitioner->institution}}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(
                                                    $practitioner->registration_officer == 0

                                                    )
                                                        {{'Pending Registration Officer Approval'}}

                                                    @elseif(
                                                    $practitioner->registration_officer == 1
                                                    && $practitioner->accountant == 0

                                                    )
                                                        {{'Pending Accountant Approval'}}

                                                    @elseif(
                                                    $practitioner->registration_officer == 1
                                                    && $practitioner->accountant == 1
                                                    && $practitioner->member == 0

                                                    )
                                                        {{'Pending Member Approval'}}

                                                    @elseif(
                                                    $practitioner->registration_officer == 1
                                                    && $practitioner->accountant == 1
                                                    && $practitioner->member == 1
                                                    )
                                                        {{'Pending Registration Officer Approval'}}

                                                    @elseif(
                                                    $practitioner->registration_officer == 2
                                                    && $practitioner->accountant == 1
                                                    && $practitioner->member == 1
                                                    && $practitioner->registrar == 0

                                                    )
                                                        {{'Pending Registrar Approval'}}

                                                    @elseif(

                                                    $practitioner->registration_officer == 1
                                                    && $practitioner->accountant == 1
                                                    && $practitioner->member == 1
                                                    && $practitioner->registrar == 1
                                                    && $practitioner->approval_status == 1
                                                    )
                                                        {{'Application Approved '}}
                                                    @else
                                                        {{'Application disapproved'}}
                                                    @endif
                                                </td>

                                                <td><a href="/admin/practitioners/{{$practitioner->id}}"> View</a> |
                                                    <a href="/admin/practitioners/renewals/{{$practitioner->id}}/checkPaymentStatusRenewal"> Renew</a>

                                                </td>
                                                @can('updatePractitioner')
                                                    <td><a href="/admin/practitioners/{{$practitioner->id}}/delete">
                                                            Delete</a></td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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

        $('#practitioners').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $('#pendings').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
@stop
