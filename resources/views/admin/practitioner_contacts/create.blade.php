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
                <a href="/admin" class="btn btn-success"><i class="fa fa-gear"></i> Administration Dashboard</a>

                <a href="/admin/practitioners/{{$practitioner->id}}" class="btn btn-success"></i> Dashboard</a>
            </div>

            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add practitioner</li>
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
                            <div class="col-md-12 col-12">
                                <div class="card wizard-content">
                                    <div class="card-body">
                                        <h4 class="card-title">Add Practitioner Contacts</h4>
                                        <form action="/admin/practitioners/contacts/{{$practitioner->id}}/store" method="post">
                                            {{csrf_field()}}
                                           <div class="row">
                                               <div class="col-md-6">
                                                   <div class="form-group">
                                                       <h5>Physical Address <span class="text-danger">*</span></h5>
                                                       <div class="controls">
                                                    <textarea name="physical_address" class="form-control" required
                                                              data-validation-required-message="This field is required">{{old('physical_address')}}</textarea>
                                                       </div>

                                                       @error('physical_address')
                                                       <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                       @enderror

                                                   </div>
                                               </div>


                                               <div class="col-md-6">
                                                   <div class="form-group">
                                                       <h5>Email Address <span class="text-danger">*</span></h5>
                                                       <div class="controls">
                                                           <input type="email" name="email" value="{{old('email')}}"
                                                                  class="form-control"
                                                                  required
                                                                  data-validation-required-message="This field is required">
                                                       </div>

                                                       @error('email')
                                                       <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                       @enderror

                                                   </div>
                                               </div>


                                               <div class="col-md-6">
                                                   <div class="form-group">
                                                       <label for="wlocation2"> Province : <span
                                                                   class="danger">*</span>
                                                       </label>
                                                       <select class="custom-select form-control" required
                                                               id="provinces" name="province_id">
                                                           <option value="all">Select province</option>
                                                           @foreach($provinces as $province)
                                                               <option value="{{$province->id}}" @if($province->id ==old('province_id')){{'selected'}}@endif>{{$province->name}}</option>
                                                           @endforeach
                                                       </select>
                                                       <div class="form-control-feedback">
                                                           <small><code>Pick a province in which you reside in here
                                                                   in zimbabwe.</code>
                                                           </small>
                                                       </div>
                                                   </div>
                                               </div>


                                               <div class="col-md-6">
                                                   <div class="form-group">
                                                       <h5>Primary Phone Number<span class="text-danger">*</span></h5>
                                                       <div class="controls">
                                                           <input type="tel" name="primary_phone"
                                                                  value="{{old('primary_phone')}}"
                                                                  class="form-control"
                                                                  required
                                                                  data-validation-required-message="This field is required">
                                                       </div>
                                                       @error('primary_phone')
                                                       <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                       @enderror
                                                   </div>
                                               </div>



                                               <div class="col-md-6">
                                                   <div class="form-group">
                                                       <label for="wlocation2"> City/Location : <span
                                                                   class="danger">*</span>
                                                       </label>
                                                       <select class="custom-select form-control"
                                                               id="districts" name='city_id'>
                                                           <option value='0'>Select city/location</option>

                                                       </select>
                                                       <div class="form-control-feedback">
                                                           <small><code>Pick a city in which you reside in here in
                                                                   zimbabwe.</code>
                                                           </small>
                                                       </div>
                                                   </div>
                                               </div>

                                               <div class="col-md-6">
                                                   <div class="form-group">
                                                       <h5>Secondary Phone Number <span class="text-danger">*</span></h5>
                                                       <div class="controls">
                                                           <input type="tel" name="secondary_phone"
                                                                  value="{{old('secondary_phone')}}"
                                                                  class="form-control"
                                                                  required
                                                                  data-validation-required-message="This field is required">
                                                       </div>
                                                       @error('secondary_phone')
                                                       <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                       @enderror
                                                   </div>
                                               </div>


                                           </div>

                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="submit" name="add"
                                                           class="btn btn-rounded btn btn-block btn-success"
                                                           value="Add Contact">
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
        </div>
    </div>
@endsection

@section('plugins-js')

    <script type="text/javascript">

        $(document).ready(function () {
            $("#provinces").change(function () {
                var province_id = $(this).val();
                //var dataString = id;

                $.ajax
                ({
                    type: "GET",
                    url: "/admin/get_districts/" + province_id,
                    data: province_id,
                    cache: false,
                    success: function (html) {
                        $("#districts").html(html);
                    }
                });
            });

        });
    </script>




@endsection
