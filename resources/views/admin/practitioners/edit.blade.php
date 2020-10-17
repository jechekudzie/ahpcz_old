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
                <a href="/admin/practitioners/{{$practitioner->id}}" class="btn btn-success"> Dashboard</a>
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
                                        <h4 class="card-title">
                                            Practitioner: {{$practitioner->first_name.' '.$practitioner->last_name}}</h4>
                                        <h6 class="card-subtitle">Update practitioner personal information</h6>

                                        <form action="/admin/practitioners/{{$practitioner->id}}" method="post"
                                              id="practitioner_form"
                                              class="validation-wizard wizard-circle">
                                        {{method_field('PATCH')}}
                                        {{csrf_field()}}
                                        <!-- Step 1 -->
                                            <h3>Personal Info</h3>
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
                                                                    <option value="{{$title->id}}" @if($title->id ==$practitioner->title_id){{'selected'}}@endif>{{$title->name}}</option>
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
                                                                    <option value="{{$gender->id}}" @if($gender->id ==$practitioner->gender_id){{'selected'}}@endif >{{$gender->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="webUrl3">Identification/passport Number
                                                                :</label>
                                                            <input type="text" class="form-control"
                                                                   value="{{$practitioner->id_number}}"
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
                                                                   value="{{$practitioner->first_name}}">
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
                                                                   value="{{$practitioner->last_name}}"
                                                                   id="wlastName2" name="last_name">
                                                            <small><code>Last name as per Identification Card</code>.
                                                            </small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wphoneNumber2">Previous Names :</label>
                                                            <input type="text" class="form-control"
                                                                   value="{{$practitioner->previous_name}}"
                                                                   name="previous_name" id="wphoneNumber2">
                                                            <div class="form-control-feedback">
                                                                <small>Previous names <code>if any.</code>.
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Date Of Birth</label>
                                                            <input type="text" name="dob" value="{{$practitioner->dob}}"
                                                                   class="form-control" id="mdate">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Registration Date</label>
                                                            <input type="text" name="registration_date" value="{{$practitioner->registration_date}}"
                                                                   class="form-control" id="registration_date">
                                                        </div>
                                                    </div>

                                                </div>
                                            </section>
                                            <!-- Step 2 -->
                                            <h3>Geo Location</h3>
                                            <section>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Nationality : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control "
                                                                    id="wlocation2" name="nationality_id">
                                                                <option value="">Select nationality</option>
                                                                @foreach($nationalities as $nationaly)
                                                                    <option value="{{$nationaly->id}}" @if($nationaly->id ==$practitioner->nationality_id){{'selected'}}@endif>{{$nationaly->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="form-control-feedback">
                                                                <small><code>Pick a country of origin.</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Province : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    id="provinces" name="province_id">
                                                                <option value="">Select province</option>
                                                                @foreach($provinces as $province)
                                                                    <option value="{{$province->id}}" @if($province->id ==$practitioner->province_id){{'selected'}}@endif>{{$province->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="form-control-feedback">
                                                                <small><code>Pick a province in which you reside in here
                                                                        in zimbabwe.</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> City/Location : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    id="districts" name='city_id'>
                                                                <option value=''>Select city/location</option>

                                                            </select>
                                                            <div class="form-control-feedback">
                                                                <small><code>Pick a city in which you reside in here in
                                                                        zimbabwe.</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="my_id" id="my_id"
                                                           value="{{$practitioner->city_id}}">


                                                </div>
                                            </section>
                                            <!-- Step 3 -->
                                            <h3>Professional info</h3>
                                            <section>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Profession : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control "
                                                                    id="professions" name="profession_id">
                                                                <option value="">Select profession</option>
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
                                                    <input type="hidden" id="pq_id" value="{{$practitioner->professional_qualification_id}}">
                                                    <input type="hidden" id="profession_value" value="{{$practitioner->profession_id}}">

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Qualification Category :
                                                                <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
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

                                                    <input type="hidden" id="checkqualcategory"  value="{{$practitioner->qualification_category_id}}">

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
                                                            <label for="wphoneNumber2">University/College/Training
                                                                Center :</label>
                                                            <input type="text" class="form-control"
                                                                   id="discredited_institution"
                                                                   name="institution" value="{{$practitioner->institution}}">
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="accreInst_id"
                                                           value="{{$practitioner->accredited_institution_id}}">

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Commencement Date</label>
                                                            <input type="text" name="commencement_date" value="{{$practitioner->commencement_date}}"
                                                                   class="form-control" id="commencement_date">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Completion Date</label>
                                                            <input type="text" name="completion_date" value="{{$practitioner->completion_date}}"
                                                                   class="form-control" id="completion_date">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wphoneNumber2"> Registration Number:</label>
                                                        <input type="text" class="form-control"

                                                               name="registration_number" value="{{$practitioner->registration_number}}">
                                                    </div>
                                                </div>
                                                <div id="result" class="col-md-6">

                                                </div>
                                            </section>

                                            <h3>Payment Info</h3>
                                            <section>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Register  : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control "
                                                                    id="wlocation2" name="register_category_id">
                                                                <option value="">Select Register</option>
                                                                @foreach($register_categories as $register_category)
                                                                    <option value="{{$register_category->id}}" @if($register_category->id==$practitioner->register_category_id){{'selected'}}@endif >{{$register_category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="form-control-feedback">
                                                                <small><code>Choose your renewal category for this
                                                                        application.</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Renewal Category : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control "
                                                                    id="wlocation2" name="renewal_category_id">
                                                                <option value="">Select Renewal Category</option>
                                                                @foreach($renewal_categories as $renewal_category)
                                                                    <option value="{{$renewal_category->id}}" @if($renewal_category->id==$practitioner->renewal_category_id){{'selected'}}@endif >{{$renewal_category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="form-control-feedback">
                                                                <small><code>Choose your renewal category for this
                                                                        application.</code>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Payment method : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    id="wlocation2" name="payment_method_id">
                                                                <option value="">Select payment method</option>
                                                                @foreach($payment_methods as $payment_method)
                                                                    <option value="{{$payment_method->id}}" @if($payment_method->id==$practitioner->payment_method_id){{'selected'}}@endif>{{$payment_method->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="form-control-feedback">
                                                                <small><code>Choose your preferred payment
                                                                        method.</code>
                                                                </small>
                                                            </div>
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
@endsection

@section('plugins-js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.0.7/jquery.steps.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.0.7/jquery.steps.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#provinces").change(function () {
                var province_id = $(this).val();
                //var dataString = id;

                $.ajax
                ({
                    type: "GET",
                    url: "/admin/get_districts/" + province_id,
                    data: province_id,
                    cache: false,
                    success: function (html) {
                        $("#districts").html(html);
                    }
                });
            });

        });
        $('.validation-wizard').steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            enableFinishButton: !1,
            onStepChanged: function (event, currentIndex, priorIndex) {
                if (currentIndex == 3) {
                    var $input = $('<input style="margin-left: 5px" type="submit" class="btn btn-success btn-xs" value="Update Practitioner"/>');
                    $input.appendTo($('ul[aria-label=Pagination]'));
                } else {
                    $('ul[aria-label=Pagination] input[value="Update Practitioner"]').remove();
                }
            }
        });
    </script>
    <script type="text/javascript" src="{{asset('js/functions.js')}}"></script>
    <script src="{{asset('../assets/node_modules/moment/moment.js')}}"></script>
    <script src="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <script type="text/javascript">
        // MAterial Date picker
        $('#mdate').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'YYYY-MM-DD'
        });

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
            var profession_id = $("#profession_value").val();

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
