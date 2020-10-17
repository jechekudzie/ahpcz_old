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
            <div class="col-md-5 align-self-center">
                @can('admin')
                    <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
                @endcan
                <a href="/admin/prefixes" class="btn btn-success"></i> All Prefix</a>


            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">{{$prefix->name}}</li>
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
                                <h4 class="card-title">Edit {{$prefix->name}}  </h4>
                                {{--
                                                                    <h6 class="card-subtitle">A City is the practitioner's area of practice.</h6>
                                --}}
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <form action="/admin/prefixes/{{$prefix->id}}" method="post" class="m-t-40" novalidate>
                                    {{method_field('PATCH')}}
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <h5>Professions <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="profession_id" id="select" required class="form-control selectpicker" data-live-search="true">
                                                <option value="">Select Profession</option>
                                                @foreach($professions as $profession)
                                                    <option value="{{$profession->id}}" @if ($profession->id == $prefix->profession_id) {{ 'selected' }} @endif >{{$profession->name}}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5> Prefix <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="name" value="{{$prefix->name}}" class="form-control"
                                                   required
                                                   data-validation-required-message="This field is required">
                                        </div>
                                        <div class="form-control-feedback">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5> Last Registration Number Used <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="last_reg" value="{{str_pad($prefix->last_reg, 4, '0', STR_PAD_LEFT)}}" class="form-control"
                                                   required
                                                   data-validation-required-message="This field is required">
                                        </div>
                                        <div class="form-control-feedback">
                                        </div>
                                    </div>




                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="submit" name="add_profession"
                                                   class="btn btn-rounded btn btn-block btn-success"
                                                   value="Update Prefix">
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
