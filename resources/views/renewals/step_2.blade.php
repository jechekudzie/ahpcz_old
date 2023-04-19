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
                                      enctype="multipart/form-data" method="post"
                                      class="m-t-40"
                                      novalidate>
                                    {{csrf_field()}}
                                    <div class="card ">
                                        <div class="card-body">
                                            <h5 class="card-title" style="color: black; font-weight: bolder;">
                                                Renewal</h5>
                                            <p class="card-text"></p>
                                            <div>
                                                @if($status == 1)
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <h5 style="color: black; font-weight: bolder">USD</h5>

                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="radio"
                                                                        name="employment_status_id"
                                                                        id="exampleRadios1"
                                                                        value="{{$employment_status->id}}"
                                                                    @if($status == 1)
                                                                        {{$amount_invoiced}}
                                                                        @endif
                                                                    >
                                                                    <label class="form-check-label"
                                                                           for="exampleRadios1">
                                                                        @if($status == 1)
                                                                            {{$amount_invoiced}}
                                                                        @endif
                                                                    </label>

                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <button type="submit"
                                                                            class="btn btn-success btn-block"
                                                                            style="color: white;">Next
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <h5 style="color: black; font-weight: bolder">USD</h5>

                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="radio"
                                                                        name="employment_status_id"
                                                                        id="exampleRadios1"
                                                                        value="{{$employment_status->id}}"
                                                                    @if($status == 1)
                                                                        {{$amount_invoiced}}
                                                                        @endif
                                                                    >
                                                                    <label class="form-check-label"
                                                                           for="exampleRadios1">
                                                                        @if($status == 1)
                                                                            {{$amount_invoiced}}
                                                                        @endif
                                                                    </label>

                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <button type="submit"
                                                                            class="btn btn-success btn-block"
                                                                            style="color: white;">Next
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($status == 0)
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <h5 style="color: black; font-weight:
                                                                bolder">Select last renewal period</h5>
                                                            <form method="post" action="{{url('/renewals/new/step_1/'.$practitioner->id)}}"
                                                                  enctype="multipart/form-data"
                                                                  class="m-t-40"
                                                                  novalidate>
                                                                {{csrf_field()}}
                                                                <div class="form-group">
                                                                    <div class="form-check">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="wlocation2"> Last Renewal
                                                                                 Period   : <span
                                                                                        class="danger">*</span>
                                                                                </label>
                                                                                <select class="custom-select form-control"
                                                                                        name="last_renewal_period">
                                                                                    <option value="">Choose Period</option>
                                                                                    @for($x =date('Y')-1;$x >= 2008;$x--)
                                                                                        <option value="{{$x}}">{{$x}}</option>
                                                                                    @endfor
                                                                                </select>
                                                                            </div>
                                                                            <input name="dob" value="{{$data['dob']}}">
                                                                            <input name="certificate_request" value="{{$data['certificate_request']}}">
                                                                            <input name="employment_location_id"
                                                                                   value="{{$data['employment_location_id']}}">
                                                                            <input name="employment_status_id"
                                                                                   value="{{$data['employment_status_id']}}">
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                                        <input type="submit"
                                                                                class="btn btn-success btn-block"
                                                                                style="color: white;" value="submit">

                                                                    </div>
                                                                </div>
                                                            </form>


                                                        </div>

                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>


                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <a href="#" class="btn btn-primary btn-block"
                                               style="color: white;">Previous</a>
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

        var min = 2008;
        var max = new Date().getFullYear() + 5,
            select = document.getElementById('period');

        for (var i = min; i <= max; i++) {
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = i;
            select.appendChild(opt);
        }
    </script>

@stop



