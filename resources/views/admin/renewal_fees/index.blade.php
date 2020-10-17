@extends('layouts.admin')
@section('title','AHPCZ - Renewal Fees')
@section('plugins-css')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- Bread crumb and right sidebar toggle -->
        <div class="row page-titles">
            <div class="col-md-7 align-self-center">
                 <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
                 <a href="renewal_fees/create" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Practitioner Renewal Fee</a>
            </div>
            <div class="col-md-5 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>

                        <li class="breadcrumb-item active">Practitioner Renewal Fees</li>
                    </ol>

                </div>
            </div>
        </div>
        <!-- End Bread crumb and right sidebar toggle -->

        <!-- Renewal Fees List -->
        <div class="row">
            <div class="col-12">
                @if (session('message'))
                    <div class="alert alert-success alert-rounded col-md-6"><i class="fa fa-check-circle"></i>  {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Practitioner Renewal Fees</h4>
                        <div class="table-responsive m-t-40">
                            <table id="renewal_fees" class="display nowrap table table-hover table-striped table-bordered"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Profession</th>
                                    <th>Renewal Category</th>
                                    <th>Fee ($RTGS)</th>
                                    <th>VAT 15% ($RTGS)</th>
                                    <th>Total ($RTGS) <i style="color: red;">VAT Inclusive</i></th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Profession</th>
                                    <th>Renewal Category</th>
                                    <th>Fee ($RTGS)</th>
                                    <th>VAT 15% ($RTGS)</th>
                                    <th>Total ($RTGS) <i style="color: red;">VAT Inclusive</i></th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($renewal_fees as $renewal_fee)
                                    <tr>
                                        <td> {{$renewal_fee->profession->name}}</td>
                                        <td>{{$renewal_fee->renewalCategory->name}}</td>
                                        <td>{{$renewal_fee->fee}}</td>
                                        <td>{{$vat  = $renewal_fee->fee*0.15}}</td>
                                        <td>{{$total  = $renewal_fee->fee + $vat}}</td>
                                        <td><a href="/admin/renewal_fees/{{$renewal_fee->id}}/edit"><i class="fa fa-pencil"></i> Edit</a> </td>
                                        <td><a href="/admin/renewal_fees/{{$renewal_fee->id}}"><i class="fa fa-trash"></i> Delete</a> </td>
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

        $('#renewal_fees').DataTable({
            /*order: [],*/
            dom: 'Bfrtip',

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
@endsection
