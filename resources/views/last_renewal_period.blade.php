@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{session('message')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="row">
            <div style="margin-bottom: 3%;">
                <a href="{{url('/admin/practitioners/'.$practitioner->id)}}"
                   class="btn btn-success">Back to dashboard</a>
            </div>
            <div class="card">
                <div class="card-body dashboard-tabs p-0">
                    <div class="col-lg-12 tab-content py-0 px-0">
                        <div style="margin-top: 1%;" class="card">
                            <div class="card-header">
                                Last Renewal Period
                            </div>
                            <div class="card-body">
                                <div class="row small-spacing">
                                    <div class="table-responsive m-t-40">
                                        <h4 class="card-title">
                                            Dear {{$practitioner->first_name.' '.$practitioner->last_name}}</h4>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Oops!</strong> It seems like we do not have any record of your
                                            previous renewal payment, please do help us identify your last renewal
                                            period,
                                            select the year in which you last renewed your license with us.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div>
                                            <form method="post" action="{{url('/manual_restoration_penalties/'.$practitioner->id)}}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="wlocation2">Choose Your Last Renewal Period : <span
                                                            class="danger">*</span>
                                                    </label>
                                                    <select class="custom-select form-control " required
                                                            name="period">
                                                        <option value="">Choose period</option>
                                                        @for($x =date('Y')+10;$x >= 2008;$x--)
                                                            <option value="{{$x}}">{{$x}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                @if ($errors->any()) <span
                                                    style="color: red;"> @error('period'){{$message}}@enderror </span>
                                                @endif
                                                <input type="submit" value="Submit" class="btn btn-success">
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
