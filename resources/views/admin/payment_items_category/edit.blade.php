@extends('layouts.admin')
@section('title','AHPCZ - Create Category')
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

                <a href="/admin/payment_items" class="btn btn-success"></i> All Payment Items</a>


            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Create New Category</li>
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
                                    <div class="alert alert-success alert-rounded col-md-12"><i
                                                class="fa fa-check-circle"></i> {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif <h4 class="card-title">Update {{$category->name}} Category</h4>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <form action="/admin/payment_items/categories/{{$category->id}}" method="post" class="m-t-40" novalidate>
                                    {{method_field('PATCH')}}
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <h5>Category <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="name" value="{{$category->name}}" class="form-control"
                                                   required
                                                   data-validation-required-message="This field is required">
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="submit" name="add_profession"
                                                   class="btn btn-rounded btn btn-block btn-success"
                                                   value="Update Category">
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
