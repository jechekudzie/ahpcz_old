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
            <div class="col-md-12">
                <div class="card card-body printableArea">
                    <h3><b>INVOICE</b> <span class="pull-right">#5669626</span></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <address>
                                    <h3> &nbsp;<b class="text-danger">Allied Health Practitioners Council</b></h3>
                                    <p class="text-muted m-l-5">20 Worcester Road,
                                        <br/> Eastlea,
                                        <br/> Harare,
                                        <br/> Zimbabwe</p>
                                </address>
                            </div>
                            <div class="pull-right text-right">
                                <address>
                                    <h3>To,</h3>
                                    <h4 class="font-bold">{{$practitioner->first_name .' '.$practitioner->last_name}}
                                        ,</h4>
                                    <p class="text-muted m-l-30">
                                        @if(count($practitioner->contact)){{$practitioner->contact->physical_address}}@endif
                                        <br/> @if(count($practitioner->contact->city_id)){{$practitioner->contact->city->name .' '.$practitioner->contact->province->name}}@endif
                                        ,
                                        <br/> @if(count($practitioner->contact)){{$practitioner->contact->primary_number}}@endif
                                    </p>
                                    <p class="m-t-30"><b>Invoice Date :</b> <i
                                                class="fa fa-calendar"></i> {{date('d F Y')}}</p>
                                    <p><b>Due Date :</b> <i class="fa fa-calendar"></i> {{date('d F Y')}}</p>
                                </address>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Description</th>
                                        <th class="text-right">Quantity</th>
                                        <th class="text-right">Unit Cost</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center">{{date('Y')}}</td>
                                        <td>{{'Current Renewal Fee'}}</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right"> {{number_format($fee,2)}}</td>
                                        <td class="text-right"> {{number_format($fee,2)}}</td>
                                    </tr>
                                    @if(count($practitioner->payments))
                                        @foreach($practitioner->payments as $payment)
                                            @if($payment->balance > 0)
                                                <tr>
                                                    <td class="text-center">{{$payment->renewal_period_id}}</td>
                                                    <td>{{$payment->paymentItem->name}}</td>
                                                    <td class="text-right">1</td>
                                                    <td class="text-right"> {{number_format($payment->balance,2)}}</td>
                                                    <td class="text-right"> {{number_format($payment->balance,2)}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="pull-right m-t-30 text-right">

                                <hr>
                                <h3><b>Total :</b> @if(count($practitioner->payments)){{number_format($practitioner->payments->sum('balance') + $fee,2)}}@endif</h3>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="text-right">
                                <a href="/admin/practitioners/renewals/{{$practitioner->id}}/create" class="btn btn-success"> Proceed to payment</a>
                                {{--<button id="print" class="btn btn-default btn-outline" type="button"><span><i
                                                class="fa fa-print"></i> Print</span></button>--}}
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

        //generate full year
        //var min = new Date().getFullYear(),

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

