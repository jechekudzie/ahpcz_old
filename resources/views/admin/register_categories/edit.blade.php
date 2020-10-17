@extends('layouts.admin')
@section('title','AHPCZ - Create Register')
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

            <a href="/admin/register_categories" class="btn btn-success"></i> All Register Categories</a>


        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Register Category</li>
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
                            <h4 class="card-title">Edit {{$registerCategory->name}} </h4>
                            <h6 class="card-subtitle">Update {{$registerCategory->name}} </h6>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-8">
                            <form action="/admin/register_categories/{{$registerCategory->id}}" method="post" class="m-t-40" novalidate>
                                {{method_field('PATCH')}}
                                {{csrf_field()}}
                                <div class="form-group">
                                    <h5>Register Category <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="name" value="{{$registerCategory->name}}" class="form-control"
                                               required
                                               data-validation-required-message="This field is required">
                                    </div>
                                    <div class="form-control-feedback">
                                        <small>Register name is <code>mandatory</code>.
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h5>Description <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                            <textarea name="description" class="form-control" required
                                                      data-validation-required-message="This field is required">{{$registerCategory->description}}{{old('description')}}</textarea>
                                    </div>
                                    <div class="form-control-feedback">
                                        <small>Description of register helps to understand more about it and it
                                            <code>mandatory</code>.
                                        </small>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <div class="controls">
                                        <input type="submit" name="add_register"
                                               class="btn btn-rounded btn btn-block btn-success"
                                               value="Update Register">
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
