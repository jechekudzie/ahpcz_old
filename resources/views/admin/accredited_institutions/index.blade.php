@extends('layouts.admin')
@section('title','AHPCZ - Accredited Institutionss')
@section('plugins-css')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- Bread crumb and right sidebar toggle -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>

                        <li class="breadcrumb-item active">Accredited Institutions</li>
                    </ol>

                </div>
            </div>
        </div>
        <!-- End Bread crumb and right sidebar toggle -->

        <!-- Accredited Institutionss List -->


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">Accredited institutions, professions accredited to institutions</h4>

                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home2" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                        class="hidden-xs-down">Accredited Institutions</span></a></li>

                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile4" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                        class="hidden-xs-down"> Discredited Institutions</span></a></li>


                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile2" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                        class="hidden-xs-down">Professional Qualifications</span></a></li>



                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile3" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                        class="hidden-xs-down"> Accredited Qualifications</span></a></li>


                    </ul>
                    <br/>
                    @if (session('message'))
                        <div class="alert alert-success alert-rounded col-md-6"><i
                                    class="fa fa-check-circle"></i> {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                        </div>
                @endif
                <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="home2" role="tabpanel">
                            <div class="col-12">
                                <br/>
                                <a href="accredited_institutions/create" class="btn btn-success"><i
                                            class="fa fa-plus-circle"></i> Add
                                    Institution</a>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Accredited Institutions</h4>
                                        <div class="table-responsive m-t-40">
                                            <table id="accredited_institutions"
                                                   class="display nowrap table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>

                                                    <th>Institution</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>

                                                    <th>Institution</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($accredited_institutions as $accredited_institution)
                                                    <tr>

                                                        <td>{{$accredited_institution->name}}</td>
                                                        <td>{{$accredited_institution->created_at}}</td>
                                                        <td>
                                                            <a href="/admin/accredited_institutions/{{$accredited_institution->id}}/edit"><i
                                                                        class="fa fa-pencil"></i> Edit</a></td>
                                                        <td>
                                                            <a href="/admin/accredited_institutions/{{$accredited_institution->id}}"><i
                                                                        class="fa fa-trash"></i> Delete</a></td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane  p-20" id="profile4" role="tabpanel">

                            <div class="col-12">
                                <a href="/admin/discredited_institutions/create"
                                   class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Discredited Institution</a>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"></h4>
                                        <div class="table-responsive m-t-40">

                                            <table id="discredited_institutions"
                                                   class="display nowrap table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>

                                                    <th>Discredited Institution</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Discredited Institution</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($discredited_institutions as $discredited_institution)
                                                    <tr>
                                                        <td>{{$discredited_institution->name}}</td>
                                                        <td>{{$discredited_institution->updated_at}}</td>
                                                        <td>
                                                            <a href="/admin/discredited_institutions/{{$discredited_institution->id}}/edit"><i
                                                                        class="fa fa-pencil"></i> Edit</a>
                                                        </td>
                                                        <td>
                                                            <a href="/admin/discredited_institutions/{{$discredited_institution->id}}"><i
                                                                        class="fa fa-trash"></i> Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="tab-pane  p-20" id="profile2" role="tabpanel">

                            <div class="col-12">
                                <a href="/admin/professional_qualifications/create"
                                   class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Professional Qualification</a>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Professional Qualifications</h4>
                                        <div class="table-responsive m-t-40">
                                            <table id="profession_accredited_institutions"
                                                   class="display nowrap table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>

                                                    <th>Profession</th>
                                                    <th>Professional Qualification</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>

                                                    <th>Profession</th>
                                                    <th>Professional Qualification</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($professionalQualifications as $professionalQualification)
                                                    <tr>
                                                        <td>{{$professionalQualification->profession->name}}</td>
                                                        <td>{{$professionalQualification->name}}</td>
                                                        <td>{{$professionalQualification->updated_at}}</td>
                                                        <td>
                                                            <a href="/admin/professional_qualifications/{{$professionalQualification->id}}/edit"><i
                                                                        class="fa fa-pencil"></i> Edit</a></td>
                                                        <td>
                                                            <a href="/admin/professional_qualifications/{{$professionalQualification->id}}"><i
                                                                        class="fa fa-trash"></i> Delete</a></td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane  p-20" id="profile3" role="tabpanel">

                            <div class="col-12">
                                <a href="/admin/accredited_qualifications/create"
                                   class="btn btn-success"><i class="fa fa-plus-circle"></i> Assign Accreditation</a>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Accredited Qualification</h4>
                                        <div class="table-responsive m-t-40">

                                            <table id="accredited_qualification"
                                                   class="display nowrap table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>

                                                    <th>Professional Qualification</th>
                                                    <th>Accredited Institution</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>

                                                    <th>Professional Qualification</th>
                                                    <th>Accredited Institution</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($accredited_qualifications as $accredited_qualification)
                                                    <tr>
                                                        <td>{{$accredited_qualification->professionalQualification->name}}</td>
                                                        <td>{{$accredited_qualification->accreditedInstitution->name}}</td>
                                                        <td>{{$accredited_qualification->updated_at}}</td>
                                                        <td>
                                                            <a href="/admin/accredited_qualifications/{{$accredited_qualification->id}}/edit"><i
                                                                        class="fa fa-pencil"></i> Edit</a>
                                                        </td>
                                                        <td>
                                                            <a href="/admin/accredited_qualifications/{{$accredited_qualification->id}}"><i
                                                                        class="fa fa-trash"></i> Delete</a>
                                                        </td>
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

        </div>


    @endsection

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

                $('#accredited_institutions').DataTable({
                    order: [],
                    dom: 'Bfrtip',

                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

                $('#profession_accredited_institutions').DataTable({
                    /*order: [],*/
                    dom: 'Bfrtip',

                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
                $('#accredited_qualification').DataTable({
                    /*order: [],*/
                    dom: 'Bfrtip',

                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
                $('#discredited_institutions').DataTable({
                    /*order: [],*/
                    dom: 'Bfrtip',

                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            </script>
@endsection
