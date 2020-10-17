@extends('layouts.admin')
@section('title','AHPCZ - Create Profession')
@section('morris-chart-css')
<!-- chartist CSS -->
<link href="{{asset('assets/node_modules/morrisjs/morris.css')}}" rel="stylesheet">
<!--Toaster Popup message CSS -->
<link href="{{asset('assets/node_modules/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

            <a href="/admin/professions" class="btn btn-success"></i> All Professions</a>


        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Create New Profession</li>
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
                        <div class="col-2"></div>
                        <div class="col-8">
                            <h4 class="card-title">Create New Profession</h4>
                            <h6 class="card-subtitle">Add a new profession into the system</h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-8">
                            <form class="m-t-40" novalidate>
                                <div class="form-group">
                                    <h5>Profession <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="text" class="form-control" required
                                               data-validation-required-message="This field is required">
                                    </div>
                                    <div class="form-control-feedback">
                                        <small>Profession name is <code>mandatory</code>.
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h5>Description <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                            <textarea name="text" class="form-control" required
                                                      data-validation-required-message="This field is required"></textarea>
                                    </div>
                                    <div class="form-control-feedback">
                                        <small>Description of the profession helps to understand more and it is <code>mandatory</code>.
                                        </small>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <div class="controls">
                                        <input type="submit" name="add_profession"
                                               class="btn btn-rounded btn btn-block btn-success"
                                               value="Create New Profession">
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
<!--morris JavaScript -->
<script src="{{asset('assets/node_modules/raphael/raphael-min.js')}}"></script>
<script src="{{asset('assets/node_modules/morrisjs/morris.min.js')}}"></script>
<script src="{{asset('assets/node_modules/jquery-sparkline/jquery.sparkline.min.js')}}"></script>


<!-- jQuery peity -->
<script src="{{asset('assets/node_modules/peity/jquery.peity.min.js')}}"></script>
<script src="{{asset('assets/node_modules/peity/jquery.peity.init.js')}}"></script>
@endsection
