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
                                        <a href="{{url('admin/notification/inbox')}}"> <i class="mdi mdi-star"></i> All
                                            messages </a>
                                        <span
                                            class="badge badge-success ">{{count(auth()->user()->unreadNotifications)}}</span>
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
                                    <div class="alert alert-success alert-rounded"><i
                                            class="fa fa-check-circle"></i> {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                @endif
                                <div class="card b-all shadow-none">
                                    <div class="card-body">
                                        <h3 class="card-title m-b-0">{{$userNotification->data['title']}}</h3>
                                    </div>
                                    <div>
                                        <hr class="m-t-0">
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex m-b-40">
                                            <div class="p-l-10">
                                                <h4 class="m-b-0">
                                                    From: @if($userNotification->data['sender'])
                                                        {{$userNotification->data['sender']['name']}}@endif</h4>
                                                <small
                                                    class="text-muted"> @if($userNotification->data['sender'])
                                                        {{$userNotification->data['sender']['email']}}@endif
                                                </small><br/>
                                                <small
                                                    class="fa fa-clock-o"> {{getDiff($userNotification->created_at,now())}}
                                                    ago
                                                </small>
                                            </div>
                                        </div>
                                        <p><b>Dear {{auth()->user()->name}}</b></p>
                                        <p>{{$userNotification->data['comment']}}.</p>

                                        @if($userNotification->data['id'] != null)
                                            <a href="/admin/practitioners/{{$userNotification->data['id']}}"
                                               class="btn btn-warning btn-sm">View Application</a>
                                        @endif
                                    </div>
                                    <div>
                                        <hr class="m-t-0">
                                    </div>
                                    <div class="card-body">

                                        @if($userNotification->type == 'App\Notifications\ApplicationSubmitted')
                                            <a href="{{url('/reply/practitioner/'.$userNotification->data['id'])}}">Send email</a>
                                        @else
                                            <form action="/admin/notification/reply" method="post" class="m-t-40"
                                                  novalidate>
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <h5> Message <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <textarea name="comment" class="form-control"></textarea>
                                                    </div>

                                                    <div class="controls">
                                                        <input type="hidden" name="user"
                                                               value="@if($userNotification->data['sender'])
                                                               {{$userNotification->data['sender']['id']}}
                                                                   @endif"
                                                               class="form-control">
                                                    </div>
                                                    <div class="controls">
                                                        <input type="hidden" name="title"
                                                               value="{{$userNotification->data['title']}}"
                                                               class="form-control">
                                                    </div>

                                                    <div class="controls">
                                                        <input type="hidden" name="data_id"
                                                               value="{{$userNotification->data['id']}}"
                                                               class="form-control">
                                                    </div>
                                                    <div class="form-control-feedback">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="controls">
                                                        <input type="submit"
                                                               class="btn btn-rounded btn btn-block btn-success"
                                                               value="Reply">
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
