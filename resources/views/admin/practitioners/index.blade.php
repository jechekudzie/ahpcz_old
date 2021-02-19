@extends('layouts.admin')
<!-- Styles -->
<!-- TailwindCSS -->
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Nunito';
    }
</style>
@livewireStyles
@section('content')
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">

                @can('updatePractitioner')
                    <a href="practitioners/create" class="btn btn-success"><i
                            class="fa fa-plus-circle"></i> Add Practitioner</a>
                    <a href="/admin/practitioners/renewal/create" class="btn btn-success"><i
                            class="fa fa-plus-circle"></i> Add Practitioner For Renewal</a>
                @endcan
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
                @if (session('message'))
                    <div class="alert alert-success alert-rounded col-md-6">
                        <i class="fa fa-check-circle"></i> {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#approved"
                                                role="tab"><span
                                    class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                    class="hidden-xs-down"> Practitioners Approved</span></a></li>

                    </ul>
                    <br/>
                    <br/>

                    <div class="col-md-12">
                        @livewire('index')
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
@livewireScripts
<!-- Scripts -->


