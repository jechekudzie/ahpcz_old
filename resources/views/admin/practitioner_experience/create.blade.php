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
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

                <a href="/admin/practitioners/{{$practitioner->id}}" class="btn btn-success"></i> Dash Board</a>
            </div>

            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add practitioner experience</li>
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
                                        <h4 class="card-title">{{$practitioner->first_name.' '.$practitioner->last_name}}</h4>
                                        <h5 class="card-title">Add Practitioner Employer</h5>
                                        <form action="/admin/practitioners/experience/{{$practitioner->id}}/store"
                                              method="post" id="">
                                            {{csrf_field()}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wphoneNumber2">Employer Name
                                                            :</label>
                                                        <input type="text" class="form-control"
                                                               name="name" value="{{old('name')}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="wphoneNumber2">Email
                                                            :</label>
                                                        <input type="text" class="form-control"
                                                               value="{{old('email')}}"
                                                               name="email">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="wphoneNumber2">Phone
                                                            :</label>
                                                        <input type="text" class="form-control"
                                                               id="" value="{{old('phone')}}"
                                                               name="phone">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="wphoneNumber2">Job title
                                                            :</label>
                                                        <input type="text" class="form-control"
                                                               id="" value="{{old('job_title')}}"
                                                               name="job_title">
                                                    </div>

                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wphoneNumber2">Business Address :</label>
                                                        <input class="form-control"
                                                                  name="business_address" value="{{old('business_address')}}"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="wphoneNumber2">Contact Person
                                                            :</label>
                                                        <input type="text" class="form-control"
                                                               id="" value="{{old('contact_person')}}"
                                                               name="contact_person">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Commencement Date</label>
                                                        <input type="text" name="commencement_date" value="{{old('commencement_date')}}" class="form-control" id="commencement_date">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Resignation Date</label>
                                                        <input type="text" name="resignation_date" value="{{old('commencement_date')}}" class="form-control" id="resignation_date">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Province : <span
                                                                    class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control" required
                                                                id="provinces" name="province_id">
                                                            <option value="all">Select province</option>
                                                            @foreach($provinces as $province)
                                                                <option value="{{$province->id}}" @if($province->id ==old('province_id')){{'selected'}}@endif>{{$province->name}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> City/Location : <span
                                                                    class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control"
                                                                id="districts" name='city_id'>
                                                            <option value='0'>Select city/location</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="submit" name="add" class="btn btn-success btn-block">
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

