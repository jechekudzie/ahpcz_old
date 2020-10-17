@extends('layouts.admin')
@section('title','AHPCZ - Create Profession')
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

                <a href="/admin/renewal_categories" class="btn btn-success"></i> All Renewal Categories</a>


            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create New Renewal Category</li>
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
                                <h4 class="card-title">Create New Renewal Category</h4>
                                <h6 class="card-subtitle"> States the practitioner's payment category.</h6>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <form action="/admin/renewal_categories" method="post" class="m-t-40" novalidate>
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <h5>Renewal Category <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="name" value="{{old('name')}}" class="form-control"
                                                   required
                                                   data-validation-required-message="This field is required">
                                        </div>
                                        <div class="form-control-feedback">
                                            <small>Renewal category name is <code>mandatory</code>.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>Description <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <textarea name="description" class="form-control" required
                                                      data-validation-required-message="This field is required">{{old('description')}}</textarea>
                                        </div>
                                        <div class="form-control-feedback">
                                            <small>Description of renewal category helps to understand more about it and it is
                                                is
                                                <code>mandatory</code>.
                                            </small>
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="submit" name="add_profession"
                                                   class="btn btn-rounded btn btn-block btn-success"
                                                   value="Create New Renewal Category">
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
