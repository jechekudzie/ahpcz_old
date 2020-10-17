@extends('layouts.admin')
@section('title','AHPCZ - Create Institution')
@section('plugins-css')
<link href="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
      rel="stylesheet">
<link href="{{asset('../assets/node_modules/wizard/steps.css')}}" rel="stylesheet">
@endsection
<?php
use Carbon\CarbonInterval;

function getDifference($created_at, $now) {

    $days = $created_at->diffInDays($now);
    $hours = $created_at->diffInHours($now->subDays($days));
    $minutes = $created_at->diffInMinutes($now->subHours($hours));
    $seconds = $created_at->diffInSeconds($now->subMinutes($minutes));

    return CarbonInterval::days($days)->hours($hours)->minutes($minutes)->seconds($seconds)->forHumans();
}
?>
@section('content')
<link rel="stylesheet" href="{{asset('css/style-horizontal.min.css')}}">

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

        </div>

        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">view</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                        </div>
                        <div class="col-8">
                            @if($errors->any())
                            @include('errors')
                            @endif
                            @if (session('message'))
                            <div class="alert alert-success alert-rounded col-md-6"><i
                                    class="fa fa-check-circle"></i> {{ session('message') }}
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            @endif
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card wizard-content">

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">New Applications</h4>
                                        <div class="table-responsive m-t-40">
                                            <table id="subscriptions"
                                                   class="display nowrap table table-hover table-striped table-bordered"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Practitioner</th>
                                                    <th>Profession</th>
                                                    <th>Professional Qualification</th>
                                                    <th>Application Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Practitioner</th>
                                                    <th>Profession</th>
                                                    <th>Professional Qualification</th>
                                                    <th>Application Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>

                                                @foreach(auth()->user()->unreadNotifications as $notification)

                                                <tr>
                                                    <td>{{$notification->data['first_name'].' '.$notification->data['last_name']}}</td>
                                                    <td>{{$notification->data['profession']['name']}}</td>
                                                    <td>{{$notification->data['professional_qualification']['name']}}</td>
                                                    <td>{{ getDifference($notification['created_at'],now()) }} ago</td>
                                                    <td>{{$notification->data['professional_qualification']['name']}}</td>
                                                    <td>{{$notification->data['professional_qualification']['name']}}</td>

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

    $('#subscriptions').DataTable({
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
</script>
@endsection


