@extends('layouts.admin')
@section('title','AHPCZ - Create Register Category')
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

                <a href="{{'/admin/practitioners/'.$practitioner->id}}" class="btn btn-success"> Practitioner dashboard</a>


            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">{{$practitioner->name}} </li>
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
                                <h4 class="card-title">{{$practitioner->first_name.' '.$practitioner->last_name}}  </h4>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-4">
                                <form action="{{url('/admin/practitioner_renewals/'.$renewal->id.'/sign_off')}}" method="post" class="m-t-40" novalidate>
                                    {{csrf_field()}}
                                    <h5><span class="text-danger">Sign Off certificate for {{$practitioner->first_name.' '.$practitioner->last_name}} ?</span>
                                    </h5>
                                    <input type="hidden" name="renewal_id" value="{{$renewal->id}}">

                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="submit" name="add_profession"
                                                   class="btn btn-rounded btn btn-block btn-success"
                                                   value="Yes Sign Off">
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

