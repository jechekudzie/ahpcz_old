@extends('layouts.admin')
@section('title','AHPCZ - Professions')
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

                        <li class="breadcrumb-item active">Professions, CD Points, Prefixes</li>
                    </ol>

                </div>
            </div>
        </div>
        <!-- End Bread crumb and right sidebar toggle -->

        <!-- Professions List -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">Professions, CPD Points, Placement and Prefixes</h4>
                        <h6 class="card-subtitle">Prefixes are used to generate registration numbers as per <code>profession</code>
                        </h6>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home2" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                        class="hidden-xs-down">Professions</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile2" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                        class="hidden-xs-down">Prefixes</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messages2" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                        class="hidden-xs-down">CPD Points & Placement</span></a></li>
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

                                <div class="card">
                                    <div class="card-body">

                                        <a href="professions/create" class="btn btn-success"><i
                                                    class="fa fa-plus-circle"></i> Create New Profession</a>
                                        <div class="table-responsive m-t-40">
                                            <table id="professions"
                                                   class="display table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Profession</th>
                                                    <th>Plural</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Profession</th>
                                                    <th>Plural</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($professions as $profession)
                                                    <tr>
                                                        <td>{{$profession->name}}</td>
                                                        <td>{{$profession->plural}}</td>
                                                        {{--<td>{{$profession->description}}</td>--}}
                                                        <td>{{$profession->updated_at}}</td>
                                                        <td><a href="/admin/professions/{{$profession->id}}/edit"><i
                                                                        class="fa fa-pencil"></i> Edit</a></td>
                                                        <td><a href="/admin/professions/{{$profession->id}}"><i
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
                        <div class="tab-pane  p-20" id="profile2" role="tabpanel">

                            <div class="col-12">

                                <div class="card">
                                    <div class="card-body">

                                        <a href="/admin/prefixes/create" class="btn btn-success"><i
                                                    class="fa fa-plus-circle"></i> Assign Prefix</a>
                                        <div class="table-responsive m-t-40">
                                            <table id="cdpoints"
                                                   class="display table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>

                                                    <th>Profession</th>
                                                    <th>Prefix</th>
                                                    <th>Last Registration Number</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>

                                                    <th>Profession</th>
                                                    <th>Prefix</th>
                                                    <th>Last Registration Number</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($prefixes as $prefix)
                                                    <tr>
                                                        <td>@if($prefix->profession)
                                                                {{$prefix->profession->name}}@endif</td>
                                                        <td>{{$prefix->name}}</td>
                                                        <td>{{str_pad($prefix->last_reg, 4, '0', STR_PAD_LEFT) }}</td>
                                                        <td>{{$prefix->updated_at}}</td>
                                                        <td><a href="/admin/prefixes/{{$prefix->id}}/edit"><i
                                                                        class="fa fa-pencil"></i> Edit</a></td>
                                                        <td><a href="/admin/prefixes/{{$prefix->id}}"><i
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
                        <div class="tab-pane p-20" id="messages2" role="tabpanel">

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <a href="/admin/cdpoints/create" class="btn btn-success"><i
                                                    class="fa fa-plus-circle"></i> Assign CPD Point</a>
                                        <div class="table-responsive m-t-40">
                                            <table id="prefixes"
                                                   class="display table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Profession</th>
                                                    <th>Cd Points</th>
                                                    <th>Placement</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Profession</th>
                                                    <th>Cd Points</th>
                                                    <th>Placement</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($cdpoints as $cdpoint)
                                                    <tr>
                                                        <td>@if($cdpoint->profession)
                                                                {{$cdpoint->profession->name}}@endif</td>
                                                        <td>{{$cdpoint->points}}</td>
                                                        <td>
                                                            @if($cdpoint->placement == 1)
                                                                {{'Required'}}
                                                            @else
                                                                {{'Not Required'}}
                                                            @endif
                                                        </td>
                                                        <td>{{$cdpoint->updated_at}}</td>
                                                        <td><a href="/admin/cdpoints/{{$cdpoint->id}}/edit"><i
                                                                        class="fa fa-pencil"></i> Edit Cd Point</a></td>
                                                        <td><a href="/admin/cdpoints/{{$cdpoint->id}}"><i
                                                                        class="fa fa-trash"></i> Delete Cd Point</a>
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

                $('#professions').DataTable({
                    order: [],
                    dom: 'Bfrtip',

                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

                $('#prefixes').DataTable({
                    order: [],
                    dom: 'Bfrtip',

                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

                $('#cdpoints').DataTable({
                    order: [],
                    dom: 'Bfrtip',

                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            </script>
@endsection
