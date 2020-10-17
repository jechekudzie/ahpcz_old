@extends('layouts.admin')
@section('title','AHPCZ - Create Institution')
@section('plugins-css')
    <link href="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
          rel="stylesheet">
    <link href="{{asset('../assets/node_modules/wizard/steps.css')}}" rel="stylesheet">
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
                <a href="/admin/practitioners/{{$document->practitioner->id}}" class="btn btn-success"></i> Dash
                    Board</a>
            </div>

            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Update document</li>
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
                                @endif
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card wizard-content">
                                    <div class="card-body">
                                        <h4 class="card-title">{{$document->practitioner->first_name.' '.$document->practitioner->last_name}}</h4>
                                        <h5 class="card-title">Update Document {{$document->documentCategory->name}}</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form action="/admin/practitioners/documents/{{$document->id}}/update"
                                                      method="post" enctype="multipart/form-data">
                                                    {{method_field('PATCH')}}
                                                    {{csrf_field()}}


                                                    <div class="form-group">
                                                        <label for="wlocation2"> Document Category : <span
                                                                    class="danger">*</span>
                                                        </label>
                                                        <select class="custom-select form-control " required
                                                                id="document_category_id" name="document_category_id">
                                                            <option value="">Select Documents Category</option>
                                                            @foreach($documents_categories as $documents_category)
                                                                <option value="{{$documents_category->id}}" @if($documents_category->id==$document->document_category_id){{'selected'}}@endif>{{$documents_category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="form-control-feedback">

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="wphoneNumber2">Document
                                                            :</label>
                                                        <input type="file" class="form-control"
                                                               id="file" name="file">
                                                    </div>

                                                    <input type="submit" value="Update Document" name="add"
                                                           class="btn btn-success btn-block">

                                                </form>
                                            </div>
                                            <div class="col-md-6">
                                                <object width="600" height="600" data="/{{$document->path}}">
                                                </object>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('plugins-js')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.0.7/jquery.steps.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.0.7/jquery.steps.min.js"></script>
    <script type="text/javascript" src="{{asset('js/functions.js')}}"></script>

    <script src="{{asset('../assets/node_modules/moment/moment.js')}}"></script>
    <script src="{{asset('../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <script>
        // MAterial Date picker
        $('#completion_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'DD/MM/YYYY'
        });

        $('#commencement_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'DD/MM/YYYY'
        });
        /*$('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });

        $('#min-date').bootstrapMaterialDatePicker({ format: 'DD/MM/YYYY HH:mm', minDate: new Date() });*/


    </script>



@endsection

