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
                        <li class="breadcrumb-item active">Make payments</li>
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
                                        <h4 class="card-title">Registration fee:
                                            ${{$fee = ($registration_fee->fee*0.15) + $registration_fee->fee }} </h4>
                                        @if($practitioner->payment_method_id == null && $practitioner->renewal_category_id ==null)
                                            <form action="/admin/practitioners/payment_requirement/{{$practitioner->id}}/payments_registration"
                                                  method="post" id="" enctype="multipart/form-data">
                                                {{method_field('PATCH')}}
                                                {{csrf_field()}}

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Payment Method : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control " required
                                                                    id="payment_method_id" name="payment_method_id">
                                                                <option value="">Choose Payment Method</option>
                                                                @foreach($payment_methods as $payment_method)
                                                                    <option value="{{$payment_method->id}}" @if($payment_method->id==old('payment_method')){{'selected'}}@endif>{{$payment_method->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Renewal Category : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    onchange="myPaymentChannels()" required
                                                                    id="renewal_category_id" name="renewal_category_id">
                                                                <option value="">Choose Renewal Category</option>
                                                                @foreach($renewal_categories as $renewal_category)
                                                                    <option value="{{$renewal_category->id}}" @if($renewal_category->id==old('renewal_category_id')){{'selected'}}@endif>{{$renewal_category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Register Category : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    required
                                                                    id="" name="register_category_id">
                                                                <option value="">Choose Register Category</option>
                                                                @foreach($register_categories as $register_category)
                                                                    <option value="{{$register_category->id}}" @if($register_category->id==old('register_category_id')){{'selected'}}@endif>{{$register_category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="submit" name="add"
                                                               value="Update Payment Requirements"
                                                               class="btn btn-success btn-block">
                                                    </div>
                                                </div>

                                            </form>
                                        @else
                                            <form action="/admin/practitioners/registration/{{$practitioner->id}}/store"
                                                  method="post" id="" enctype="multipart/form-data">
                                                {{csrf_field()}}

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Period : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control " required
                                                                    id="renewal_period" name="renewal_period_id">
                                                                <option value="">Choose period</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="wlocation2"> Payment Channel : <span
                                                                        class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control"
                                                                    onchange="myPaymentChannels()" required
                                                                    id="payment_channel_id" name="payment_channel_id">
                                                                <option value="">Payment Channel</option>
                                                                @foreach($payment_channels as $payment_channels)
                                                                    <option value="{{$payment_channels->id}}" @if($payment_channels->id==old('payment_channels')){{'selected'}}@endif>{{$payment_channels->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Amount Invoiced</label>
                                                            <input type="number" step="any" value="{{$fee}}" disabled=""
                                                                   name="" class="form-control">
                                                        </div>
                                                    </div>

                                                    <input type="hidden" value="{{$fee}}" name="amount_invoiced"
                                                           class="form-control">


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Amount Paid</label>
                                                            <input type="number" step="any" name="amount_paid"
                                                                   value="{{$practitioner->dob}}" class="form-control"
                                                                   id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Payment Date</label>
                                                            <input type="text" name="payment_date"
                                                                   value="" class="form-control"
                                                                   id="commencement_date">
                                                        </div>
                                                    </div>

                                                    <script>
                                                        function myPaymentChannels() {
                                                            var x = document.getElementById("payment_channel_id").value;
                                                            if (x == 1) {
                                                                document.getElementById("ecocash").style.display = 'block';
                                                                document.getElementById("bank").style.display = 'none';
                                                                document.getElementById("swipe").style.display = 'none';
                                                            } else if (x == 2) {
                                                                document.getElementById("bank").style.display = 'block';
                                                                document.getElementById("ecocash").style.display = 'none';
                                                                document.getElementById("swipe").style.display = 'none';
                                                            } else if (x == 3) {
                                                                document.getElementById("swipe").style.display = 'block';
                                                                document.getElementById("bank").style.display = 'none';
                                                                document.getElementById("ecocash").style.display = 'none';
                                                            } else {
                                                                document.getElementById("ecocash").style.display = 'none';
                                                                document.getElementById("bank").style.display = 'none';
                                                                document.getElementById("swipe").style.display = 'none';
                                                            }
                                                        }
                                                    </script>

                                                    <div id="receipt_number" class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Receipt Number</label>
                                                            <input type="text" name="receipt_number"
                                                                   value="{{$practitioner->dob}}" class="form-control"
                                                                   id="">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="submit" name="add"
                                                               class="btn btn-success btn-block">
                                                    </div>
                                                </div>

                                                <div id="result" class="col-md-6">

                                                </div>
                                            </form>
                                        @endif
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

        //periods
        var min = 2008;
        var max = new Date().getFullYear() + 5,
            select = document.getElementById('renewal_period');

        for (var i = min; i <= max; i++) {
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = i;
            select.appendChild(opt);
        }

    </script>



@endsection

