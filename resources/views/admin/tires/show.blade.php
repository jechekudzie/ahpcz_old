@extends('layouts.admin')


@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

                <a href="/admin/renewal_fees" class="btn btn-success"> All Tires</a>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                    Add Profession To {{$tire->name}}
                </button>


            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">{{$tire->name}} </li>
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
                                    <div class="alert alert-success alert-rounded col-md-6"><i
                                            class="fa fa-check-circle"></i> {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif
                                <h4 class="card-title">{{date('Y')}} -> {{$tire->name}} </h4>
                                <h4 class="card-title">Renewal fee {{$tire->fee}} </h4>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>

                            <div class="col-8">
                                <form action="/admin/profession_tires/delete" method="post" class="m-t-40"
                                      novalidate>
                                    {{csrf_field()}}

                                    <h5>{{$tire->name}} professions<span class="text-danger">*</span></h5>
                                    @if($tire->profession_tires)
                                        @foreach($tire->profession_tires as $profession_tire)

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       name="profession_tire_id[]"
                                                       value="{{$profession_tire->id}}"
                                                       id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    {{$profession_tire->profession->name}}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif

                                    <input type="hidden" name="tire_id" value="{{$tire->id}}">
                                    <br/>
                                    <br/>
                                    <div class="controls">
                                        <input type="submit" name="add_profession"
                                               class="btn btn-rounded btn-success"
                                               value="Delete Selected Profession">
                                    </div>


                                </form>
                            </div>

                        </div>

                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Professions
                                            to {{$tire->name}}</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/admin/profession_tires/" method="post"
                                          class="m-t-40"
                                          novalidate>
                                        <div class="modal-body">

                                            {{csrf_field()}}

                                            <h5>All professions<span class="text-danger">*</span></h5>
                                            <div class="row">
                                                @foreach($professions as $profession)
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="profession_id[]"
                                                                   @foreach($tire->profession_tires as $profession_tire)
                                                                   @if($profession_tire->profession_id == $profession->id)
                                                                   {{'checked'}}  {{'disabled'}}
                                                                   @endif
                                                                   @endforeach

                                                                   value="{{$profession->id}}"
                                                                   id="defaultCheck1">
                                                            <label class="form-check-label" for="defaultCheck1">
                                                                {{$profession->name}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="tire_id" value="{{$tire->id}}">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
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

@stop



