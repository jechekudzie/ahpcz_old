@extends('layouts.admin')
@section('title','AHPCZ - Create Institution')
@section('plugins-css')
    <link href="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
          rel="stylesheet">
    <link href="{{asset('../assets/node_modules/wizard/steps.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                @can('admin')
                    <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
                @endcan
                <a href="/admin/practitioners/{{$practitioner->id}}" class="btn btn-success"></i> Dash
                    Board</a>
            </div>

            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Internship and placement</li>
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

                        </div>

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
                                                    <div class="alert alert-success alert-rounded col-md-12"><i
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
                                                        <h4 class="card-title">{{$practitioner->first_name.' '.$practitioner->last_name}}</h4>
                                                        <h5>Placement Forms Required</h5>
                                                        <form action="/admin/practitioners/{{$practitioner->id}}/storePlacement"
                                                              method="post" id="" enctype="multipart/form-data">
                                                            {{csrf_field()}}

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wlocation2"> Period : <span
                                                                                    class="danger">*</span>
                                                                        </label>
                                                                        <select class="custom-select form-control "
                                                                                required id="renewal_period"
                                                                                name="renewal_period_id">
                                                                            <option value="">Choose period</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Upload Place Letter</label>
                                                                        <input type="file" name="file"
                                                                               class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="submit" value="Upload Placement Letter"
                                                                           name="add" class="btn btn-success btn-block">
                                                                </div>
                                                            </div>

                                                            <div id="result" class="col-md-6">

                                                            </div>
                                                        </form>
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
        $('#completion_date').bootstrapMaterialDatePicker({
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

        var min = 2008;
        var max = new Date().getFullYear() + 5,
            select = document.getElementById('renewal_period');

        for (var i = min; i <= max; i++) {
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = i;
            select.appendChild(opt);
        }


        var min1 = 2008;
        var max1 = new Date().getFullYear() + 5,
            select = document.getElementById('renewal_period1');

        for (var x = min1; x <= max1; x++) {
            var opt1 = document.createElement('option');
            opt1.value = x;
            opt1.innerHTML = x;
            select.appendChild(opt1);
        }
    </script>



@endsection

