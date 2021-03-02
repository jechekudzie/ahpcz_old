@extends('layouts.admin')


@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

                <a href="/admin/cpd_criterias/index" class="btn btn-success "><i class="fa fa-arrow-circle-o-left"></i> Back</a>


            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add new CPD criteria</li>
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
                                    <div class="alert alert-success alert-rounded"><i
                                            class="fa fa-check-circle"></i> {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif
                                <h4 class="card-title">Add {{$profession->name}} CPD criteria</h4>
                                {{--
                                                                    <h6 class="card-subtitle">A City is the practitioner's area of practice.</h6>
                                --}}
                            </div>

                        </div>
                        @if($check == null)
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <form action="/admin/cpd_criterias/store" method="post" class="m-t-40" novalidate>
                                        {{csrf_field()}}
                                        <h1>{{$profession->name}} CPD Points for {{date('Y')}}</h1>
                                        @foreach($employment_statuses as $employment_status)
                                            <div class="form-group">
                                                <h5> {{$employment_status->name}} <span class="text-danger">*</span>
                                                </h5>
                                                <div class="controls">
                                                    <input type="number" name="item[{{$employment_status->id}}][points]"
                                                           value="{{old('name')}}" class="form-control"
                                                           required
                                                           placeholder="Enter points for {{$employment_status->name}}"
                                                    >
                                                </div>
                                            </div>
                                            <input type="hidden" name="item[{{$employment_status->id}}][profession_id]"
                                                   value="{{$profession->id}}">
                                            <input type="hidden"
                                                   name="item[{{$employment_status->id}}][employment_status_id]"
                                                   value="{{$employment_status->id}}">
                                        @endforeach
                                        <input type="hidden" name="profession" value="{{$profession->name}}">

                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="submit" name="add_profession"
                                                       class="btn btn-rounded btn btn-block btn-success"
                                                       value="Add Cpd Criteria">
                                            </div>

                                        </div>


                                    </form>
                                </div>

                            </div>
                        @else
                            <div class="row">
                                <div class="cold-md-6 col-lg-6">
                                    <div class="alert alert-success alert-rounded"><i
                                            class="fa fa-check-circle"></i> Please note that this profession already has been updated for CPD points.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('plugins-js')
            <script type="text/javascript">
                $(function () {
                    $('.selectpicker').selectpicker();
                });
            </script>
@endsection
