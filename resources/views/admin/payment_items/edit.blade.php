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
                                    <div class="alert alert-success alert-rounded col-md-6"><i
                                                class="fa fa-check-circle"></i> {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif <h4 class="card-title">Create New Category</h4>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <form action="/admin/payment_items/{{$paymentItem->id}}" method="post" class="m-t-40" novalidate>
                                    {{method_field('PATCH')}}
                                    {{csrf_field()}}

                                    <div class="form-group">
                                        <h5>Payment item category <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="payment_item_category_id" id="select" required class="form-control selectpicker" data-live-search="true">
                                                <option value="">Choose Category</option>
                                                @foreach($payment_item_categories as $payment_item_category)
                                                    <option value="{{$payment_item_category->id}}"
                                                    @if($paymentItem->payment_item_category_id ==$payment_item_category->id){{'selected'}}@endif
                                                        >{{$payment_item_category->name}}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <h5>Payment Item <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="name" value="{{$paymentItem->name}}" class="form-control"
                                                   required
                                                   data-validation-required-message="This field is required">
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <h5>Payment Item Fee <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="number" step="any" name="fee" value="{{$paymentItem->fee}}" class="form-control"
                                                   required
                                                   data-validation-required-message="This field is required">
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="submit" name="add_profession"
                                                   class="btn btn-rounded btn btn-block btn-success"
                                                   value="Add Payment Item">
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
