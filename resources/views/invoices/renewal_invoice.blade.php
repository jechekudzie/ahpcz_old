<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">

    <title>Allied Health Practitioners Council</title>
    <!-- Plugins CSS -->

<!-- Custom CSS -->
    <link href="{{asset('dist/css/style.min.css')}}" media="all" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{asset('dist/css/pages/dashboard1.css')}}" media="all" rel="stylesheet">

</head>
<body>

</body>
    <div class="container-fluid">
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
                                        <br/> @if(count($practitioner->contact)){{$practitioner->contact->city->name .' '.$practitioner->contact->province->name}}@endif
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
                                        <td class="text-center"></td>
                                        <td>{{"Renewal fee"}}</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right"> {{number_format($renewal_fee->fee,2)}}</td>
                                        <td class="text-right"> {{number_format($renewal_fee->fee,2)}}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="pull-right m-t-30 text-right">
                                <p>Sub - Total amount: {{number_format($renewal_fee->fee,2)}}</p>
                                <p>vat {{$vat->percentage}}(%) : {{number_format($renewal_fee->fee*$vat->vat,2)}} </p>
                                <hr>
                                <h3><b>Total :</b> {{$fee}}</h3>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="text-right">
                                <a href="/admin/practitioners/renewals/{{$practitioner->id}}/create" class="btn btn-success"> Proceed to payment</a>
                                <button id="print" class="btn btn-default btn-outline" type="button"><span><i
                                                class="fa fa-print"></i> Print</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="{{asset('assets/node_modules/popper/popper.min.js')}}"></script>
<script src="{{asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!--Custom JavaScript -->
<script src="{{asset('dist/js/custom.min.js')}}"></script>
<!-- ============================================================== -->
<script src="{{asset('dist/js/dashboard1.js')}}"></script>