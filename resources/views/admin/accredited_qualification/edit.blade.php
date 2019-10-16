@extends('layouts.admin')
@section('title','AHPCZ - Admin')
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

                <a href="/admin/accredited_institutions" class="btn btn-success"></i> All Professions Accredited</a>


            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Accredited Qualification </li>
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
                                    <div class="alert alert-success alert-rounded"><i class="fa fa-check-circle"></i>  {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                    </div>
                                @endif
                               
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <h1>test{{$accreditation->id}}</h1>
                                <form action="/admin/accredited_qualifications/{{$accreditation->id}}" method="post" class="m-t-40" novalidate>
                                    {{method_field('PATCH')}}
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <h5>Professional Qualifications <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="professional_qualification_id" id="select" required class="form-control selectpicker" data-live-search="true">
                                                <option value="">Choose Professional Qualification</option>
                                                @foreach($professionalQualifications as $professionalQualification)
                                                    <option value="{{$professionalQualification->id}}" @if($professionalQualification->id == $accreditation->professional_qualification_id){{'selected'}}@endif>{{$professionalQualification->name}}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Accredited Institutions <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="accredited_institution_id" id="select" required class="form-control selectpicker" data-live-search="true">
                                                <option value="">Choose Accredited Institutions</option>
                                                @foreach($accredited_institutions as $accredited_institution)
                                                    <option value="{{$accredited_institution->id}}" @if($accredited_institution->id==$accreditation->accredited_institution_id){{'selected'}}@endif>{{$accredited_institution->name}}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="submit" name="add_profession"
                                                   class="btn btn-rounded btn btn-block btn-success"
                                                   value="Update Accreditation">
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
    <script type="text/javascript">
        $(function() {
            $('.selectpicker').selectpicker();
        });
    </script>
@endsection
