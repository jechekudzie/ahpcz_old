@extends('layouts.admin')
@section('plugins-css')
    <link href="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
          rel="stylesheet">
    <link href="{{asset('../assets/node_modules/wizard/steps.css')}}" rel="stylesheet">
@stop

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
                <a href="/admin/practitioners" class="btn btn-success"> Practitioners</a>
            </div>

            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add practitioner</li>
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
                                    <div
                                        style="color: white" class="alert alert-success alert-rounded col-md-6"><i
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
                                        <h4 class="card-title">Add New Practitioner</h4>
                                        <h6 class="card-subtitle">If you are new to this system, please follow this link
                                            to view practitioner registration requirements before you proceed</h6>

                                        <form action="/admin/practitioners" method="post" id="practitioner_form"
                                              class="validation-wizard wizard-circle">
                                        {{csrf_field()}}
                                        <!-- Step 1 -->
                                            <h3>Personal details</h3>
                                            <hr/>
                                            <section>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Title : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    id="wlocation2" name="title_id">
                                                                <option value="">Select Title</option>
                                                                @foreach($titles as $title)
                                                                    <option value="{{$title->id}}" @if($title->id ==old('title_id')){{'selected'}}@endif>{{$title->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Gender : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    id="wlocation2" name="gender_id">
                                                                <option value="">Select Gender</option>
                                                                @foreach($genders as $gender)
                                                                    <option value="{{$gender->id}}" @if($gender->id ==old('gender_id')){{'selected'}}@endif >{{$gender->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="webUrl3">Identification/passport Number
                                                                :</label>
                                                            <input type="text" class="form-control"
                                                                   value="{{old('id_number')}}"
                                                                   name="id_number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wfirstName2"> First Name : <span class="danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                   id="wfirstName2" name="first_name"
                                                                   value="{{old('first_name')}}">
                                                            <div class="form-control-feedback">
                                                                <small><code>First name or names if more than
                                                                        one.</code>.
                                                                </small>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wlastName2"> Last Name : <span
                                                                        class="danger">*</span> </label>
                                                            <input type="text" class="form-control "
                                                                   value="{{old('last_name')}}"
                                                                   id="wlastName2" name="last_name">
                                                            <small><code>Last name as per Identification Card</code>.
                                                            </small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wphoneNumber2">Previous Names :</label>
                                                            <input type="text" class="form-control"
                                                                   value="{{old('previous_name')}}"
                                                                   name="previous_name" id="wphoneNumber2">
                                                            <div class="form-control-feedback">
                                                                <small>Previous names <code>if any.</code>.
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wphoneNumber2">Email Address :</label>
                                                            <input type="email" class="form-control"
                                                                   value="{{old('email')}}"
                                                                   name="email" id="wphoneNumber2">
                                                            <div class="form-control-feedback">
                                                                <small>Email Address <code></code>.
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wphoneNumber2"> Registration Number:</label>
                                                            <input type="text" class="form-control"
                                                                   name="registration_number">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Register Category : <span
                                                                    class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    id="wlocation2" {{--required--}} name="register_category_id">
                                                                <option value="">Select Register Category</option>
                                                                @foreach($register_categories as $register_category)
                                                                    <option
                                                                        value="{{$register_category->id}}" >
                                                                        {{$register_category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wphoneNumber2"> Registration Date:</label>
                                                            <input type="text" id="registration_date" class="form-control"
                                                                   name="registration_date">
                                                        </div>
                                                    </div>

                                                </div>
                                            </section>

                                            <!-- Step 2 -->
                                            <h3>Professional details</h3>
                                            <section>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Qualification Category :
                                                                <span
                                                                    class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control" {{--required--}} onchange="myFunction()"
                                                                    id="qualification_category" name="qualification_category_id">
                                                                <option value="">Select Qualification Category</option>
                                                                @foreach($qualification_categories as $qualification_category)
                                                                    <option value="{{$qualification_category->id}}" >{{$qualification_category->name}}</option>
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

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Profession : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control " {{--required--}}
                                                                    id="professions" name="profession_id">
                                                                <option value="">Select Profession</option>
                                                                @foreach($professions as $profession)
                                                                    <option value="{{$profession->id}}">{{$profession->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="form-control-feedback">
                                                                <small><code>Pick your profession.</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div id="pq_div" style="display: none;"  class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Professional Qualifications : <span
                                                                    class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    id="professional_qualifications" name='professional_qualification_id'>
                                                                <option value=''>Select Professional Qualification</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div id="pq_name_div" style="display: none;" class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wphoneNumber2">Professional Qualification name :</label>
                                                            <input  type="text" class="form-control" name="professional_qualification_name">
                                                        </div>
                                                    </div>


                                                    <div id="accredited_institution_div" style="display: none;" class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Accredited Institutions : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    id="accredited_institutions" name='accredited_institution_id'>
                                                                <option value=''>Select Accredited Institutions</option>

                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div id="institution_div" style="display: none;" class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wphoneNumber2">University/College/Training Center :</label>
                                                            <input  type="text" class="form-control"
                                                                   id="discredited_institution"
                                                                   name="institution">
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Commencement Date</label>
                                                            <input type="text" name="commencement_date"
                                                                   class="form-control" id="commencement_date">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Completion Date</label>
                                                            <input type="text" name="completion_date" value=""
                                                                   class="form-control" id="completion_date">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div id="result" class="col-md-6">

                                                </div>

                                            </section>


                                            <h3>Employment Status & residence</h3>
                                            <section>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Employment Status :
                                                                <span
                                                                    class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control" onchange="myFunction()"
                                                                    id="" name="employment_status_id">
                                                                <option value="">Employment Status</option>
                                                                @foreach($employment_statuses as $employment_status)
                                                                    <option value="{{$employment_status->id}}" >{{$employment_status->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Residence : <span
                                                                    class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control "
                                                                    id="" name="employment_location_id">
                                                                <option value="">Choose Residence</option>
                                                                @foreach($employment_locations as $employment_location)
                                                                    <option value="{{$employment_location->id}}">{{$employment_location->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </section>
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
@stop

@section('plugins-js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.0.7/jquery.steps.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.0.7/jquery.steps.min.js"></script>

    <script type="text/javascript">
        $('.validation-wizard').steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            enableFinishButton: !1,
            onStepChanged: function (event, currentIndex, priorIndex) {
                if (currentIndex == 2) {
                    var $input = $('<input style="margin-left: 5px" type="submit" class="btn btn-success btn-xs" value="Add Practitioner"/>');
                    $input.appendTo($('ul[aria-label=Pagination]'));
                } else {
                    $('ul[aria-label=Pagination] input[value="Add Practitioner"]').remove();
                }
            }
        });

    </script>

    <script type="text/javascript" src="{{asset('js/functions.js')}}"></script>
    <script src="{{asset('../assets/node_modules/moment/moment.js')}}"></script>
    <script src="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <script type="text/javascript">
        // MAterial Date picker
        $('#commencement_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'YYYY-MM-DD'
        });

        $('#completion_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'YYYY-MM-DD'
        });

        $('#registration_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'YYYY-MM-DD'
        });

        $(document).ready(function () {
            var province_id = $("#provinces").val();

            var my_id = $("#my_id").val();

            $.ajax
            ({
                type: "GET",
                url: "/dynamic/onload/" + province_id + "/" + my_id,
                data: province_id, my_id,
                cache: false,
                success: function (html) {

                    $("#districts").html(html);
                }
            });
        });

        $(document).ready(function () {
            var profession_id = $("#profession_id").val();

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



    </script>

@stop
