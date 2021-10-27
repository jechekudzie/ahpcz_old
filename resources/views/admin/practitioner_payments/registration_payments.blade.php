@extends('layouts.admin')
@section('title','AHPCZ - Create Institution')
@section('plugins-css')
    <link
        href="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
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
                <a href="/admin/practitioners/{{$practitioner->id}}" class="btn btn-success">Dash
                    Board</a>
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
                                        <form
                                            action="/registration/make_registration_payment/{{$practitioner->id}}"
                                            method="post" id="" enctype="multipart/form-data">
                                            {{csrf_field()}}


                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Payment Items Category: <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control " required
                                                                id="payment_item_category_id"
                                                                name="payment_item_category_id">
                                                            <option value="">Choose Payment Type</option>
                                                            @foreach($payment_item_categories as $payment_item_category)
                                                                <option
                                                                    value="{{$payment_item_category->id}}" @if($payment_item_category->id==old('payment_item_category_id')){{'selected'}}@endif>{{$payment_item_category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Payment Item : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control " required
                                                                id="payment_item_id" name="payment_item_id">
                                                            <option value="">Choose Payment Type</option>

                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Amount Invoiced $USD</label>
                                                        <input id="usd" name="" disabled type="number" step="any"
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Amount Invoiced $ZWL</label>
                                                        <input type="number" step="any" disabled
                                                               class="form-control"
                                                               id="zwl">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="currency"
                                                               id="flexCheckDefault" value="1">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            $USD
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="currency"
                                                               id="flexCheckDefault" value="0">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            $ZWL
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Amount Paid (first choose your currency and then enter amount to pay in that currency</label>
                                                        <input id="usd" name="amount_paid" type="number" step="any"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <input type="hidden" id="rate" value="{{$rate->rate}}" name="rate">
                                                <input type="hidden" name="amount_invoiced" id="amount_invoiced" value="" name="rate">
                                                <br/>
                                                <br/>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Payment Channel : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control"
                                                                onchange="myPaymentChannels()" required
                                                                id="payment_channel_id" name="payment_channel_id">
                                                            <option value="">Payment Channel</option>
                                                            @foreach($payment_channels as $payment_channel)
                                                                <option
                                                                    value="{{$payment_channel->id}}" @if($payment_channel->id==old('payment_channels')){{'selected'}}@endif>{{$payment_channel->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Receipt Number</label>
                                                        <input type="text" name="receipt_number"
                                                               class="form-control">
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Proof Of Payment(Optional)</label>
                                                        <input type="file" name="pop" class="form-control">
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="submit" value="Make Payment" name="add"
                                                           class="btn btn-success btn-block">
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
    <script
        src="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
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
        $(document).ready(function () {
            $("#payment_item_category_id").change(function () {
                var payment_item_category_id = $(this).val();

                $.ajax
                ({
                    type: "GET",
                    url: "/renewal/payment_item_category_id/" + payment_item_category_id,
                    data: payment_item_category_id,
                    cache: false,
                    success: function (html) {
                        $("#payment_item_id").html(html)
                    }
                });
            });

        });


        $(document).ready(function () {
            $("#payment_item_id").change(function () {
                var payment_item_id = $(this).val();
                var rate = $("#rate").val();


                //alert(rate);

                $.ajax
                ({
                    type: "GET",
                    url: "/registration/payment_items/" + payment_item_id + "/",
                    data: payment_item_id,
                    cache: false,
                    success: function (html) {
                        $("#usd").val(html)
                        $("#zwl").val(html * rate)
                        $("#amount_invoiced").val(html)

                    }
                });
            });

        });

    </script>



@endsection

