@extends('layouts.admin')
@section('title','AHPCZ - Create Nationality')
@section('plugins-css')

@endsection

@section('content')

    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-8 align-self-center">
                @can('admin')
                    <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
                @endcan
                <a href="/admin/profession_approvers" class="btn btn-success"></i> All Committee Members</a>


            </div>
            <div class="col-md-4 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Assign Rights</li>
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

                                @if(session('message'))
                                    <div class="alert alert-success alert-rounded"><i
                                                class="fa fa-check-circle"></i> {{session('message')}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif
                                <h4 class="card-title">Create New Member</h4>
                                {{--

                                --}}
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <form action="/admin/profession_approvers" method="post" class="m-t-40" novalidate>
                                    {{csrf_field()}}

                                    <div class="form-group">
                                        <h5>System Users <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="user_id" class="form-control"
                                                    required
                                                    data-validation-required-message="This field is required">
                                                <option value="">Choose user</option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <h5>Professions <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="profession_id"  class="form-control"
                                                    required data-validation-required-message="This field is required">
                                                <option>Choose</option>
                                                @foreach($professions as $profession)
                                                    <option value="{{$profession->id}}">{{$profession->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="submit" name="add_member"
                                                   class="btn btn-rounded btn btn-block btn-success"
                                                   value="Add New Member">
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
