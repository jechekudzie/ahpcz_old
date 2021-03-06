@extends('layouts.admin')
@section('title','AHPCZ - Add Profession')
@section('plugins-css')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

                <a href="/admin/renewal_categories" class="btn btn-success"> All renewal criteria</a>


            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add New Renewal Criteria</li>
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

                                @if(session('message'))
                                    <div class="alert alert-success alert-rounded"><i
                                            class="fa fa-check-circle"></i> {{session('message')}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif
                                <h4 class="card-title">Add New Renewal Criteria</h4>
                                <h6 class="card-subtitle"></h6>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-2 col-lg-2"></div>
                            <div class="col-sm-12 col-md-8 col-lg-8">
                                <form action="{{url('/admin/renewal_criterias')}}" method="post" class="m-t-40"
                                      novalidate>
                                    {{csrf_field()}}

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <h5 style="color: black; font-weight: bolder">Enter percentage</h5>
                                            <p style="color: yellowgreen;">Please enter the percentage to be paid and
                                                choose the criteria that supports/fits it below.</p>
                                            <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div>
                                                            <label class="sr-only" for="inlineFormInputGroup">Percentage</label>
                                                            <div class="input-group mb-2">
                                                                <input type="number" class="form-control" name="percentage"  required id="inlineFormInputGroup" placeholder="Enter percentage renewal">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">%</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <hr/>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <h5 style="color: black; font-weight: bolder">Renewal Categories</h5>
                                            <p style="color: yellowgreen;">Please choose a renewal category.</p>
                                            <div class="row">
                                                @foreach($renewal_categories as $renewal_category)

                                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                       name="renewal_category_id"
                                                                       id="exampleRadios1"
                                                                       value="{{$renewal_category->id}}">
                                                                <label class="form-check-label" for="exampleRadios1">
                                                                    {{$renewal_category->name}}
                                                                </label>
                                                                <p style="color: red;">{{$renewal_category->description}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr/>
                                        </div>

                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <h5 style="color: black; font-weight: bolder">Employment Status</h5>
                                            <p style="color: yellowgreen;">Please choose your employment status.</p>
                                            @foreach($employment_statuses as $employment_status)
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="employment_status_id"
                                                               id="exampleRadios1" value="{{$employment_status->id}}">
                                                        <label class="form-check-label" for="exampleRadios1">
                                                            {{$employment_status->name}}
                                                        </label>
                                                        <p style="color: red;">{{$employment_status->description}}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <h5 style="color: black; font-weight: bolder">Residence</h5>
                                            <p style="color: yellowgreen;">Choose if one should be either foreign based
                                                or local based</p>
                                            @foreach($employment_locations as $employment_location)
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="employment_location_id"
                                                               id="exampleRadios1" value="{{$employment_location->id}}">
                                                        <label class="form-check-label" for="exampleRadios1">
                                                            {{$employment_location->name}}
                                                        </label>
                                                        <p style="color: red;">{{$employment_location->description}}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <h5 style="color: black; font-weight: bolder">Certificate request</h5>
                                            <p style="color: yellowgreen;">Please specify if a certificate can be issued
                                                in
                                                this criteria.</p>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                           name="certificate_request"
                                                           id="exampleRadios1" value="1" >
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        {{'Yes'}}
                                                    </label>
                                                    <p style="color: red;">{{'A certificate is to be issued'}}</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                           name="certificate_request"
                                                           id="exampleRadios1" value="2">
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        {{'No'}}
                                                    </label>
                                                    <p style="color: red;">{{'A certificate is not to be issued'}}</p>
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div style="text-align: center;padding-left: 40%">
                                            <div class="controls">
                                                <input type="submit" name="add" class="btn btn-success btn-block"
                                                       value="Add New Renewal Criteria">
                                            </div>
                                        </div>
                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('plugins-js')

@endsection
