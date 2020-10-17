@extends('layouts.admin')
@section('title','AHPCZ - Create Qualification Category')
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

                <a href="/admin/qualification_categories" class="btn btn-success"></i> All Qualification Categories</a>


            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">{{$qualificationCategory->name}} Qualification</li>
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
                                    <div class="alert alert-success alert-rounded"><i class="fa fa-check-circle"></i> {{$message}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                    </div>
                                @endif
                                <h4 class="card-title">{{$qualificationCategory->name}} Qualification </h4>
                                <h6 class="card-subtitle">Delete {{$qualificationCategory->name}} qualification</h6>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <form action="/admin/qualification_categories/{{$qualificationCategory->id}}" method="post" class="m-t-40" novalidate>
                                    {{method_field('DELETE')}}
                                    {{csrf_field()}}
                                        <h5><span class="text-danger">Are you sure you want to delete {{$qualificationCategory->name}} Qualification ?</span></h5>


                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="submit" name="add_profession"
                                                   class="btn btn-rounded btn btn-block btn-success"
                                                   value="Yes Delete Qualification Category">
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

