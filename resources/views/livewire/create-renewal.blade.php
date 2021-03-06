
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
                    <h4 class="card-title"> @if($renewal_criteria != null){{$renewal_criteria->percentage}}@else{{$message}}@endif</h4>
                        {{$renewal_criteria}}
                    <h6 class="card-subtitle">RenewalCategory:{{$renewal_category_id}} Emp_status:{{$employment_status_id}} Emp_location:{{$employment_location_id}} Certificate request:{{$certificate_request}} </h6>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-12 col-md-2 col-lg-2"></div>
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <form action="{{url('/admin/renewal_criterias')}}" method="post" class="m-t-40"
                          novalidate>
                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <h5 style="color: black; font-weight: bolder"> {{$dob}} Age: {{$age}}</h5>
                                <div>
                                    <div wire:ignore class="form-group">
                                        <label>Date Of Birth</label>
                                        @if($dob == null)
                                        <p style="color: red;">{{'Please enter your date of birth first before your proceed!'}}</p>
                                        @else
                                        <p style="color: red;">{{'Confirm date of birth, or enter one if you did not submit before!'}}</p>
                                        @endif
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">D.O.B</span>
                                            </div>
                                            <input wire:model="dob" type="text" class="form-control datepicker" aria-label="Dirt Of Birth"
                                                   value="{{$practitioner->dob}}"
                                                   data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy/mm/dd"
                                                   data-date-today-highlight="true"
                                                   onchange="this.dispatchEvent(new InputEvent('input'))"
                                            >

                                            {{--<div class="input-group-append">
                                                <span class="input-group-text">AGE: {{$dob}}</span>
                                            </div>--}}
                                        </div>
                                    </div>

                                </div>
                                <hr/>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <h5 style="color: black; font-weight: bolder">Employment Status</h5>
                                <p style="color: yellowgreen;">Please choose your employment status.</p>
                                @foreach($employment_statuses as $employment_status)
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input wire:model="employment_status_id" class="form-check-input"
                                                   type="radio"
                                                   name="employment_status_id"
                                                   id="exampleRadios1" value="{{$employment_status->id}}">
                                            <label class="form-check-label" for="exampleRadios1">
                                                {{$employment_status->name}}
                                            </label>
                                            <p style="color: red;">{{$employment_status->description}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <h5 style="color: black; font-weight: bolder">Residence</h5>
                                <p style="color: yellowgreen;">Choose if one should be either foreign based
                                    or local based</p>
                                @foreach($employment_locations as $employment_location)
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input wire:model="employment_location_id" class="form-check-input"
                                                   type="radio"
                                                   name="employment_location_id"
                                                   id="exampleRadios1"
                                                   value="{{$employment_location->id}} {{old('employment_location')}}">
                                            <label class="form-check-label" for="exampleRadios1">
                                                {{$employment_location->name}}
                                            </label>
                                            <p style="color: red;">{{$employment_location->description}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <h5 style="color: black; font-weight: bolder">Certificate request</h5>
                                <p style="color: yellowgreen;">Please specify if a certificate can be issued
                                    in
                                    this criteria.</p>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input wire:model="certificate_request" class="form-check-input" type="radio"
                                               name="certificate_request"
                                               id="exampleRadios1" value="1">
                                        <label class="form-check-label" for="exampleRadios1">
                                            {{'Yes'}}
                                        </label>
                                        <p style="color: red;">{{'A certificate is to be issued'}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input wire:model="certificate_request" class="form-check-input" type="radio"
                                               name="certificate_request"
                                               id="exampleRadios1" value="2">
                                        <label class="form-check-label" for="exampleRadios1">
                                            {{'No'}}
                                        </label>
                                        <p style="color: red;">{{'A certificate is not to be issued'}}</p>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <hr/>
                        <div class="row">
                            <div style="text-align: center;padding-left: 40%">
                                <div class="controls">
                                    <input type="submit" name="add" class="btn btn-success btn-block"
                                           value="Add New Renewal Criteria">
                                </div>
                            </div>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>
</div>






