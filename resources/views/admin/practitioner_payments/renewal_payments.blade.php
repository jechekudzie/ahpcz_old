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

                <a href="/admin/practitioners/{{$renewal->practitioner->id}}" class="btn btn-success"></i> Dash
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

                                        <h4 class="card-title">{{$renewal->practitioner->first_name.' '.$renewal->practitioner->last_name}}</h4>
                                        <form action="/admin/practitioners/renewals/{{$renewal->id}}/make_payment"
                                              method="post" id="" enctype="multipart/form-data">
                                            {{csrf_field()}}


                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2"> Payment Items  Category: <span
                                                                    class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control " required
                                                                id="payment_item_category_id" name="payment_item_category_id">
                                                            <option value="">Choose Payment Type</option>
                                                            @foreach($payment_item_categories as $payment_item_category)
                                                                <option value="{{$payment_item_category->id}}" @if($payment_item_category->id==old('payment_item_category_id')){{'selected'}}@endif>{{$payment_item_category->name}}</option>
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
                                                        <label>Amount Invoiced</label>
                                                        <input id="fee" disabled type="number" step="any"
                                                                class="form-control">
                                                    </div>
                                                </div>
                                                <input type="hidden" id="feehidden"  name="amount_invoiced">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Amount Paid</label>
                                                        <input type="number" step="any" name="amount_paid"
                                                                class="form-control"
                                                               id="">
                                                    </div>
                                                </div>
                                                <input type="hidden" value="{{$renewal->id}}" name="renewal_id"
                                                       id="renewal_id">

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

                                                <div  class="col-md-6">
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
                                                <div  class="col-md-6">
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
                var renewal = $("#renewal_id").val();

                $.ajax
                ({
                    type: "GET",
                    url: "/renewal/payment_items/" + payment_item_id + "/" + renewal,
                    data: payment_item_id,renewal,
                    cache: false,
                    success: function (html) {
                        $("#fee").val(html)
                        $("#feehidden").val(html)
                    }
                });
            });

        });

    </script>



@endsection

