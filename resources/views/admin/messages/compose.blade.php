@extends('layouts.admin')
@section('title','AHPCZ')
@section('plugins-css')

@endsection

<?php
use App\Practitioner;
use Carbon\CarbonInterval;

function getDiff($created_at, $now)
{
    $days = $created_at->diffInDays($now);
    $hours = $created_at->diffInHours($now->subDays($days));
    $minutes = $created_at->diffInMinutes($now->subHours($hours));
    $seconds = $created_at->diffInSeconds($now->subMinutes($minutes));

    return CarbonInterval::days($days)->hours($hours)->minutes($minutes)->seconds($seconds)->forHumans();
}
?>
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="row">
                        <div class="col-xlg-2 col-lg-3 col-md-4">
                            <div class="card-body inbox-panel"><a href="{{url('/admin/notification/compose')}}"
                                                                  class="btn btn-danger m-b-20 p-10 btn-block waves-effect waves-light">Compose</a>
                                <ul class="list-group list-group-full">
                                    <li class="list-group-item">
                                        <a href="{{url('admin/notification/inbox')}}"> <i class="mdi mdi-star"></i> All messages </a>
                                        <span class="badge badge-success ">{{count(auth()->user()->unreadNotifications)}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xlg-10 col-lg-9 col-md-8 bg-light border-left">
                            <div class="card-body p-t-0">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session('message'))
                                    <div class="alert alert-success alert-rounded"><i class="fa fa-check-circle"></i>  {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                    </div>
                                @endif
                                <div class="card b-all shadow-none">
                                    <div class="card-body">
                                        <h3 class="card-title m-b-0">New message</h3>
                                    </div>
                                    <div>
                                        <hr class="m-t-0">
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex m-b-40">
                                            <div class="p-l-10">
                                                <h4 class="m-b-0">{{auth()->user()->name}}</h4>
                                                <small
                                                    class="text-muted">Send From: {{auth()->user()->email}}
                                                </small><br/>

                                            </div>

                                        </div>
                                        <form action="/admin/notification/send" method="post" class="m-t-40"
                                              novalidate>
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <h5> Recipients <span class="text-danger">*</span></h5>
                                                <select class="custom-select form-control " required
                                                        id="user" name="user">
                                                    <option value="">Choose Recipient</option>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}" @if($user->id==old('user')){{'selected'}}@endif>{{$user->name}} ({{$user->role->name}})</option>
                                                    @endforeach
                                                </select>
                                                <h5> Subject <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="title" class="form-control">
                                                </div>

                                                <h5> Message <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <textarea name="comment" class="form-control"></textarea>
                                                </div>

                                                <input type="hidden" name="data_id" value="" class="form-control">


                                                <div class="form-control-feedback">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="submit"
                                                           class="btn btn-rounded btn btn-block btn-success"
                                                           value="Send new message">
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
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
    </div>
@endsection

@section('plugins-js')
    <script type="text/javascript">
        $(function () {
            $('.selectpicker').selectpicker();
        });
    </script>
@endsection
