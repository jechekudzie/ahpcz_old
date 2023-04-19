@extends('layouts.admin')
@section('plugins-css')
    <link
        href="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
        rel="stylesheet">
    <link href="{{asset('../assets/node_modules/wizard/steps.css')}}" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div>
                    <a href="{{url('/admin/practitioners/'.$practitioner->id)}}"
                       class="btn btn-success">Back to dashboard</a>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body dashboard-tabs p-0">
                        <div class="col-lg-12 tab-content py-0 px-0">
                            <h4 class="card-title">
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
                            </h4>
                            <div>
                                <form method="post" action="{{url('/make_restoration_payment')}}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="card ">
                                        <div class="card-header card-primary">
                                            Renewal details
                                        </div>
                                        <br/>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <h5 class="card-title">Renewal</h5>
                                                </div>
                                                {{--<div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="wlocation2">Choose Your Last Renewal Period : <span
                                                                class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control " required
                                                                name="period">
                                                            <option value="">Choose period</option>
                                                            @for($x =date('Y')-1;$x >= 2008;$x--)
                                                                <option value="{{$x}}">{{$x}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>--}}
                                                <div class="col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Currency (USD)</h5>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="radio"
                                                                        name="currency"
                                                                        id="exampleRadios1" value="1">
                                                                    <label class="form-check-label"
                                                                           for="exampleRadios1">
                                                                        ${{$restoration_penalty_fee}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Currency (ZWL)</h5>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="radio"
                                                                        name="currency"
                                                                        id="exampleRadios1" value="0">
                                                                    <label class="form-check-label"
                                                                           for="exampleRadios1">
                                                                        $ZWL{{$restoration_penalty_fee * $rate->rate}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <h5 class="card-title">Choose payment channel</h5>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Online Real-time
                                                                Payment</h5>
                                                            <p class="card-text">This is real-time payment
                                                                that provides
                                                                you with multiple payment options, ecocash,
                                                                telecash, one-wallet, Zimswitch cards(local)
                                                                and
                                                                Visa/Mastercard.</p>

                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="radio"
                                                                        name="payment_channel_id"
                                                                        id="exampleRadios1" value="5">
                                                                    <label class="form-check-label"
                                                                           for="exampleRadios1">
                                                                        {{'Paynow (online Payment)'}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Offline Payment</h5>
                                                            <p class="card-text">This options if for those
                                                                who have
                                                                already made their payments using the
                                                                traditional way,
                                                                that is either via, Bank transfers, Direct
                                                                deposit, Ecocash biller
                                                                code, or Cash Submission at AHPCZ offices.
                                                                This requires a Proof of Payment</p>

                                                            <div class="row">
                                                                <div class="col-md-3 col-lg-3">
                                                                    <div class="form-group">
                                                                        <div class="form-check">
                                                                            <input
                                                                                class="form-check-input"
                                                                                type="radio"
                                                                                name="payment_channel_id"
                                                                                id="exampleRadios1"
                                                                                value="1">
                                                                            <label class="form-check-label"
                                                                                   for="exampleRadios1">
                                                                                {{'Cash'}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-lg-3">
                                                                    <div class="form-group">
                                                                        <div class="form-check">
                                                                            <input
                                                                                class="form-check-input"
                                                                                type="radio"
                                                                                name="payment_channel_id"
                                                                                id="exampleRadios1"
                                                                                value="2">
                                                                            <label class="form-check-label"
                                                                                   for="exampleRadios1">
                                                                                {{'Ecocash'}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-lg-3">
                                                                    <div class="form-group">
                                                                        <div class="form-check">
                                                                            <input
                                                                                class="form-check-input"
                                                                                type="radio"
                                                                                name="payment_channel_id"
                                                                                id="exampleRadios1"
                                                                                value="3">
                                                                            <label class="form-check-label"
                                                                                   for="exampleRadios1">
                                                                                {{'CBZ Bank Transfe/Deposit'}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-lg-3">
                                                                    <div class="form-group">
                                                                        <div class="form-check">
                                                                            <input
                                                                                class="form-check-input"
                                                                                type="radio"
                                                                                name="payment_channel_id"
                                                                                id="exampleRadios1"
                                                                                value="4">
                                                                            <label class="form-check-label"
                                                                                   for="exampleRadios1">
                                                                                {{'Standard Chattered Bank Transfer/Deposit'}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="card-body">
                                            <h5 class="card-title">Required CPD Points
                                                : {{$cpd_points}}</h5>
                                            <p class="card-text" style="color: yellowgreen">Please note
                                                that, you are required
                                                to submit the copy
                                                of
                                                CPD book, if you are foreign you may submit your current
                                                registration
                                                from
                                                your country of residents.</p>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text">CPD Points </span>
                                                        </div>
                                                        <input type="text" name="points"
                                                               class="form-control"
                                                               aria-label="CPD Points">
                                                    </div>
                                                    @if ($errors->any())
                                                        <span
                                                            style="color: red;">@error('points'){{$message}}@enderror
                                                                </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i
                                                                            class="fa fa-book-open"></i> CPD Book </span>
                                                        </div>
                                                        <input type="file" name="file" class="form-control"
                                                               aria-label="CPD Points">
                                                    </div>
                                                    @if ($errors->any())<span
                                                        style="color: red;">@error('file'){{$message}}@enderror</span>@endif

                                                </div>

                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i
                                                                            class="fa fa-book-open"></i> Payment date </span>
                                                        </div>
                                                        <input type="text" name="payment_date" value=""
                                                               class="form-control" id="payment_date">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="practitioner_id" value="{{$practitioner->id}}">
                                    <input type="hidden" name="rate" value="{{$rate->rate}}">
                                    <input type="hidden" name="amount_invoiced" value="{{$restoration_penalty_fee}}">
                                    <input type="hidden" name="amount_paid" value="{{$restoration_penalty_fee}}">
                                    <input type="hidden" name="cpd_criteria" value="{{$cpd_points}}">

                                    <div style="margin-top: 2%">
                                        <input type="submit" value="Make Payment" class="btn btn-success btn-block">
                                    </div>
                                </form>
                            </div>
                            <hr/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('plugins-js')
    <script type="text/javascript" src="{{asset('js/functions.js')}}"></script>
    <script src="{{asset('../assets/node_modules/moment/moment.js')}}"></script>
    <script
        src="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <script type="text/javascript">
        // MAterial Date picker
        $('#payment_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'YYYY-MM-DD'
        });


    </script>

@stop


