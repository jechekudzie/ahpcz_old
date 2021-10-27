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
                @can('admin')
                    <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>
                @endcan
                <a href="/admin/practitioners/{{$practitioner->id}}" class="btn btn-success"> Dashboard</a>

            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Approve</li>
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
                                <h4 class="card-title">Application Approval
                                    For {{$practitioner->first_name.' '.$practitioner->last_name}}</h4>
                                <h6 class="card-subtitle">Please note that the approval decision cannot be
                                    reversed.</h6>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                @if(auth()->user()->role_id == 4)
                                    <h3>Registration Officer Approval</h3>
                                    <form action="/admin/practitioners/approval/{{$practitioner->id}}/officer"
                                          method="post" class="m-t-40" novalidate>
                                        {{csrf_field()}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="ec_member"
                                                   id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                EC member (If Educational committee member is required to verify this
                                                application, please check this box and proceed.
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <h5>Comments <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                            <textarea name="comment" class="form-control" required
                                                      data-validation-required-message="This field is required">{{old('comment')}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="submit" name="add_profession"
                                                       class="btn btn-rounded btn btn-block btn-success"
                                                       value="Approve Application">
                                            </div>

                                        </div>


                                    </form>
                                @endif

                                @if(auth()->user()->role_id == 5)
                                    @if($practitioner->registration_officer == 2 && $practitioner->accountant == 0
                                        && $practitioner->member == 1 && $practitioner->registrar == 1
                                        )

                                        <h3>Accountant Approval - Final Payment</h3>
                                        <form action="/admin/practitioners/approval/{{$practitioner->id}}/final_payment"
                                              method="post"
                                              class="m-t-40" novalidate>
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <h5>Comments <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                            <textarea name="comment" class="form-control" required
                                                      data-validation-required-message="This field is required">{{old('comment')}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="submit" name="add_profession"
                                                           class="btn btn-rounded btn btn-block btn-success"
                                                           value="Approve Application">
                                                </div>

                                            </div>


                                        </form>
                                    @else
                                        <h3>Accountant Approval</h3>
                                        <form action="/admin/practitioners/approval/{{$practitioner->id}}/accountant"
                                              method="post"
                                              class="m-t-40" novalidate>
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <h5>Comments <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                            <textarea name="comment" class="form-control" required
                                                      data-validation-required-message="This field is required">{{old('comment')}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="submit" name="add_profession"
                                                           class="btn btn-rounded btn btn-block btn-success"
                                                           value="Approve Application">
                                                </div>

                                            </div>


                                        </form>
                                    @endif
                                    @endif

                                    @if(auth()->user()->role_id == 6)
                                        <h3>Educational Committee Member Approval</h3>
                                        <form action="/admin/practitioners/approval/{{$practitioner->id}}/member"
                                              method="post"
                                              class="m-t-40" novalidate>
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <h5>Comments <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                            <textarea name="comment" class="form-control" required
                                                      data-validation-required-message="This field is required">{{old('comment')}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="submit" name="add_profession"
                                                           class="btn btn-rounded btn btn-block btn-success"
                                                           value="Approve Application">
                                                </div>

                                            </div>


                                        </form>
                                    @endif

                                    @if(auth()->user()->role_id == 7)
                                        <h3>Registrar Approval</h3>
                                        <form action="/admin/practitioners/approval/{{$practitioner->id}}/registrar"
                                              method="post" class="m-t-40" novalidate>
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <h5>Comments <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                            <textarea name="comment" class="form-control" required
                                                      data-validation-required-message="This field is required">{{old('comment')}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="submit" name="add_profession"
                                                           class="btn btn-rounded btn btn-block btn-success"
                                                           value="Approve Application">
                                                </div>

                                            </div>


                                        </form>
                                    @endif
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
