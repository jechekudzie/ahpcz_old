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

                    <a href="{{url('/admin/practitioners/'.$practitioner->id)}}" class="btn btn-success"> Back to Practitioner dashboard</a>

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
@section('plugins-js')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript">
        // MAterial Date picker
        $(document).ready(function() {
            $(".datepicker").datepicker({
                dateFormat:"yy-mm-dd",
                changeYear:true
            });
        });
    </script>
@stop

@livewireScripts
<!-- Scripts -->



