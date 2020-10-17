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
                <a href="/admin/practitioners/{{$practitioner->id}}" class="btn btn-success"></i> Dash Board</a>
            </div>

            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit practitioner qualification</li>
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
                                        <h5 class="card-title">Update Practitioner Qualifications</h5>
                                        <form action="/admin/practitioners/qualifications/{{$practitioner->id}}/storePrimary"
                                              method="post" id="practitioner_form" class="">
                                            {{method_field('PATCH')}}
                                            {{csrf_field()}}

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Profession : <span
                                                                    class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control " required
                                                                id="professions" name="profession_id">
                                                            <option value="">Select Profession</option>
                                                            @foreach($professions as $profession)
                                                                <option value="{{$profession->id}}" @if($profession->id==$practitioner->profession_id){{'selected'}}@endif>{{$profession->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="form-control-feedback">
                                                            <small><code>Pick your profession.</code>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Professional Qualifications : <span
                                                                    class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control"
                                                                id="professional_qualifications"
                                                                name='professional_qualification_id'>
                                                            <option value='0'>Select Professional Qualification</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Qualification Category :
                                                            <span
                                                                    class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control" required
                                                                onchange="myFunction()"
                                                                id="qualification_category"
                                                                name="qualification_category_id">
                                                            <option value="">Select Qualification Category</option>
                                                            @foreach($qualification_categories as $qualification_category)
                                                                <option value="{{$qualification_category->id}}" @if($qualification_category->id==$practitioner->qualification_category_id){{'selected'}}@endif>{{$qualification_category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="form-control-feedback">
                                                            <small><code>Choose your qualification type, it can
                                                                    either be local or foreign depending on where
                                                                    you obtained it.</code>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div id="accredited_institution_div" style="display: none;"
                                                     class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Accredited Institutions : <span
                                                                    class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control"
                                                                id="accredited_institutions"
                                                                name='accredited_institution_id'>
                                                            <option value=''>Select Accredited Institutions</option>

                                                        </select>
                                                    </div>
                                                </div>


                                                <div id="institution_div" style="display: none;" class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wphoneNumber2">University/College/Training Center
                                                            :</label>
                                                        <input type="text" class="form-control"
                                                               id="discredited_institution"
                                                               name="institution">
                                                    </div>
                                                </div>


                                            </div>
                                            <input type="hidden" id="pq_id" value="{{$practitioner->professional_qualification_id}}">

                                            <input type="hidden" id="accreInst_id" value="{{$practitioner->accredited_institution_id}}">

                                            <input type="hidden" id="checkqualcategory"  value="{{$practitioner->qualification_category_id}}">

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Commencement Date</label>
                                                        <input type="text" name="commencement_date" value="{{$practitioner->commencement_date}}" class="form-control" id="commencement_date">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Completion Date</label>
                                                        <input type="text" name="completion_date" value="{{$practitioner->completion_date}}" class="form-control" id="completion_date">
                                                    </div>
                                                </div>




                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="submit" name="add" value="Update" class="btn btn-success btn-block">
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

        $(document).ready(function () {
            var profession_id = $("#professions").val();

            var pq_id = $("#pq_id").val();

            $.ajax
            ({
                type: "GET",
                url: "/admin/get_pq/" + profession_id + "/" + pq_id,
                data: profession_id, pq_id,
                cache: false,
                success: function (html) {

                    $("#professional_qualifications").html(html);
                }
            });
        });

        $(document).ready(function () {
            var professional_qualification_id = $("#pq_id").val();

            var accreInst_id = $("#accreInst_id").val();

            $.ajax
            ({
                type: "GET",
                url: "/admin/get_ai/" + professional_qualification_id + "/" + accreInst_id,
                data: professional_qualification_id, accreInst_id,
                cache: false,
                success: function (html) {
                    $("#accredited_institutions").html(html);
                }
            });
        });

        var x = document.getElementById("checkqualcategory").value;
        if (x == 1) {
            document.getElementById("accredited_institution_div").style.display = 'block';
            document.getElementById("institution_div").style.display = 'none';
        } else

        if (x == 2) {
            document.getElementById("institution_div").style.display = 'block';
            document.getElementById("accredited_institution_div").style.display = 'none';
        }  else {
            document.getElementById("institution_div").style.display = 'none';
            document.getElementById("accredited_institution_div").style.display = 'none';
        }
    </script>



@endsection

