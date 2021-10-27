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
                        <h4 class="card-title">Payment Items, Payment Items Fees</h4>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home2" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                        class="hidden-xs-down">Payment Items</span></a></li>
                        {{--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile2" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                        class="hidden-xs-down">Payment Items Fee</span></a></li>--}}
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messages2" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                        class="hidden-xs-down">Payment Items Category</span></a></li>
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

                                        <a href="/admin/payment_items/create" class="btn btn-success"><i
                                                    class="fa fa-plus-circle"></i> Create New Payment Item</a>
                                        <div class="table-responsive m-t-40">
                                            <table id="professions"
                                                   class="display nowrap table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>

                                                    <th>Payment Item</th>
                                                    <th>Payment Category</th>
                                                    <th>Payment Item Fee (RTGS)</th>
                                                    <th>Total(RTGS) <i style="color: red;">VAT inclusive</i></th>
                                                    <th>Requirements</th>
                                                    <th>Edit</th>

                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>

                                                    <th>Payment Item</th>
                                                    <th>Payment Category</th>
                                                    <th>Payment Item Fee (RTGS)</th>
                                                    <th>Total(RTGS) <i style="color: red;">VAT inclusive</i></th>
                                                    <th>Requirements</th>
                                                    <th>Edit</th>

                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($payment_items as $payment_item)
                                                    <tr>
                                                        <td>{{$payment_item->name}}</td>
                                                        <td>{{$payment_item->paymentItemCategory->name}}</td>
                                                        <td>{{$payment_item->fee * $rate}}</td>
                                                        <td>{{number_format($payment_item->fee)}}</td>
                                                        <td>
                                                            <a href="/admin/payment_item_requirements/{{$payment_item->id}}">
                                                                <i class="fa fa-pencil"></i> Requirements</a></td>

                                                        <td><a href="/admin/payment_items/{{$payment_item->id}}/edit"><i
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

                        <div class="tab-pane p-20" id="messages2" role="tabpanel">

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <a href="/admin/payment_items/categories/create" class="btn btn-success"><i
                                                    class="fa fa-plus-circle"></i> Add Payment Item Category</a>
                                        <div class="table-responsive m-t-40">
                                            <table id="prefixes"
                                                   class="display nowrap table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Payment Item Category</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>

                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Payment Item Category</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>

                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($payment_item_categories as $payment_item_category)
                                                    <tr>
                                                        <td>{{$payment_item_category->id}}</td>
                                                        <td>{{ucwords($payment_item_category->name)}}</td>
                                                        <td>{{$payment_item_category->updated_at}}</td>
                                                        <td><a href="/admin/payment_items/categories/{{$payment_item_category->id}}/edit"><i
                                                                        class="fa fa-pencil"></i> Edit Category</a></td>
                                                        {{--<td><a href="/admin/payment_items/categories/{{$payment_item_category->id}}"><i
                                                                        class="fa fa-trash"></i> Delete Cd Point</a>
                                                        </td>--}}
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--
                        <div class="tab-pane  p-20" id="profile2" role="tabpanel">

                            <div class="col-12">

                                <div class="card">
                                    <div class="card-body">

                                        <a href="/admin/payment_items" class="btn btn-success"><i
                                                    class="fa fa-plus-circle"></i> Add Payment Item Fee</a>
                                        <div class="table-responsive m-t-40">
                                            <table id="cdpoints"
                                                   class="display nowrap table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>

                                                    <th>Payment Item</th>
                                                    <th>Payment Item Fee</th>
                                                    <th>Payment Item Category</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>

                                                    <th>Payment Item</th>
                                                    <th>Payment Item Fee</th>
                                                    <th>Payment Item Category</th>
                                                    <th>Created</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($payment_item_fees as $payment_item_fee)
                                                    <tr>
                                                        <td>{{$payment_item_fee->payment_item->name}}</td>
                                                        <td>{{$payment_item_fee->fee}}</td>
                                                        <td>{{$payment_item_fee->payment_item->paymentItemCategory->name}}</td>
                                                        <td>{{$payment_item_fee->updated_at}}</td>
                                                        <td><a href="/admin/cdpoints/{{$payment_item_fee->id}}/edit"><i
                                                                        class="fa fa-pencil"></i> Edit Cd Point</a></td>
                                                        <td><a href="/admin/cdpoints/{{$payment_item_fee->id}}"><i
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
--}}
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
