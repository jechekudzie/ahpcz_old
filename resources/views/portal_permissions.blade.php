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

                                @if(!empty($message))
                                    <div class="alert alert-success alert-rounded"><i
                                            class="fa fa-check-circle"></i> {{$message}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif
                                <h4 class="card-title">{{$practitioner->first_name.' '.$practitioner->last_name}}  </h4>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                @if($id == 1)
                                    <form action="/admin/practitioners/verify" method="post" class="m-t-40" novalidate>
                                        {{csrf_field()}}
                                        <h5><span class="text-danger">Activate {{$practitioner->first_name.' '.$practitioner->last_name}} ?</span>
                                        </h5>

                                        <input type="hidden" name="id" value="{{$id}}">
                                        <input type="hidden" name="practitioner_id" value="{{$practitioner->id}}">

                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="submit" name="add_profession"
                                                       class="btn btn-rounded btn btn-block btn-success"
                                                       value="Yes Activate Account">
                                            </div>

                                        </div>


                                    </form>
                                @endif


                                    @if($id == 2)
                                        <form action="{{url('/admin/practitioners/verify')}}" method="post" class="m-t-40" novalidate>
                                            {{csrf_field()}}
                                            <h5><span class="text-danger">De-Activate {{$practitioner->first_name.' '.$practitioner->last_name}} ?</span>
                                            </h5>

                                            <input type="hidden" name="id" value="{{$id}}">
                                            <input type="hidden" name="practitioner_id" value="{{$practitioner->id}}">

                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="submit" name="add_profession"
                                                           class="btn btn-rounded btn btn-block btn-success"
                                                           value="Yes De-Activate Account">
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

