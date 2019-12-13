@extends('layouts.admin')
@section('title','AHPCZ - Practitioner')
@section('plugins-css')

@endsection

@section('content')

    <div class="container-fluid">
        <!-- Bread crumb and right sidebar toggle -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                @can('admin')
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
                @endcan
                @can('updatePractitioner')
                    <a href="/admin/practitioners/create" class="btn btn-success"><i
                            class="fa fa-plus-circle"></i> Add
                        Practitioner
                    </a>
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
        <!-- End Bread crumb and right sidebar toggle -->

        <!-- Accredited Institutionss List -->


        <div class="row">
            <div class="col-12">
                @if (session('message'))
                    <div class="alert alert-success alert-rounded col-md-6"><i
                            class="fa fa-check-circle"></i> {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive m-t-40">
                            <h4 class="card-title">{{date('Y')}} outstanding issues</h4>
                            <table id="renewals"
                                   class="display nowrap table table-hover table-striped table-bordered"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Practitioner</th>
                                    <th>Registration Number</th>
                                    <th>Period</th>
                                    <th>Payment</th>
                                    <th>CPD Points</th>
                                    <th>Placement</th>
                                    <th>Compliance</th>
                                    <th>view</th>

                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Practitioner</th>
                                    <th>Registration Number</th>
                                    <th>Period</th>
                                    <th>Payment</th>
                                    <th>CPD Points</th>
                                    <th>Placement</th>
                                    <th>Compliance</th>
                                    <th>view</th>
                                </tr>
                                </tfoot>
                                <tbody>

                                @foreach($shortfalls as $shortfall)
                                    @if($pending_renewal = \App\Renewal::find($shortfall['renewal_id']))
                                        <tr>
                                            <td>{{$pending_renewal->practitioner->first_name.' '.$pending_renewal->practitioner->last_name}}</td>
                                            <td>{{$pending_renewal->practitioner->registration_number}}</td>
                                            <td>{{$pending_renewal->renewal_period_id}}</td>
                                            <td>
                                                {{$pending_renewal->renewalStatus->name}}
                                            </td>
                                            <td>
                                                @if($pending_renewal->cdpoints == 0)
                                                    {{'Pending Cd Points'}}
                                                @else
                                                    {{'Up to date'}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($pending_renewal->placement == 0)
                                                    {{'Pending Placement'}}
                                                @else
                                                    {{'Up to date'}}
                                                @endif
                                            </td>


                                            <td> {{number_format($shortfall['shortfall'],2)}}%</td>

                                            <td>
                                                <a href="/admin/practitioners/{{$pending_renewal->practitioner->id}}">View </a>

                                            </td>

                                        </tr>
                                    @endif
                                @endforeach


                                </tbody>
                            </table>
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

                $('#practitioners').DataTable({
                    order: [],
                    dom: 'Bfrtip',

                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

                $('#renewals').DataTable({
                    order: [],
                    dom: 'Bfrtip',

                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            </script>
@endsection
