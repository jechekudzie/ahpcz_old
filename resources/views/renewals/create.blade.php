@extends('layouts.admin')
@section('plugins-css')

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://code.jquery.com//resources/demos/style.css">
@endsection
@livewireStyles
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
            @livewire('create-renewal',
            [
            'practitioner'=>$practitioner,
            ])
        </div>

    </div>
@stop

@livewireScripts
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



