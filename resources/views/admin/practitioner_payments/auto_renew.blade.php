@extends('layouts.admin')
@section('title','AHPCZ - Add Application')
@section('plugins-css')
@section('content')

    <div class="container-fluid">
        <div class="row page-titles">

            <div class="col-md-5 align-self-center">
                @can('admin')
                    <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
                @endcan
                <a href="/admin/practitioners/{{$practitioner->id}}" class="btn btn-success"> Back</a>
            </div>

            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">
                            >@if($practitioner->title){{$practitioner->title->name}}@endif {{ucwords
                            ($practitioner->first_name).' '
                        .ucwords
                            ($practitioner->last_name)}}
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if(session('message'))
                        <div class="alert alert-success alert-rounded col-md-6">
                            <i class="fa fa-check-circle"></i> {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-body p-b-0">
                        <h4 class="card-title">@if($practitioner->title){{$practitioner->title->name}}@endif {{ucwords
                            ($practitioner->first_name).' '
                        .ucwords
                            ($practitioner->last_name)}}</h4>
                        <h4>Registration Number :
                            @if($practitioner->registration_number == null)
                                {{$practitioner->prefix.' (No Registration Number)'}} <a
                                    href="/admin/practitioners/generate_reg/{{$practitioner->profession_id}}/{{$practitioner->id}}">Generate</a>
                            @else
                                {{$practitioner->prefix.str_pad($practitioner->registration_number, 4, '0', STR_PAD_LEFT)}}
                            @endif
                        </h4>

                    </div>

                    <div class="row">
                        <div class="col-md-2"></div>
                        <br/>
                        <div class="col-md-8">
                            <h3>By clicking "Auto Renew" you are confirming that the practitioner is fully renewed.
                                This
                                action cannot be
                                reversed.</h3>
                            <form method="post" action="{{url('/admin/auto_renew/'.$practitioner->id)}}/store">
                                @csrf
                                <div class="form-group">
                                    <div class="controls">
                                        <input type="submit" name="add_profession"
                                               class="btn btn-rounded btn btn-block btn-success"
                                               value="Auto Renew">
                                    </div>

                                </div>
                            </form>
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
        $('#renewals').DataTable({
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

