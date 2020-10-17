@extends('layouts.admin')
@section('title','AHPCZ - Create Nationality')
@section('plugins-css')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">

                <a href="/admin/practitioners/certificate/index" class="btn btn-success"></i> Certificates</a>


            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        {{--<li class="breadcrumb-item active">{{$renewal->profession->name}} </li>--}}
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

                                @if(!empty($message))
                                    <div class="alert alert-success alert-rounded"><i
                                            class="fa fa-check-circle"></i> {{$message}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                @if($renewal->certificate == 0)
                                    <form action="/admin/practitioners/certificate/signoff/{{$renewal->id}}"
                                          method="post" class="m-t-40" novalidate>
                                        {{method_field('PATCH')}}
                                        {{csrf_field()}}
                                        <h2>
                                            <span><strong>{{$renewal->practitioner->first_name.' '.$renewal->practitioner->last_name}} </strong> </span>
                                        </h2>
                                        <h4><span class="text-danger">Are you sure you want to Sign Off {{$renewal->renewal_period_id}} renewal certificate ?</span>
                                        </h4>


                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="submit" name="Add"
                                                       class="btn btn-rounded btn btn-block btn-success"
                                                       value="Sign Off">
                                            </div>

                                        </div>


                                    </form>
                                @endif

                                @if($renewal->certificate == 1)
                                    <form action="/admin/practitioners/certificate/collect/{{$renewal->id}}"
                                          method="post" class="m-t-40" novalidate>
                                        {{method_field('PATCH')}}
                                        {{csrf_field()}}
                                        <h2>
                                            <span><strong>{{$renewal->practitioner->first_name.' '.$renewal->practitioner->last_name}} </strong> </span>
                                        </h2>
                                        <h4><span class="text-danger">Are you sure you want to Issue {{$renewal->renewal_period_id}} renewal certificate ?</span>
                                        </h4>


                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="submit" name="Add"
                                                       class="btn btn-rounded btn btn-block btn-success"
                                                       value="Mark As Collected">
                                            </div>

                                        </div>


                                    </form>
                                @endif

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

