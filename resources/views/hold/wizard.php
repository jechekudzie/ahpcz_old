@extends('layouts.admin')
@section('title','AHPCZ - Create Institution')
@section('plugins-css')
<link href="{{asset('../assets/node_modules/wizard/steps.css')}}" rel="stylesheet">
<link href="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
      rel="stylesheet">
{{--<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
</script>--}}
@endsection

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

            <a href="/admin/practitioners" class="btn btn-success"></i> Practitioners</a>
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

                            @if(!empty($message))
                            <div class="alert alert-success alert-rounded"><i
                                    class="fa fa-check-circle"></i> {{$message}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
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
                                    <form action="admin/practitioners" class="validation-wizard wizard-circle">
                                        {{csrf_field()}}
                                        <!-- Step 1 -->
                                        <h6>Step 1</h6>
                                        <hr/>
                                        <section>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Title : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control required"
                                                                id="wlocation2" name="title_id">
                                                            <option value="">Select Title</option>
                                                            @foreach($titles as $title)
                                                            <option value="{{$title->id}}">{{$title->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Gender : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control required"
                                                                id="wlocation2" name="gender_id">
                                                            <option value="">Select Gender</option>
                                                            @foreach($genders as $gender)
                                                            <option value="{{$gender->id}}">{{$gender->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Marital Status : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control required"
                                                                id="wlocation2" name="marital_status_id">
                                                            <option value="">Select Marital Status</option>
                                                            @foreach($marital_statuses as $marital_status)
                                                            <option value="{{$marital_status->id}}">{{$marital_status->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wfirstName2"> First Name : <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control required"
                                                               id="wfirstName2" name="first_name">
                                                        <div class="form-control-feedback">
                                                            <small><code>First name or names if more than
                                                                    one.</code>.
                                                            </small>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlastName2"> Last Name : <span
                                                                class="danger">*</span> </label>
                                                        <input type="text" class="form-control required"
                                                               id="wlastName2" name="last_name">
                                                        <small><code>Last name as per Identification Card</code>.
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wphoneNumber2">Previous Names :</label>
                                                        <input type="text" class="form-control" required
                                                               name="previous_name" id="wphoneNumber2">
                                                        <div class="form-control-feedback">
                                                            <small>Previous names <code>if any.</code>.
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date1">Date of Birth :</label>
                                                        <input type="date" name="dob" required class="form-control"
                                                               id="mdate">
                                                    </div>
                                                </div>

                                            </div>
                                        </section>
                                        <!-- Step 2 -->
                                        <h6>Step 2</h6>
                                        <section>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Nationality : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control required"
                                                                id="wlocation2" name="nationality_id">
                                                            <option value="">Select nationality</option>
                                                            @foreach($nationalities as $nationaly)
                                                            <option value="{{$nationaly->id}}">{{$nationaly->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="form-control-feedback">
                                                            <small><code>Pick a country of origin.</code>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Province : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control required"
                                                                id="provinces" name="province_id">
                                                            <option value="all">Select province</option>
                                                            @foreach($provinces as $province)
                                                            <option value="{{$province->id}}">{{$province->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="form-control-feedback">
                                                            <small><code>Pick a province in which you reside in here
                                                                    in zimbabwe.</code>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> City/Location : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control required"
                                                                id="districts" name='city_id'>
                                                            <option value='0'>Select city/location</option>

                                                        </select>
                                                        <div class="form-control-feedback">
                                                            <small><code>Pick a city in which you reside in here in
                                                                    zimbabwe.</code>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="webUrl3">Identification/passport Number
                                                            :</label>
                                                        <input type="text" class="form-control required"
                                                               id="webUrl3"
                                                               name="id_number"></div>
                                                </div>
                                            </div>
                                        </section>
                                        <!-- Step 3 -->
                                        <h6>Step 3</h6>
                                        <section>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Profession : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control required"
                                                                id="wlocation2" name="profession_id">
                                                            <option value="">Select profession</option>
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Profession Qualification Type :
                                                            <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control required"
                                                                id="wlocation2" name="qualification_category_id">
                                                            <option value="">Select qualification type</option>
                                                            @foreach($qualification_categories as $qualification_category)
                                                            <option value="{{$qualification_category->id}}">{{$qualification_category->name}}</option>
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
                                                        <label for="wlocation2"> Renewal Category : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control required"
                                                                id="wlocation2" name="renewal_category_id">
                                                            <option value="">Select Title</option>
                                                            @foreach($renewal_categories as $renewal_category)
                                                            <option value="{{$renewal_category->id}}">{{$renewal_category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="form-control-feedback">
                                                            <small><code>Choose your renewal category for this
                                                                    application.</code>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Payment method : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control required"
                                                                id="wlocation2" name="payment_method_id">
                                                            <option value="">Select payment method</option>
                                                            @foreach($payment_methods as $payment_method)
                                                            <option value="{{$payment_method->id}}">{{$payment_method->name}}</option>
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
<script src="{{asset('../assets/node_modules/moment/moment.js')}}"></script>
{{--
<script src="{{asset('../assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
--}}


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.js"></script>

{{--
<script src="{{asset('../assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
--}}
{{--
<script src="{{asset('../assets/node_modules/wizard/steps.js')}}"></script>
--}}
<script src="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script>
    // MAterial Date picker
    $('#mdate').bootstrapMaterialDatePicker({weekStart: 0, time: false});
    $('#timepicker').bootstrapMaterialDatePicker({format: 'HH:mm', time: true, date: false});
    $('#date-format').bootstrapMaterialDatePicker({format: 'dddd DD MMMM YYYY - HH:mm'});

    $('#min-date').bootstrapMaterialDatePicker({format: 'DD/MM/YYYY HH:mm', minDate: new Date()});

</script>
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

</script>


<script type="text/javascript">
    $('.validation-wizard').steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        enableFinishButton: !0,
        onStepChanged: function (event, currentIndex, priorIndex)
        {
            //
            if (currentIndex === 2) {
                var $input = $('<input type="submit" class="btn btn-success btn-lg" value="Submit Data"/>');
                $input.appendTo($('ul[aria-label=Pagination]'));
            } else {
                $('ul[aria-label=Pagination] input[value="Submit"]').remove();
            }
        },
    });
</script>


@endsection
