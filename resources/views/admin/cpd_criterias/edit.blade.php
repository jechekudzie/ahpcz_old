@extends('layouts.admin')


@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

                <a href="/admin/renewal_categories" class="btn btn-success "><i class="fa fa-arrow-circle-o-left"></i> Back</a>


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
                                <h4 class="card-title">Add {{$cpdCriteria->profession->name}} CPD criteria</h4>
                                {{--
                                                                    <h6 class="card-subtitle">A City is the practitioner's area of practice.</h6>
                                --}}
                            </div>

                        </div>
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <form action="/admin/cpd_criterias/update" method="post" class="m-t-40" novalidate>
                                        {{method_field('PATCH')}}
                                        {{csrf_field()}}
                                        <h1>{{$cpdCriteria->profession->name}} CPD Points for {{date('Y')}}</h1>
                                        @foreach($cpd_criterias as $cpd_criteria)
                                            <div class="form-group">
                                                <h5> {{$cpd_criteria->employment_status->name}} <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="number" name="item[{{$cpd_criteria->employment_status->id}}][points]"
                                                           value="{{$cpd_criteria->points}}" class="form-control"
                                                           required
                                                           placeholder="Enter points for {{$cpd_criteria->employment_status->name}}"
                                                    >
                                                </div>
                                            </div>
                                            <input type="hidden" name="item[{{$cpd_criteria->employment_status->id}}][profession_id]"
                                                   value="{{$cpd_criteria->profession->id}}">
                                            <input type="hidden"
                                                   name="item[{{$cpd_criteria->employment_status->id}}][employment_status_id]"
                                                   value="{{$cpd_criteria->employment_status->id}}">
                                        @endforeach
                                        <h5> Standard Points <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="number" name="standard"
                                                   value="{{$cpdCriteria->standard}}" class="form-control"
                                                   required
                                                   placeholder="Enter Standard points"
                                            >
                                        </div>
                                        <br/>
                                        <br/>
                                        <input type="hidden" name="profession" value="{{$cpdCriteria->profession->name}}">

                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="submit" name="add_profession"
                                                       class="btn btn-rounded btn btn-block btn-success"
                                                       value="Update Cpd Criteria">
                                            </div>

                                        </div>


                                    </form>
                                </div>

                            </div>


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
