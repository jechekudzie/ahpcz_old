@extends('layouts.admin')
@section('plugins-css')

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://code.jquery.com//resources/demos/style.css">
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">

                <a href="{{url('/admin/practitioners/'.$practitioner->id)}}" class="btn btn-success"> Back to
                    Practitioner dashboard</a>

            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>

                        <li class="breadcrumb-item active">Practitioners</li>
                    </ol>

                </div>
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
                                {{--@if($errors->any())
                                    @include('errors')
                                @endif--}}

                            </div>

                        </div>
                        <div class="row">

                            <div class="col-sm-12 col-md-1 col-lg-1"></div>
                            <div class="col-sm-12 col-md-10 col-lg-10">
                                <form method="post" action="{{url('/renewals/new/step_1/'.$practitioner->id)}}"
                                      enctype="multipart/form-data"
                                      class="m-t-40"
                                      novalidate>
                                    {{csrf_field()}}
                                        <div class="card ">
                                            <div class="card-header card-primary">
                                                {{date('Y')}} renewal
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title" style="color: black; font-weight: bolder;">Renewal</h5>
                                                <p class="card-text"> </p>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <div>
                                                                <div class="form-group"><!--I removed wire ignore -->
                                                                    <label style="color: black;font-weight: bolder;">Date Of
                                                                        Birth</label>

                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                <span class="input-group-text">D.O.B @if($dob != null)
                                                                        ({{date('Y') - date('Y', strtotime($dob))}})@endif</span>
                                                                        </div>
                                                                        <input type="text"
                                                                               name="dob"
                                                                               class="form-control datepicker"
                                                                               aria-label="Dirt Of Birth" id="dp"
                                                                               value="{{$practitioner->dob}}"
                                                                               onclick="myDatePicker()"
                                                                               data-provide="datepicker" data-date-autoclose="true"
                                                                               data-date-format="yyyy-mm-dd"
                                                                               data-date-today-highlight="true"
                                                                               onchange="this.dispatchEvent(new InputEvent('input'))"
                                                                        >
                                                                    </div>
                                                                    <span
                                                                        style="color: red;">@error('dob'){{$message}}@enderror
                                                        </span>
                                                                </div>

                                                            </div>
                                                            <hr/>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <h5 style="color: black; font-weight: bolder">Employment Status</h5>
                                                            <p style="color: yellowgreen;">Please choose your employment status.</p>
                                                            @foreach($employment_statuses as $employment_status)
                                                                <div class="form-group">
                                                                    <div class="form-check">
                                                                        <input
                                                                               class="form-check-input"
                                                                               type="radio"
                                                                               name="employment_status_id"
                                                                               id="exampleRadios1"
                                                                               value="{{$employment_status->id}}"
                                                                            {{$employment_status->id == $practitioner->employment_status_id ? 'checked': ''}}
                                                                        >
                                                                        <label class="form-check-label" for="exampleRadios1">
                                                                            {{$employment_status->name}}
                                                                        </label>
                                                                        <p style="color: yellowgreen;">{{$employment_status->description}}</p>
                                                                    </div>
                                                                </div>

                                                            @endforeach
                                                            <span
                                                                style="color: red;">@error('employment_status_id'){{$message}}@enderror</span>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <h5 style="color: black; font-weight: bolder">Residence</h5>
                                                            <p style="color: yellowgreen;">Choose if one should be either foreign
                                                                based
                                                                or local based</p>
                                                            @foreach($employment_locations as $employment_location)
                                                                <div class="form-group">
                                                                    <div class="form-check">
                                                                        <input
                                                                               class="form-check-input"
                                                                               type="radio"
                                                                               name="employment_location_id"
                                                                               id="exampleRadios1"
                                                                               value="{{$employment_location->id}}"
                                                                            {{$employment_location->id == $practitioner->employment_location_id ? 'checked': ''}}
                                                                        >
                                                                        <label class="form-check-label" for="exampleRadios1">
                                                                            {{$employment_location->name}}
                                                                        </label>
                                                                        <p style="color: yellowgreen;">{{$employment_location->description}}</p>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            @if ($errors->any()) <span
                                                                style="color: red;"> @error('employment_location_id'){{$message}}@enderror </span>@endif

                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <h5 style="color: black; font-weight: bolder">Certificate request</h5>
                                                            <p style="color: yellowgreen;">Please specify if a certificate can be
                                                                issued
                                                                in
                                                                this criteria.</p>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input  class="form-check-input"
                                                                           type="radio"
                                                                           name="certificate_request"
                                                                           id="exampleRadios1" value="1">
                                                                    <label class="form-check-label" for="exampleRadios1">
                                                                        {{'Yes'}}
                                                                    </label>
                                                                    <p style="color: yellowgreen;">{{'A certificate is to be issued'}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input  class="form-check-input"
                                                                           type="radio"
                                                                           name="certificate_request"
                                                                           id="exampleRadios1" value="2">
                                                                    <label class="form-check-label" for="exampleRadios1">
                                                                        {{'No'}}
                                                                    </label>
                                                                    <p style="color: yellowgreen;">{{'A certificate is not to be issued'}}</p>
                                                                </div>
                                                            </div>
                                                            @if ($errors->any())<span
                                                                style="color: red;">@error('certificate_request'){{$message}}@enderror</span>@endif


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>


                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <a href="#" class="btn btn-primary btn-block"
                                               style="color: white;">Previous</a>
                                        </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <button type="submit"  class="btn btn-success btn-block"
                                                   style="color: white;">Next</button>
                                            </div>

                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@stop

<!-- Scripts -->
@section('plugins-js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.0.7/jquery.steps.js"></script>
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

     </script>--}}

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        // jquery Date picker
        function myDatePicker() {
            $('#dp').datepicker({
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:+nn",
                autoClose: true
            });
            $('#dp').datepicker('show');

        }

        function myPaymentDate() {
            $('#payment_date').datepicker({
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:+nn",
                autoClose: true
            });
            $('#payment_date').datepicker('show');

        }

        var min =  2008;
        var max = new Date().getFullYear() + 5,
            select = document.getElementById('period');

        for (var i = min; i<=max; i++){
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = i;
            select.appendChild(opt);
        }
    </script>

@stop



