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
                        <h4 class="card-title">{{ucwords(trans($paymentItem->name))}} Application Requirements</h4>
                    </div>
                    <!-- Nav tabs -->
                    <br/>
                    @if (session('message'))
                        <div class="alert alert-success alert-rounded col-md-6"><i
                                class="fa fa-check-circle"></i> {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                @endif
                <!-- Tab panes -->

                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                                <a href="{{url('/admin/payment_items')}}" class="btn btn-success">
                                    <i class="fa fa-plus-circle"></i> Back
                                </a>
                                <a href="{{url('/admin/payment_item_requirements/'.$paymentItem->id.'/create')}}" class="btn btn-success"><i
                                        class="fa fa-plus-circle"></i> Add requirement
                                </a>
                                <div class="table-responsive m-t-40">
                                    <table id="professions"
                                           class="display nowrap table table-hover table-striped table-bordered"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>

                                            <th>Application</th>
                                            <th>Requirement</th>
                                            <th>Edit</th>

                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>

                                            <th>Application</th>
                                            <th>Requirement</th>
                                            <th>Edit</th>

                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach($payment_item_requirements as $payment_item_requirement)
                                            <tr>
                                                <td>{{$payment_item_requirement->payment_item->name}}</td>
                                                <td>{{$payment_item_requirement->requirement}}</td>
                                                <td>
                                                    <a
                                                        href="/admin/payment_item_requirements/{{$payment_item_requirement->id}}/edit"><i
                                                            class="fa fa-pencil"></i> Edit</a></td>
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
