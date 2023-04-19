@extends('layouts.admin')
@section('title','AHPCZ - Professions')
@section('plugins-css')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- Bread crumb and right sidebar toggle -->
        <div class="row page-titles">
            <div class="col-md-8 align-self-center">
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
                <a href="renewal_categories/create" class="btn btn-success"><i class="fa fa-plus-circle"></i> Create New
                    Renewal Category</a>
            </div>
            <div class="col-md-4 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>

                        <li class="breadcrumb-item active">Renewal Categories</li>
                    </ol>

                </div>
            </div>
        </div>
        <!-- End Bread crumb and right sidebar toggle -->

        <!-- Professions List -->
        <div class="row">
            <div class="col-12">
                @if (session('message'))
                    <div class="col-md-6 col-lg-6 alert alert-success alert-rounded"><i
                            class="fa fa-check-circle"></i> {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Renewal Categories</h4>
                        <div class="table-responsive m-t-40">
                            <table id="professions"
                                   class="display nowrap table table-hover table-striped table-bordered"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Renewal Category</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Renewal Category</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($renewal_categories as $renewal_category)
                                    <tr>
                                        <td>{{$renewal_category->name}}</td>
                                        <td>{{$renewal_category->description}}</td>
                                        <td>{{$renewal_category->created_at}}</td>
                                        <td><a href="/admin/renewal_categories/{{$renewal_category->id}}/edit"><i
                                                    class="fa fa-pencil"></i> Edit</a></td>
                                        <td><a href="/admin/renewal_categories/{{$renewal_category->id}}"><i
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
        <div class="row">
            <div class="col-12">
                <div class="col-md-8 align-self-center">
                    <a href="/admin/renewal_criterias/create" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Add renewal fee criteria</a>
                </div>
                <br/>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Renewal fee criteria</h4>
                        <div class="table-responsive m-t-40">
                            <table id="renewal_criteria"
                                   class="display nowrap table table-hover table-striped table-bordered"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Renewal category</th>
                                    <th>Employment status</th>
                                    <th>Residence</th>
                                    <th>Certificate request</th>
                                    <th>Percentage</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Renewal category</th>
                                    <th>Employment status</th>
                                    <th>Residence</th>
                                    <th>Certificate request</th>
                                    <th>Percentage</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($renewal_criteria as $criteria)
                                    <tr>
                                        <td>@if($criteria->renewal_category)
                                                {{$criteria->renewal_category->name}}@endif</td>
                                        <td>{{$criteria->employment_status->name}}</td>
                                        <td>{{$criteria->employment_location->name}}</td>
                                        <td>
                                            @if($criteria->certificate_request == 1)
                                                {{'Requires a certificate'}}
                                            @else
                                                {{'Does not require a certificate'}}
                                            @endif
                                        </td>
                                        <td>Pays {{$criteria->percentage}} % of the renewal fee</td>
                                        <td><a href="/admin/renewal_criterias/{{$criteria->id}}/edit"><i
                                                    class="fa fa-pencil"></i> Edit</a></td>
                                        <td><a href="/admin/renewal_criterias/{{$criteria->id}}"><i
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

        <div class="row">
            <div class="col-12">
                <div class="col-md-8 align-self-center">
                    <a href="/admin/cpd_criterias/index" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Add CPD criteria</a>
                </div>
                <br/>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">CPD criteria</h4>
                        <div class="table-responsive m-t-40">
                            <table id="cpd_criteria"
                                   class="display nowrap table table-hover table-striped table-bordered"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Profession</th>
                                    <th>Standard</th>
                                    <th>Employment Status</th>
                                    <th>Points</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Renewal category</th>
                                    <th>Standard</th>
                                    <th>Employment Status</th>
                                    <th>Points</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($cpd_criterias as $cpd_criteria)
                                    <tr>
                                        <td>@if($cpd_criteria->profession){{$cpd_criteria->profession->name}}@endif</td>
                                        <td>{{$cpd_criteria->standard}}</td>
                                        <td>{{$cpd_criteria->employment_status->name}}</td>
                                        <td>{{$cpd_criteria->points}}</td>
                                        <td><a href="/admin/cpd_criterias/{{$cpd_criteria->id}}/edit"><i
                                                    class="fa fa-pencil"></i> Edit</a></td>

                                        <td><a href="/admin/cpd_criterias/{{$cpd_criteria->id}}/delete"><i
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


        <div class="row">
            <div class="col-12">
                <div class="col-md-8 align-self-center">

                    <a href="employment_statuses/create" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Create Employment Status</a>
                </div>
                <br/>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Employment Statuses</h4>
                        <div class="table-responsive m-t-40">
                            <table id="employment_status"
                                   class="display nowrap table table-hover table-striped table-bordered"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($employment_statuses as $employment_status)
                                    <tr>
                                        <td>{{$employment_status->name}}</td>

                                        <td>{{$employment_status->created_at}}</td>
                                        <td><a href="/admin/employment_statuses/{{$employment_status->id}}/edit"><i
                                                    class="fa fa-pencil"></i> Edit</a></td>
                                        <td><a href="/admin/employment_statuses/{{$employment_status->id}}"><i
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
        <div class="row">
            <div class="col-12">
                <div class="col-md-8 align-self-center">
                    <a href="employment_locations/create" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Create Employment Locations</a>
                </div>
                <br/>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Employment Locations</h4>
                        <div class="table-responsive m-t-40">
                            <table id="employment_location"
                                   class="display nowrap table table-hover table-striped table-bordered"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($employment_locations as $employment_location)
                                    <tr>
                                        <td>{{$employment_location->name}}</td>

                                        <td>{{$employment_location->created_at}}</td>
                                        <td><a href="/admin/employment_locations/{{$employment_location->id}}/edit"><i
                                                    class="fa fa-pencil"></i> Edit</a></td>
                                        <td><a href="/admin/employment_locations/{{$employment_location->id}}"><i
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

        $('#professions').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#employment_location').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#employment_status').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#renewal_criteria').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#cpd_criteria').DataTable({
            order: [],
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
@endsection
