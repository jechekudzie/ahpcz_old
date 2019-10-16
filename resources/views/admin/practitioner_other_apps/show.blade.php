@extends('layouts.admin')
@section('title','AHPCZ - Create Institution')
@section('plugins-css')
    <link href="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
          rel="stylesheet">
    <link href="{{asset('../assets/node_modules/wizard/steps.css')}}" rel="stylesheet">
@endsection

@section('content')
    <link rel="stylesheet" href="{{asset('css/style-horizontal.min.css')}}">

    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

                <a href="/admin/practitioners/{{$otherApplication->practitioner->id}}"
                   class="btn btn-success"></i> Dash Board</a>
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
                                    <div class="card-body">
                                        <h4 class="card-title">{{$otherApplication->practitioner->first_name.' '.$otherApplication->practitioner->last_name}}</h4>
                                        <h5 class="card-title">{{$otherApplication->paymentItem->name}}</h5>


                                        <div class="col-md-9 col-xs-12">
                                            <div class="box-content card">
                                                <h4 class="box-title"><i class="fa fa-history"></i> Application form

                                                </h4>

                                                <div class="card-content">
                                                    <ul class="dot-list">
                                                        <div class="row">
                                                            <div class="col-md-3 col-xs-6 b-r"><strong>Application Form
                                                                </strong>
                                                                <br>
                                                                <p class="text-muted">{{ucwords($otherApplication->paymentItem->name)}}</p>
                                                            </div>
                                                            <div class="col-md-3 col-xs-6 b-r"><strong>Application date

                                                                </strong>
                                                                <br>
                                                                <p class="text-muted">{{date("d F Y",strtotime($otherApplication->application_date))}}</p>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 col-xs-6 b-r"><strong>Form (s)</strong>
                                                                <br/>
                                                                <br/>
                                                                <br/>
                                                                @foreach($otherApplication->otherDocuments as $otherDocument)
                                                                    <a href="/{{$otherDocument->path}}" target="_blank">{{$otherDocument->name}}</a><br/><br/>
                                                                @endforeach
                                                            </div>

                                                        </div>



                                                    </ul>
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
    </div>
@endsection

@section('plugins-js')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.0.7/jquery.steps.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.0.7/jquery.steps.min.js"></script>
    <script type="text/javascript" src="{{asset('js/functions.js')}}"></script>

    <script src="{{asset('../assets/node_modules/moment/moment.js')}}"></script>
    <script src="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <script>
        // MAterial Date picker
        $('#resignation_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'YYYY-MM-DD'
        });

        $('#commencement_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'YYYY-MM-DD'
        });
        /*$('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });

        $('#min-date').bootstrapMaterialDatePicker({ format: 'DD/MM/YYYY HH:mm', minDate: new Date() });*/


    </script>



@endsection


