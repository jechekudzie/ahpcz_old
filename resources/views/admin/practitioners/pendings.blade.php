@extends('layouts.admin')
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
                                    class="hidden-xs-down"> Practitioners</span></a></li>

                        {{-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pending" role="tab"><span
                                     class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                     class="hidden-xs-down">Applications Pending Approval ({{$pending_apps = \App\Practitioner::where("approval_status","=",0)->count()}})</span></a>
                         </li>
 --}}
                    </ul>

                    @livewire('pendings')

                </div>
            </div>
        </div>
    </div>
@stop

@livewireScripts

