@extends('layouts.admin')
@section('title','AHPCZ')
@section('plugins-css')

@endsection

<?php

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
                                <div class="card b-all shadow-none">
                                    <div class="inbox-center table-responsive">
                                        <table class="table table-hover no-wrap">
                                            <tbody>
                                            @foreach (auth()->user()->notifications()->paginate(10)->sortBy('read_at') as $userNotification)
                                                <tr style="color: {{$userNotification->read_at == null ? 'blue':'black' }}">
                                                    <td style="width:40px">
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="checkbox0" value="check">
                                                            <label for="checkbox0"></label>
                                                        </div>
                                                    </td>
                                                    <td style="width:40px" class="hidden-xs-down"><i
                                                            class="{{$userNotification->read_at == null ? 'fa fa-star-o':'fa fa-star' }}"></i></td>
                                                    <td class="hidden-xs-down">{{$userNotification->data['sender']['name']}}</td>
                                                    <td class="max-texts"><a href="/admin/{{$userNotification->id}}/read"/>
                                                        {{substr($userNotification->data['comment'],0,65)}} ....
                                                    </td>
                                                    {{--<td class="hidden-xs-down"><i class="fa fa-paperclip"></i></td>--}}
                                                    <td class="text-right"> {{getDiff($userNotification->created_at,now())}} ago</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        {{auth()->user()->notifications()->paginate(1)->links()}}
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
