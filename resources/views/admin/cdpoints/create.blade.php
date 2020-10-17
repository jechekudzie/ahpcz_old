@extends('layouts.admin')
@section('title','AHPCZ - Create City')
@section('plugins-css')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-8 align-self-center">
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

                <a href="/admin/professions" class="btn btn-success"></i> All CPD Points & Placement</a>


            </div>
            <div class="col-md-4 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add CPD Points & Placement</li>
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

                                    @if (session('error'))
                                        <div class="alert alert-danger alert-rounded"><i class="fa fa-exclamation-triangle"></i>  {{ session('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        </div>
                                    @endif
                                <h4 class="card-title">Add CPD Points & Placement</h4>
{{--
                                    <h6 class="card-subtitle">A City is the practitioner's area of practice.</h6>
--}}
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <form action="/admin/cdpoints" method="post" class="m-t-40" novalidate>
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <h5>Professions <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="profession_id" id="select" required class="form-control " data-live-search="true">
                                                <option value="">Select Profession</option>
                                                @foreach($professions as $profession)
                                                <option value="{{$profession->id}}">{{$profession->name}}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>CPD  Points <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="points" value="{{old('points')}}" class="form-control"
                                                   required
                                                   data-validation-required-message="This field is required">
                                        </div>
                                        <div class="form-control-feedback">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <h5>Placement Status <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="placement" id="select" required class="form-control selectpicker" data-live-search="true">
                                                <option value="">Select Status</option>

                                                    <option value="0">Not Required</option>
                                                    <option value="1">Required</option>



                                            </select>
                                        </div>
                                        <div class="form-control-feedback">
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="submit" name="add_points"
                                                   class="btn btn-rounded btn btn-block btn-success"
                                                   value="Add New CPD Point & Placement">
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
